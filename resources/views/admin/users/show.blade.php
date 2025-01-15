@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Detail {{ $user->role === 'student' ? 'Mahasiswa' : 'Dosen' }}</h2>
                <p class="text-white/80 mt-1">Informasi lengkap user</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.users') }}"
                    class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user->user_id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="text-center mb-6">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}" alt="Profile Photo"
                    class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                <h3 class="text-xl font-semibold text-white">{{ $user->name }}</h3>
                <span
                    class="px-3 py-1 text-sm rounded-full
                    {{ $user->role === 'student'
                        ? 'bg-blue-500/20 text-blue-400'
                        : ($user->role === 'admin'
                            ? 'bg-purple-500/20 text-purple-400'
                            : 'bg-yellow-500/20 text-yellow-400') }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-sm">Email</p>
                    <p class="text-white">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">{{ $user->role === 'student' ? 'NIM' : 'NIP' }}</p>
                    <p class="text-white">{{ $user->nim_nip }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Nomor Telepon</p>
                    <p class="text-white">{{ $user->phone }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Jenis Kelamin</p>
                    <p class="text-white">{{ $user->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                @if ($user->role === 'student')
                    <div>
                        <p class="text-gray-400 text-sm">Program Studi</p>
                        <p class="text-white">{{ $user->major->major_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Angkatan</p>
                        <p class="text-white">{{ $user->year }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-gray-400 text-sm">Departemen</p>
                    <p class="text-white">{{ $user->department->department_name ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Projects & Activities -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Projects -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <h4 class="text-lg font-semibold text-white mb-4">Proyek</h4>
                @if ($user->projects->count() > 0)
                    <div class="space-y-4">
                        @foreach ($user->projects as $project)
                            <div class="bg-gray-700/50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="text-white font-medium">{{ $project->title }}</h5>
                                        <p class="text-gray-400 text-sm">{{ $project->category->category_name }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                        {{ $project->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400">Belum ada proyek</p>
                @endif
            </div>

            <!-- Applications -->
            @if ($user->role === 'student')
                <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                    <h4 class="text-lg font-semibold text-white mb-4">Aplikasi</h4>
                    @if ($user->applications->count() > 0)
                        <div class="space-y-4">
                            @foreach ($user->applications as $application)
                                <div class="bg-gray-700/50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h5 class="text-white font-medium">{{ $application->project->title }}</h5>
                                            <p class="text-gray-400 text-sm">{{ $application->position }}</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                            {{ $application->status === 'accepted'
                                                ? 'bg-green-500/20 text-green-400'
                                                : ($application->status === 'pending'
                                                    ? 'bg-yellow-500/20 text-yellow-400'
                                                    : 'bg-red-500/20 text-red-400') }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400">Belum ada aplikasi</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ showDeleteModal: false }">
        <button @click="showDeleteModal = true"
            class="fixed bottom-8 right-8 bg-red-500 hover:bg-red-600 text-white p-4 rounded-full shadow-lg flex items-center justify-center transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>

        <!-- Modal -->
        <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black opacity-50"></div>

                <!-- Modal Content -->
                <div class="relative bg-gray-800 rounded-lg p-8 max-w-md w-full">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-white mb-2">Konfirmasi Hapus</h3>
                        <p class="text-gray-400 mb-6">Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>

                        <div class="flex justify-center gap-4">
                            <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all">
                                Batal
                            </button>
                            <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all">
                                    Hapus User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
