<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-teal-50 to-white min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <!-- Back Button -->
        <div class="absolute top-4 left-4">
            <a href="/"
                class="group px-4 py-2 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-2 text-teal-600 hover:text-teal-700 border border-teal-100">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Home</span>
            </a>
        </div>

        <!-- Main Form Container -->
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-xl border border-teal-100 p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Sign Up to Project System</h1>
                <div class="inline-flex items-center justify-center px-4 py-2 bg-teal-50 rounded-full">
                    @if (request('role') === 'mahasiswa')
                        <span class="text-lg font-semibold text-teal-600">Mahasiswa</span>
                    @else
                        <span class="text-lg font-semibold text-teal-600">Dosen</span>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="{{ request('role')}}">

                <!-- NIM Field -->
                <div class="form-group">
                    <label for="register_nim_nip" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ request('role') === 'dosen' ? 'NIP' : 'NIM' }}
                    </label>
                    <input type="text" name="nim_nip" id="register_nim_nip" required
                        placeholder="{{ request('role') === 'dosen' ? 'Masukkan NIP' : 'Masukkan NIM' }}"
                        class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
    hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
    placeholder-gray-400 shadow-sm hover:shadow-md">
                    @error('nim')
                        <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Name & Email Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="register_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="register_name" required placeholder="Masukkan nama lengkap"
                            class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                               hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                               placeholder-gray-400 shadow-sm hover:shadow-md">
                        @error('name')
                            <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="register_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="register_email" required placeholder="email@example.com"
                            class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                               hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                               placeholder-gray-400 shadow-sm hover:shadow-md">
                        @error('email')
                            <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Major & Gender Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if (request('role') === 'mahasiswa')
                        <div class="form-group">
                            <label for="register_major" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                            <select name="major_id" id="register_major" required
                                class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                shadow-sm hover:shadow-md appearance-none
                bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')]
                bg-[length:1.25rem_1.25rem] bg-no-repeat bg-[right_0.5rem_center]">
                                <option value="">Pilih Program Studi</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->major_id }}">{{ $major->major_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="register_department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="department_id" id="register_department" required
                                class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                shadow-sm hover:shadow-md appearance-none
                bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')]
                bg-[length:1.25rem_1.25rem] bg-no-repeat bg-[right_0.5rem_center]">
                                <option value="">Pilih Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="register_gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="gender" id="register_gender" required
                            class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                                hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                                shadow-sm hover:shadow-md appearance-none
                                bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')]
                                bg-[length:1.25rem_1.25rem] bg-no-repeat bg-[right_0.5rem_center]">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                        @error('gender')
                            <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Phone & Password Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="register_phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="tel" name="phone" id="register_phone" required placeholder="08xxxxxxxxxx"
                            class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
               hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
               placeholder-gray-400 shadow-sm hover:shadow-md">
                        @error('phone')
                            <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="register_password" required placeholder="********"
                                class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                   hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                   placeholder-gray-400 shadow-sm hover:shadow-md">
                        </div>
                        <div>
                            <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation" id="register_password_confirmation" required
                                placeholder="********"
                                class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
                   hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
                   placeholder-gray-400 shadow-sm hover:shadow-md">
                        </div>
                        @error('password')
                            <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 px-4 text-white bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 rounded-lg font-medium transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Daftar Sekarang
                    </button>
                </div>

                @if ($errors->any())
                    <div class="mt-4 p-4 rounded-lg bg-red-50 border border-red-200">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-700 transition-colors">
                        Masuk
                    </a>
                </div>
            </form>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
