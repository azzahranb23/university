<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    
    private function loginViaApi($username, $password)
    {
        try {
            $apiUsername = env('API_USERNAME', 'default_username');
            $apiPassword = env('API_PASSWORD', 'default_password');
            $apiKeyName = env('API_KEY_NAME', 'default_key_name');
            $apiKeySecret = env('API_KEY_SECRET', 'default_key_secret');
            $apiUrl = env('API_URL', 'https://api.upnvj.ac.id/data/auth_mahasiswa');

            $response = Http::asForm() // Pastikan data dikirim sebagai x-www-form-urlencoded
                ->withBasicAuth($apiUsername, $apiPassword)
                ->withHeaders([
                    'API_KEY_NAME' => $apiKeyName,
                    'API_KEY_SECRET' => $apiKeySecret,
                ])
                ->post($apiUrl, [
                    'username' => $username,
                    'password' => $password,
                ]);
    
            Log::info('Request sent to API with body:', [
                'username' => $username,
                'password' => $password,
            ]);
    
            // Log response untuk debugging
            Log::info('API Response:', $response->json());
    
            // Kembalikan respons dalam bentuk JSON
            return $response->json();
        } catch (\Exception $e) {
            // Tangani kesalahan API dan log pesan error
            Log::error('API Login Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menghubungi API. Silakan coba lagi.'];
        }
    }
    
    private function getDepartmentId($majorId)
    {
        $major = DB::table('majors')->where('major_id', $majorId)->first();
        return $major ? $major->department_id : null;
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nim_nip' => 'required',
            'password' => 'required'
        ]);
    
        try {
            // Cek login lokal
            if (Auth::attempt(['nim_nip' => $credentials['nim_nip'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Login berhasil!');
            }
    
            // Login via API
            $apiResponse = $this->loginViaApi($credentials['nim_nip'], $credentials['password']);
    
            // Debugging API Response
            Log::info('API Response:', $apiResponse);
    
            // Pastikan API berhasil
            if (isset($apiResponse['success']) && $apiResponse['success']) {
                $data = $apiResponse['data']; // Data dari API
    
                // Validasi apakah key 'nim' dan 'id_program_studi' ada
                if (!isset($data['nim'])) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'login_error' => 'NIM/NIP tidak ditemukan. Silakan periksa kembali data Anda.'
                        ])
                        ->with('error', 'Gagal masuk. Periksa kembali NIM/NIP dan Password Anda.');
                }
    
                if (!in_array($data['id_program_studi'], [1, 2, 3, 4])) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'login_error' => 'Maaf, Anda bukan mahasiswa FIK.'
                        ])
                        ->with('error', 'Maaf, Anda bukan mahasiswa FIK.');
                }
    
                // Cek apakah NIM atau email sudah terdaftar
                $existingUser = User::where('nim_nip', $data['nim'])
                    ->orWhere('email', $data['email'])
                    ->first();
    
                if ($existingUser) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'login_error' => 'NIM atau email Anda sudah terdaftar. Silakan login menggunakan akun yang sudah ada.'
                        ])
                        ->with('error', 'Akun sudah terdaftar.');
                }
    
                // Simpan atau update user di database
                $user = User::updateOrCreate(
                    ['nim_nip' => $data['nim']], // Gunakan NIM untuk menemukan atau membuat user
                    [
                        'api_login' => true,
                        'name' => $data['nama'] ?? 'Unknown',
                        'email' => $data['email'] ?? null,
                        'phone' => $data['hp'] ?? null,
                        'gender' => $data['jeniskelamin'] === 'L' ? 'male' : 'female',
                        'year' => $data['angkatan'] ?? null,
                        'major_id' => $data['id_program_studi'] ?? null,
                        'department_id' => $this->getDepartmentId($data['id_program_studi'] ?? null),
                        'role' => 'student',
                        'password' => bcrypt($credentials['password']),
                    ]
                );

                // Pastikan api_login diset ke true
                $user->api_login = true;
                $user->save();
    
                // Login user setelah berhasil disinkronisasi
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Login berhasil');
            }
    
            return back()
                ->withInput()
                ->withErrors([
                    'login_error' => 'Login gagal. Periksa kembali NIM/NIP dan password Anda.'
                ])
                ->with('error', 'Gagal masuk.');
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
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
