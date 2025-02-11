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

        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl border border-teal-100 p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Login ke Project System</h1>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="nim_nip" class="block text-sm font-medium text-gray-700">NIM/NIP</label>
                        <input type="text" name="nim_nip" id="nim_nip" required
                            class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                        @error('nim_nip')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required
                            class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                        @error('password')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 rounded-lg text-white bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transform transition-all hover:scale-[1.02]">
                            Masuk
                        </button>
                    </div>

                    {{-- <div class="text-center text-sm text-gray-600">
                        Belum punya akun?
                        <button type="button" onclick="window.location.href='{{ route('register') }}?role=mahasiswa'"
                            class="font-medium text-teal-600 hover:text-teal-700 transition-colors">
                            Daftar
                        </button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</body>

</html>
