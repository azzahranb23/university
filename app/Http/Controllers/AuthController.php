<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     try {
    //         $credentials = $request->validate([
    //             'nim_nip' => 'required',
    //             'password' => 'required'
    //         ]);

    //         if (Auth::attempt(['nim_nip' => $credentials['nim_nip'], 'password' => $credentials['password']])) {
    //             $request->session()->regenerate();

    //             // Redirect berdasarkan role
    //             if (Auth::user()->role === 'admin') {
    //                 return redirect()->route('admin.dashboard');
    //             }

    //             return redirect()->intended('/')->with('success', 'Login berhasil!');
    //         }

    //         return back()
    //             ->withInput()
    //             ->withErrors([
    //                 'login_error' => 'NIM/NIP atau Password salah.',
    //                 'nim_nip' => 'NIM/NIP tidak ditemukan.'
    //             ])
    //             ->with('error', 'Gagal masuk. Silakan periksa kembali NIM/NIP dan Password Anda.');
    //     } catch (\Exception $e) {
    //         return back()
    //             ->withInput()
    //             ->withErrors(['system_error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])
    //             ->with('error', 'Terjadi kesalahan. Silakan coba beberapa saat lagi.');
    //     }
    // }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'nim_nip' => 'required',
                'password' => 'required'
            ]);

            $apiUrl = 'https://api.upnvj.ac.id/data/auth_mahasiswa';

            if (Auth::attempt(['nim_nip' => $credentials['nim_nip'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();

                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->intended('/')->with('success', 'Login berhasil!');
            }

            $response = Http::withBasicAuth('uakademik', 'VTUzcjRrNGRlbTFrMjAyNCYh')
                ->withHeaders([
                    'API_KEY_NAME' => 'X-UPNVJ-API-KEY',
                    'API_KEY_SECRET' => 'Cspwwxq5SyTOMkq8XYcwZ1PMpYrYCwrv'
                ])
                ->post($apiUrl, [
                    'username' => $credentials['nim_nip'],
                    'password' => $credentials['password']
                ]);

            if ($response->successful()) {
                $apiData = $response->json();

                $user = User::where('nim_nip', $credentials['nim_nip'])->first();

                if (!$user) {
                    $user = User::create([
                        'user_id' => $apiData['user_id'],
                        'name' => $apiData['name'],
                        'email' => $apiData['email'],
                        'password' => bcrypt($credentials['password']),
                        'role' => $apiData['role'],
                        'photo' => $apiData['photo'],
                        'nim_nip' => $apiData['nim_nip'],
                        'year' => $apiData['year'],
                        'major_id' => $apiData['major_id'],
                        'departemen_id' => $apiData['departemen_id'],
                    ]);
                } else {
                    $user->update([
                        'name' => $apiData['name'],
                        'email' => $apiData['email'],
                        'role' => $apiData['role'],
                        'photo' => $apiData['photo'],
                        'year' => $apiData['year'],
                        'major_id' => $apiData['major_id'],
                        'departemen_id' => $apiData['departemen_id'],
                    ]);
                }

                Auth::login($user);

                $request->session()->regenerate();

                return redirect()->intended('/')->with('success', 'Login berhasil!');
            }

            return back()
                ->withInput()
                ->withErrors([
                    'login_error' => 'NIM/NIP atau Password salah.',


                ])
                ->with('error', 'Gagal masuk. Silakan periksa kembali NIM/NIP dan Password Anda.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['system_error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])
                ->with('error', 'Terjadi kesalahan. Silakan coba beberapa saat lagi.');
        }
    }

    public function showRegistrationForm(Request $request)
    {
        if (!in_array($request->query('role'), ['mahasiswa', 'dosen'])) {
            return redirect('/');
        }

        $majors = Major::all();
        $departments = Department::all();

        return view('auth.register', [
            'majors' => $majors,
            'departments' => $departments,
            'role' => $request->query('role')
        ]);
    }

    public function register(Request $request)
    {
        try {
            $baseRules = [
                'name' => 'required|string|max:255',
                'nim_nip' => 'required|string|unique:users',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'gender' => 'required|in:male,female',
                'phone' => 'required|string|min:10|max:13'
            ];

            $role = $request->role === 'mahasiswa' ? 'student' : 'lecturer';
            $rules = $baseRules;

            if ($role === 'student') {
                $rules['major_id'] = 'required|exists:majors,major_id';
            } else {
                $rules['department_id'] = 'required|exists:departments,department_id';
            }

            $userData = [
                'name' => $request->name,
                'nim_nip' => $request->nim_nip,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'year' => date('Y')
            ];

            if ($role === 'student') {
                $userData['major_id'] = $request->major_id;
            } else {
                $userData['department_id'] = $request->department_id;
            }

            $user = User::create($userData);
            Auth::login($user);

            return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang ' . $user->name);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['system_error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'])
                ->with('error', 'Pendaftaran gagal. Silakan coba beberapa saat lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
