<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables Core -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>

</head>

<body class="h-full bg-gray-900">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-gray-800 border-r border-gray-700/50">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex h-16 items-center justify-center border-b border-gray-700/50">
                    <span class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                        Project Dashboard
                    </span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1 px-2 py-4">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <!-- Users -->
                    <a href="{{ route('admin.users') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.users') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>

                    <!-- Categories -->
                    <a href="{{ route('admin.categories') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.categories') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Categories
                    </a>

                    <!-- Departments -->
                    <a href="{{ route('admin.departments') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.departments') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Departments
                    </a>

                    <!-- Program Studi -->
                    <a href="{{ route('admin.majors') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.majors') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Program Studi
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-700/50 my-4"></div>

                    <!-- Projects -->
                    <a href="{{ route('admin.projects') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.projects') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Projects
                    </a>

                    <!-- Aplications -->
                    <a href="{{ route('admin.applications') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.applications') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                        Applications
                    </a>

                    <!-- Penugasan -->
                    <a href="{{ route('admin.project-contents') }}"
                        class="group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.project-contents') ? 'bg-gray-700/50 text-emerald-400' : 'text-gray-300 hover:bg-gray-700/50 hover:text-emerald-400' }} transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                        Penugasan
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-700/50 my-4"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full group flex items-center gap-x-3 rounded-lg px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700/50 hover:text-red-400 transition-all duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>

                <!-- User Info -->
                <div class="border-t border-gray-700/50 p-4">
                    <div class="flex items-center gap-3">
                        <img class="h-8 w-8 rounded-lg object-cover"
                            src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.jpg') }}"
                            alt="Profile">
                        <div>
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="pl-64">
            <!-- Main Content Area -->
            <main class="min-h-screen bg-gray-900 p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500,
                background: '#1F2937', // bg-gray-800
                color: '#FFF'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                showConfirmButton: true,
                confirmButtonColor: '#EF4444', // red-500
                background: '#1F2937', // bg-gray-800
                color: '#FFF'
            });
        </script>
    @endif
</body>

</html>
