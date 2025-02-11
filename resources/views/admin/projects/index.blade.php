@extends('layouts.admin')

@section('title', 'Manajemen Proyek')

@section('content')
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-violet-600 to-fuchsia-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Manajemen Proyek</h2>
                <p class="text-white/80 mt-1">Kelola semua proyek dari dosen</p>
            </div>
            <button id="btnAddProject" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Proyek
            </button>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-violet-500/10 p-3">
                    <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Total Proyek</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['totalProjects'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-green-500/10 p-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Proyek Aktif</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['activeProjects'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-500/10 p-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Total Aplikasi</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['totalApplications'] }}</h3>
                    <p class="text-sm text-gray-500">
                        <span class="text-yellow-400">{{ $stats['pendingApplications'] }} pending</span> •
                        <span class="text-green-400">{{ $stats['acceptedApplications'] }} diterima</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Completed Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-yellow-500/10 p-3">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Proyek Selesai</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['completedProjects'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <form action="{{ route('admin.projects') }}" method="GET" class="flex items-center gap-4">
            <div class="flex-1">
                <select name="status"
                    class="block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white px-4 py-2">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-500 transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.projects') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                Reset
            </a>
        </form>
    </div>

    <!-- Projects Table -->
    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <table id="projectsTable" class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Dosen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Aplikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($projects as $project)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-lg object-cover"
                                        src="{{ $project->photo ? asset($project->photo) : asset('images/projects/default.jpg') }}"
                                        alt="{{ $project->title }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $project->title }}</div>
                                        <div class="text-sm text-gray-400">{{ Str::limit($project->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ $project->user->photo ? asset($project->user->photo) : asset('images/default-avatar.jpg') }}"
                                        alt="{{ $project->user->name }}">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-white">{{ $project->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $project->user->department->department_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-violet-500/20 text-violet-400">
                                    {{ $project->category->category_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-400">
                                        {{ $project->pending_applications_count }} Pending
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400">
                                        {{ $project->accepted_applications_count }} Diterima
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $project->status === 'active' ? 'bg-green-500/20 text-green-400' : ($project->status === 'completed' ? 'bg-blue-500/20 text-blue-400' : 'bg-gray-500/20 text-gray-400') }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="btn-edit text-blue-400 hover:text-blue-600 mr-3" data-id="{{ $project->project_id }}"
                                    data-project="{{ json_encode($project) }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="btn-delete text-red-400 hover:text-red-600" data-id="{{ $project->project_id }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="modal fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block w-full max-w-4xl bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                <form id="createForm" action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-medium text-white">Tambah Proyek</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-200 btn-close-modal">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6 space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Judul Proyek</label>
                                    <input type="text" name="title" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Kategori</label>
                                    <select name="category_id" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Durasi</label>
                                    <input type="text" name="duration" required placeholder="Contoh: 3 Bulan"
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                </div>

                                <!-- Posisi yang Dibutuhkan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Posisi yang Dibutuhkan</label>
                                    <div id="positions-container" class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="positions[]" required placeholder="Contoh: Frontend Developer"
                                                class="flex-1 bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                            <button type="button" onclick="addPosition()"
                                                class="px-3 py-1.5 text-xs font-medium text-teal-500 bg-teal-500/10 rounded-lg hover:bg-teal-500/20">
                                                + Posisi
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">User</label>
                                    <select name="user_id" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                        <option value="">Pilih User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Deskripsi</label>
                                    <textarea name="description" rows="4" required placeholder="Deskripsikan proyek..."
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Benefits</label>
                                    <textarea name="benefits" rows="4" required placeholder="Contoh:&#10;- Sertifikat&#10;- Uang Saku&#10;- Pengalaman Proyek"
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white"></textarea>
                                </div>

                                <!-- Upload Foto -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Foto Proyek</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 border-dashed rounded-lg">
                                        <div class="space-y-2 text-center">
                                            <img id="preview-img" src="#" alt="Preview"
                                                class="hidden mx-auto h-24 w-24 object-cover rounded-lg">
                                            <div class="flex text-sm text-gray-400">
                                                <label
                                                    class="relative cursor-pointer rounded px-3 py-2 bg-gray-700 hover:bg-gray-600 text-sm font-medium text-teal-500 hover:text-teal-400">
                                                    <span>Upload foto</span>
                                                    <input type="file" name="photo" class="sr-only" accept="image/*"
                                                        onchange="previewImage(event)">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-900/50 px-6 py-4 flex justify-end gap-3">
                        <button type="button" class="btn-cancel px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block w-full max-w-4xl bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-medium text-white">Edit Proyek</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-200 btn-close-modal">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6 space-y-6">
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Judul Proyek</label>
                                    <input type="text" name="title" id="editTitle" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Kategori</label>
                                    <select name="category_id" id="editCategory" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Durasi</label>
                                    <input type="text" name="duration" id="editDuration" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white"
                                        placeholder="Contoh: 3 Bulan">
                                </div>

                                <!-- Posisi yang Dibutuhkan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Posisi yang Dibutuhkan</label>
                                    <div id="editPositionsContainer" class="space-y-2">
                                        <!-- Positions will be populated by JavaScript -->
                                    </div>
                                    <button type="button" onclick="addEditPosition()"
                                        class="mt-2 px-3 py-1.5 text-xs font-medium text-teal-500 bg-teal-500/10 rounded-lg hover:bg-teal-500/20">
                                        + Posisi
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">User</label>
                                    <select name="user_id" id="editUser" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                                        <option value="">Pilih User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Deskripsi</label>
                                    <textarea name="description" id="editDescription" rows="4" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white"
                                        placeholder="Deskripsikan proyek..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Benefits</label>
                                    <textarea name="benefits" id="editBenefits" rows="4" required
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white"
                                        placeholder="Contoh:&#10;- Sertifikat&#10;- Uang Saku&#10;- Pengalaman Proyek"></textarea>
                                </div>

                                <!-- Upload Foto -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Foto Proyek</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 border-dashed rounded-lg">
                                        <div class="space-y-2 text-center">
                                            <!-- Preview Container -->
                                            <div class="mb-4">
                                                <img id="editPreviewImg" src="#" alt="Preview"
                                                    class="hidden mx-auto h-32 w-32 object-cover rounded-lg">
                                            </div>
                                            <!-- Upload Container -->
                                            <div class="flex text-sm text-gray-400">
                                                <label
                                                    class="relative cursor-pointer rounded px-3 py-2 bg-gray-700 hover:bg-gray-600 text-sm font-medium text-teal-500 hover:text-teal-400">
                                                    <span>Ganti foto</span>
                                                    <input id="editPhoto" type="file" name="photo" class="sr-only" accept="image/*"
                                                        onchange="previewEditImage(event)">
                                                </label>
                                                <p class="pl-1 pt-2">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                            <p class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah foto</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-900/50 px-6 py-4 flex justify-end gap-3">
                        <button type="button" class="btn-cancel px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#projectsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                },
                pageLength: 10,
                ordering: true,
                responsive: true
            });

            // Add Project Button
            $('#btnAddProject').click(function() {
                $('#createModal').removeClass('hidden');
            });

            // Edit Project Button
            $('.btn-edit').click(function() {
                const projectData = $(this).data('project');

                // Set form action
                $('#editForm').attr('action', `/admin/projects/${projectData.project_id}`);

                // Fill form fields
                $('#editTitle').val(projectData.title);
                $('#editCategory').val(projectData.category_id);
                $('#editDescription').val(projectData.description);
                $('#editDuration').val(projectData.duration);
                $('#editBenefits').val(projectData.benefits);
                $('#editUser').val(projectData.user_id);

                // Fill positions
                const positions = JSON.parse(projectData.positions);
                const container = $('#editPositionsContainer');
                container.empty();

                positions.forEach(position => {
                    const positionElement = document.createElement('div');
                    positionElement.className = 'flex items-center gap-2';
                    positionElement.innerHTML = `
                <input type="text" name="positions[]" required value="${position}"
                    class="flex-1 bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
                <button type="button" onclick="this.parentElement.remove()"
                    class="px-3 py-1.5 text-xs font-medium text-red-500 bg-red-500/10 rounded-lg hover:bg-red-500/20">
                    Hapus
                </button>
            `;
                    container.append(positionElement);
                });

                // Set preview image
                if (projectData.photo) {
                    $('#editPreviewImg')
                        .attr('src', `/${projectData.photo}`)
                        .removeClass('hidden');
                } else {
                    $('#editPreviewImg')
                        .attr('src', '/images/projects/default.jpg')
                        .removeClass('hidden');
                }

                // Show modal
                $('#editModal').removeClass('hidden');
            });

            // Delete Project Button
            $('.btn-delete').click(function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Project akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    background: '#1F2937',
                    color: '#FFF'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/projects/${id}`;
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Close modal buttons
            $('.btn-close-modal, .btn-cancel').click(function() {
                $(this).closest('.modal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('.modal').click(function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });
        });

        // Image Preview Functions
        function previewImage(event) {
            const preview = document.getElementById('preview-img');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function previewEditImage(event) {
            const preview = document.getElementById('editPreviewImg');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                // Jika file dibatalkan, tampilkan foto sebelumnya
                const currentProject = $('#editForm').data('project');
                if (currentProject && currentProject.photo) {
                    preview.src = `/${currentProject.photo}`;
                } else {
                    preview.src = '/images/projects/default.jpg';
                }
                preview.classList.remove('hidden');
            }
        }

        // Position Functions
        function addPosition() {
            const container = document.getElementById('positions-container');
            const newPosition = document.createElement('div');
            newPosition.className = 'flex items-center gap-2';
            newPosition.innerHTML = `
        <input type="text" name="positions[]" required placeholder="Contoh: Frontend Developer"
            class="flex-1 bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-3 py-1.5 text-xs font-medium text-red-500 bg-red-500/10 rounded-lg hover:bg-red-500/20">
            Hapus
        </button>
    `;
            container.appendChild(newPosition);
        }

        function addEditPosition() {
            const container = document.getElementById('editPositionsContainer');
            const newPosition = document.createElement('div');
            newPosition.className = 'flex items-center gap-2';
            newPosition.innerHTML = `
        <input type="text" name="positions[]" required placeholder="Contoh: Frontend Developer"
            class="flex-1 bg-gray-700 border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-white">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-3 py-1.5 text-xs font-medium text-red-500 bg-red-500/10 rounded-lg hover:bg-red-500/20">
            Hapus
        </button>
    `;
            container.appendChild(newPosition);
        }
    </script>
@endsection
