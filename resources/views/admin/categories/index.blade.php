@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Categories Management</h2>
                <p class="text-white/80 mt-1">Manage project categories and monitoring</p>
            </div>
            <!-- Modal Tambah Kategori -->
            <div x-data="{ showCreateModal: false }" class="relative z-50">
                <!-- Trigger Button -->
                <button @click="showCreateModal = true"
                    class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kategori
                </button>

                <!-- Modal -->
                <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Overlay -->
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <!-- Modal Content -->
                        <div
                            class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="mb-4">
                                        <label class="block text-gray-400 text-sm font-bold mb-2">
                                            Nama Kategori
                                        </label>
                                        <input type="text" name="category_name" required
                                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-gray-400 text-sm font-bold mb-2">
                                            Gambar
                                        </label>
                                        <input type="file" name="image" accept="image/*"
                                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Simpan
                                    </button>
                                    <button type="button" @click="showCreateModal = false"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-500 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-400 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Categories -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-purple-500/10 p-3">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-400 text-sm">Total Categories</h3>
                    <p class="text-2xl font-semibold text-white">{{ $categories->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-500/10 p-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-400 text-sm">Total Projects</h3>
                    <p class="text-2xl font-semibold text-white">{{ $categories->sum('projects_count') }}</p>
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
                    <h3 class="text-gray-400 text-sm">Active Projects</h3>
                    <p class="text-2xl font-semibold text-white">
                        {{ $categories->sum(function ($cat) {return $cat->projects->where('status', 'active')->count();}) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Average Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-yellow-500/10 p-3">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-400 text-sm">Avg Projects</h3>
                    <p class="text-2xl font-semibold text-white">{{ round($categories->avg('projects_count'), 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table Card -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="overflow-x-auto">
            <table id="categoriesTable" class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Projects</th>
                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Active Projects</th>
                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Last Activity</th>
                        <th class="px-6 py-3 bg-gray-700 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-700">
                            <!-- Category Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-lg object-cover"
                                            src="{{ $category->image ? asset($category->image) : asset('images/default-category.jpg') }}"
                                            alt="{{ $category->category_name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $category->category_name }}</div>
                                        <div class="text-sm text-gray-400">Created {{ $category->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Total Projects -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/20 text-blue-400">
                                    {{ $category->projects_count }} Projects
                                </span>
                            </td>

                            <!-- Active Projects -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400">
                                    {{ $category->projects->where('status', 'active')->count() }} Active
                                </span>
                            </td>

                            <!-- Last Activity -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $category->projects->max('updated_at') ? $category->projects->max('updated_at')->format('M d, Y H:i') : 'No activity' }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button
                                    onclick="editCategory('{{ $category->category_id }}', '{{ $category->category_name }}', '{{ asset($category->image) }}')"
                                    class="text-yellow-400 hover:text-yellow-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button @click="deleteCategory({{ $category->category_id }})" class="text-red-400 hover:text-red-600">
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

    <!-- Modal Edit Kategori -->
    <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Content -->
            <div
                class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <!-- Preview Gambar -->
                        <div class="mb-4 text-center">
                            <img id="editImagePreview" src="" alt="Category Image Preview" class="w-32 h-32 rounded-lg object-cover mx-auto">
                            <p class="text-gray-400 text-sm mt-2">Gambar Saat Ini</p>
                        </div>

                        <!-- Nama Kategori -->
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">
                                Nama Kategori
                            </label>
                            <input type="text" name="category_name" id="editCategoryName" required
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Upload Gambar -->
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">
                                Ganti Gambar
                            </label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-500 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-400 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <style>
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Pilih File';
            display: inline-block;
            background: linear-gradient(to bottom, #ffffff 0%, #e0e0e0 100%);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            cursor: pointer;
            font-weight: 700;
            font-size: 10pt;
        }

        .custom-file-input:hover::before {
            border-color: #888;
        }

        .custom-file-input:active::before {
            background: -webkit-linear-gradient(to bottom, #e3e3e3, #f9f9f9);
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
                // Custom styling untuk DataTables dengan Tailwind
                language: {
                    searchPlaceholder: "Search...",
                    search: "",
                    lengthMenu: "_MENU_ per page",
                },
                dom: '<"flex flex-col md:flex-row justify-between items-start md:items-center mb-4"lf>rtip',
                drawCallback: function() {
                    // Styling untuk input search
                    $('.dataTables_filter input').addClass(
                        'px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
                    );

                    // Styling untuk select length
                    $('.dataTables_length select').addClass(
                        'px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
                    );

                    // Styling untuk pagination
                    $('.dataTables_paginate .paginate_button').addClass('px-3 py-1 border border-gray-300 hover:bg-gray-100');
                    $('.dataTables_paginate .paginate_button.current').addClass(
                        'bg-blue-500 text-white border-blue-500 hover:bg-blue-600');
                }
            });
        });
    </script>

    <script>
        function editCategory(id, name, image) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const nameInput = document.getElementById('editCategoryName');
            const imagePreview = document.getElementById('editImagePreview');

            // Set form action
            form.action = `/admin/categories/${id}`;

            // Set input values
            nameInput.value = name;
            imagePreview.src = image;

            // Show modal
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>

    <script>
        function deleteCategory(categoryId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kategori yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/categories/${categoryId}`;
                    form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Preview gambar sebelum upload
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
