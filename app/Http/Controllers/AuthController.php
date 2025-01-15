<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Https;

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
            // URL endpoint API untuk autentikasi mahasiswa
            $apiUrl = 'https://api.upnvj.ac.id/data/auth_mahasiswa';

            // Validasi input request
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            // Coba autentikasi melalui database lokal terlebih dahulu
            if (Auth::attempt(['nim_nip' => $credentials['nim_nip'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();

                // Redirect berdasarkan role dari database lokal
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->intended('/')->with('success', 'Login berhasil!');
            }

            // Jika autentikasi melalui database gagal, coba autentikasi melalui API eksternal
            $response = Http::withBasicAuth('uakademik', 'VTUzcjRrNGRlbTFrMjAyNCYh')
                ->withHeaders([
                    'API_KEY_NAME' => 'X-UPNVJ-API-KEY',
                    'API_KEY_SECRET' => 'Cspwwxq5SyTOMkq8XYcwZ1PMpYrYCwrv'
                ])
                ->post($apiUrl, [
                    'username' => $credentials['nim_nip'],
                    'password' => $credentials['password']
                ]);

            if ($response->successful() && $response->json('success')) {
                $apiUser = $response->json('data');

                // Simpan atau perbarui data user dari API ke dalam database lokal
                $user = User::updateOrCreate(
                    ['nim_nip' => $apiUser['nim']],
                    [
                        'name' => $apiUser['nama'],
                        'email' => $apiUser['email'],
                        'password' => bcrypt($credentials['password']), // Menyimpan password terenkripsi
                        'role' => 'user', // Default role, sesuaikan jika ada informasi role
                        'photo' => null, // Default photo
                        'year' => $apiUser['angkatan'],
                        'major_id' => $apiUser['id_program_studi'],
                        'departemen_id' => $apiUser['kode_fakultas'],
                    ]
                );

                // Login menggunakan data user yang disimpan
                Auth::login($user);
                $request->session()->regenerate();

                // Redirect berdasarkan role (jika diperlukan)
                if ($user->role === 'admin') {


                    return redirect()->route('admin.dashboard');
                }

                return redirect()->intended('/')->with('success', 'Login berhasil!');
            }

            // Jika kedua metode autentikasi gagal
            return back()
                ->withInput()
                ->withErrors([
                    'login_error' => 'NIM/NIP atau Password salah. Silakan coba lagi.'
                ]);
        } catch (\Exception $e) {
            // Penanganan kesalahan sistem
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
