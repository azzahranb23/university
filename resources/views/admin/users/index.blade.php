@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Manajemen Pengguna</h2>
                <p class="text-white/80 mt-1">Kelola semua pengguna sistem</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.create', 'student') }}"
                    class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Mahasiswa
                </a>
                <a href="{{ route('admin.users.create', 'lecturer') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Dosen
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Users -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Pengguna</p>
                    <h3 class="text-2xl font-semibold text-white">{{ number_format($stats['totalUsers']) }}</h3>
                </div>
                <div class="rounded-full bg-purple-500/10 p-3">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Mahasiswa -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Mahasiswa</p>
                    <h3 class="text-2xl font-semibold text-white">{{ number_format($stats['totalStudents']) }}</h3>
                </div>
                <div class="rounded-full bg-blue-500/10 p-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Dosen -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Dosen</p>
                    <h3 class="text-2xl font-semibold text-white">{{ number_format($stats['totalLecturers']) }}</h3>
                </div>
                <div class="rounded-full bg-yellow-500/10 p-3">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Proyek</p>
                    <h3 class="text-2xl font-semibold text-white">{{ number_format($stats['totalProjects']) }}</h3>
                </div>
                <div class="rounded-full bg-green-500/10 p-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-4 mb-6">
        <form id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select name="role" id="roleFilter"
                class="bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Role</option>
                <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="lecturer" {{ request('role') == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

            <select name="department" id="departmentFilter"
                class="bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Departemen</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}" {{ request('department') == $department->department_id ? 'selected' : '' }}>
                        {{ $department->department_name }}
                    </option>
                @endforeach
            </select>

            <select name="major" id="majorFilter"
                class="bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Program Studi</option>
                @foreach ($majors as $major)
                    <option value="{{ $major->major_id }}" {{ request('major') == $major->major_id ? 'selected' : '' }}>
                        {{ $major->major_name }}
                    </option>
                @endforeach
            </select>

            <div class="relative">
                <input type="text" name="search" id="searchInput" placeholder="Cari pengguna..." value="{{ request('search') }}"
                    class="w-full bg-gray-700 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="overflow-x-auto">
            <table id="usersTable" class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Info Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Departemen/Prodi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-700/50">
                            <!-- User Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}"
                                        alt="{{ $user->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-500">NIM/NIP: {{ $user->nim_nip }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $user->role === 'student'
                                        ? 'bg-blue-500/20 text-blue-400'
                                        : ($user->role === 'admin'
                                            ? 'bg-purple-500/20 text-purple-400'
                                            : 'bg-yellow-500/20 text-yellow-400') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <!-- Department/Major -->
                            <td class="px-6 py-4">
                                @if ($user->department)
                                    <div class="text-sm text-white">{{ $user->department->department_name }}</div>
                                @endif
                                @if ($user->major)
                                    <div class="text-xs text-gray-400">{{ $user->major->major_name }}</div>
                                @endif
                            </td>

                            <!-- Projects -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium bg-green-500/20 text-green-400">
                                    {{ $user->projects->count() }} Proyek
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="flex items-center">
                                    <span class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></span>
                                    <span class="text-sm text-gray-400">Aktif</span>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.users.show', $user->user_id) }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->user_id) }}"
                                    class="text-gray-400 hover:text-yellow-400 transition-colors">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button onclick="confirmDelete({{ $user->user_id }})" class="text-gray-400 hover:text-red-400 transition-colors">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-800 px-6 py-4 border-t border-gray-700">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Datatables Initialization -->
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                language: {
                    search: "",
                    searchPlaceholder: "Cari...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 10,
                dom: '<"flex flex-col md:flex-row justify-between items-start md:items-center mb-4"lf>rtip',
                drawCallback: function() {
                    // Styling untuk input search
                    $('.dataTables_filter input').addClass(
                        'bg-gray-700 text-white rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500'
                    );

                    // Styling untuk select length
                    $('.dataTables_length select').addClass(
                        'bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'
                    );

                    // Styling untuk pagination
                    $('.dataTables_paginate').addClass('mt-4 flex justify-end space-x-2');
                    $('.paginate_button').addClass(
                        'px-3 py-1 rounded-lg text-white transition-colors'
                    ).not('.disabled').addClass(
                        'hover:bg-gray-700'
                    );
                    $('.paginate_button.current').addClass('bg-blue-500');
                    $('.paginate_button.disabled').addClass('text-gray-600 cursor-not-allowed');
                }
            });

            // Event listener untuk filter role
            $('select[name="role"]').on('change', function() {
                var table = $('#usersTable').DataTable();
                table.column(1).search($(this).val()).draw();
            });

            // Event listener untuk filter departemen
            $('select[name="department"]').on('change', function() {
                var table = $('#usersTable').DataTable();
                table.column(2).search($(this).val()).draw();
            });
        });
    </script>

    <!-- SweetAlert Scripts untuk Delete Confirmation -->
    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data user akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form delete
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/users/${userId}`;
                    form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Script untuk upload preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Function untuk refresh data
            function refreshData() {
                $.ajax({
                    url: '{{ route('admin.users') }}',
                    type: 'GET',
                    data: $('#filterForm').serialize(),
                    beforeSend: function() {
                        // Tambahkan loading state jika diperlukan
                        $('#usersTable').addClass('opacity-50');
                    },
                    success: function(response) {
                        // Update tabel dan pagination
                        $('#usersTable tbody').html(response.users);
                        $('.pagination-container').html(response.pagination);
                        $('#usersTable').removeClass('opacity-50');
                    },
                    error: function(xhr) {
                        // Handle error
                        console.error('Error:', xhr);
                        $('#usersTable').removeClass('opacity-50');

                        // Tampilkan pesan error dengan SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat memuat data!'
                        });
                    }
                });
            }

            // Event handler untuk semua filter
            $('#roleFilter, #departmentFilter, #majorFilter').on('change', function() {
                refreshData();
            });

            // Event handler untuk search dengan debounce
            let searchTimeout;
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    refreshData();
                }, 500); // Delay 500ms
            });

            // Event handler untuk form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                refreshData();
            });
        });
    </script>
@endsection
