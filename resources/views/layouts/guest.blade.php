<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full antialiased bg-gray-50"
    x-data="{
        openLoginModal: false,
        openRoleModal: false,
        mobileMenu: false
    }"
    @open-login-modal.window="openLoginModal = true">
    <div class="min-h-screen">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}

            <!-- Footer -->
            <footer class="bg-black text-white py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <p class="text-gray-400">&copy; {{ date('Y') }} UPN Veteran Jakarta. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </main>

        @include('layouts.partials.login-modal')
        @include('layouts.partials.role-modal')

    </div>

    @stack('scripts')

</body>

</html>
