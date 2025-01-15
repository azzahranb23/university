@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-white text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-white/80 mt-1">Berikut adalah ringkasan aktivitas sistem</p>
            </div>
            <div class="text-white text-right">
                <p class="text-sm opacity-80">{{ now()->format('l, d F Y') }}</p>
                <p class="text-2xl font-bold">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Users Stats -->
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm">Total Pengguna</p>
                    <h3 class="text-white text-2xl font-bold">{{ number_format($stats['totalUsers']) }}</h3>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['totalStudents']) }} Mahasiswa
                </span>
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['totalLecturers']) }} Dosen
                </span>
            </div>
        </div>

        <!-- Projects Stats -->
        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm">Total Proyek</p>
                    <h3 class="text-white text-2xl font-bold">{{ number_format($stats['totalProjects']) }}</h3>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['activeProjects']) }} Aktif
                </span>
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['completedProjects']) }} Selesai
                </span>
            </div>
        </div>

        <!-- Applications Stats -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm">Total Aplikasi</p>
                    <h3 class="text-white text-2xl font-bold">{{ number_format($stats['totalApplications']) }}</h3>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['pendingApplications']) }} Pending
                </span>
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['acceptedApplications']) }} Diterima
                </span>
            </div>
        </div>

        <!-- Academic Stats -->
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm">Total Departemen</p>
                    <h3 class="text-white text-2xl font-bold">{{ number_format($stats['totalDepartments']) }}</h3>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['totalMajors']) }} Program Studi
                </span>
                <span class="bg-white/20 text-white rounded-full px-2 py-1">
                    {{ number_format($stats['totalCategories']) }} Kategori
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Proyek Terbaru</h3>
                <a href="{{ route('admin.projects') }}" class="text-teal-400 hover:text-teal-300 text-sm">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-4">
                @foreach ($stats['recentProjects'] as $project)
                    <div class="flex items-center p-4 bg-gray-700/50 rounded-lg">
                        <img src="{{ $project->photo ? asset($project->photo) : asset('images/default-project.jpg') }}"
                            class="w-12 h-12 rounded object-cover" alt="{{ $project->title }}">
                        <div class="ml-4 flex-1">
                            <h4 class="text-white font-medium">{{ $project->title }}</h4>
                            <p class="text-gray-400 text-sm">{{ $project->user->name }}</p>
                        </div>
                        <span
                            class="px-2 py-1 text-xs rounded-full
                            {{ $project->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Pengguna Terbaru</h3>
                <a href="{{ route('admin.users') }}" class="text-teal-400 hover:text-teal-300 text-sm">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-4">
                @foreach ($stats['recentUsers'] as $user)
                    <div class="flex items-center p-4 bg-gray-700/50 rounded-lg">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}"
                            class="w-12 h-12 rounded-full" alt="{{ $user->name }}">
                        <div class="ml-4 flex-1">
                            <h4 class="text-white font-medium">{{ $user->name }}</h4>
                            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                        </div>
                        <span
                            class="px-2 py-1 text-xs rounded-full
                            {{ $user->role === 'student'
                                ? 'bg-blue-500/20 text-blue-400'
                                : ($user->role === 'lecturer'
                                    ? 'bg-yellow-500/20 text-yellow-400'
                                    : 'bg-purple-500/20 text-purple-400') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-white mb-4">Distribusi Proyek per Kategori</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($stats['categoryProjects'] as $category)
                <div class="bg-gray-700/50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <img src="{{ $category->image ? asset($category->image) : asset('images/default-category.jpg') }}"
                            class="w-10 h-10 rounded object-cover" alt="{{ $category->category_name }}">
                        <div class="ml-3">
                            <h4 class="text-white text-sm font-medium">{{ $category->category_name }}</h4>
                            <p class="text-teal-400 text-lg font-bold">{{ $category->projects_count }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Application & Content Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Applications -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Aplikasi Terbaru</h3>
                <a href="{{ route('admin.applications') }}" class="text-blue-400 hover:text-blue-300 text-sm">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-4">
                @foreach ($stats['recentApplications'] as $application)
                    <div class="bg-gray-700/50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ $application->user->photo ? asset($application->user->photo) : asset('images/default-avatar.jpg') }}"
                                    alt="{{ $application->user->name }}">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-white">{{ $application->user->name }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $application->project->title }} - {{ $application->position }}
                                    </div>
                                </div>
                            </div>
                            <span
                                class="px-2 py-1 text-xs rounded-full font-medium
                            {{ $application->status === 'accepted'
                                ? 'bg-green-500/20 text-green-400'
                                : ($application->status === 'rejected'
                                    ? 'bg-red-500/20 text-red-400'
                                    : 'bg-yellow-500/20 text-yellow-400') }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Deadline Terdekat</h3>
                <a href="{{ route('admin.project-contents') }}" class="text-blue-400 hover:text-blue-300 text-sm">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-4">
                @foreach ($stats['upcomingDeadlines'] as $content)
                    <div class="bg-gray-700/50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-white">{{ $content->title }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $content->application->user->name }} • {{ $content->project->title }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-medium text-white">
                                    {{ \Carbon\Carbon::parse($content->due_date)->format('d M Y') }}
                                </div>
                                <div
                                    class="text-xs {{ \Carbon\Carbon::parse($content->due_date)->diffInDays(now()) <= 3 ? 'text-red-400' : 'text-gray-400' }}">
                                    {{ \Carbon\Carbon::parse($content->due_date)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Applications Overview -->
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-400">Status Aplikasi</h4>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-yellow-400">Pending</span>
                    <span class="text-white">{{ $stats['pendingApplications'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-green-400">Diterima</span>
                    <span class="text-white">{{ $stats['acceptedApplications'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-red-400">Ditolak</span>
                    <span class="text-white">{{ $stats['rejectedApplications'] }}</span>
                </div>
            </div>
        </div>

        <!-- Project Contents Overview -->
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-400">Status Konten</h4>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-blue-400">Total</span>
                    <span class="text-white">{{ $stats['totalContents'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-green-400">Link Ada</span>
                    <span class="text-white">{{ $stats['withLink'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-yellow-400">Belum Ada Link</span>
                    <span class="text-white">{{ $stats['withoutLink'] }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
