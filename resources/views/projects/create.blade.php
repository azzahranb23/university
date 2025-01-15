<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <!-- Header Section -->
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-teal-600">Inisiasi Proyek Baru</h1>
                <p class="mt-3 text-gray-600 text-lg">Lengkapi detail proyek untuk memulai inisiasi.</p>
            </div>

            <!-- Form Section -->
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                @csrf

                <!-- Informasi Dasar -->
                <div class="border-b border-gray-200 bg-gray-100 px-8 py-6">
                    <h2 class="text-xl font-semibold text-gray-800">Informasi Dasar</h2>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Proyek</label>
                        <input type="text" name="title" id="title" required
                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Proyek</label>
                        <textarea name="description" id="description" rows="4" required
                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Deskripsikan detail proyek..."></textarea>
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700">Durasi Proyek</label>
                        <input type="text" name="duration" id="duration" required
                            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Contoh: 3 Bulan">
                    </div>
                </div>

                <!-- Posisi -->
                <div class="border-t border-gray-200 bg-gray-100 px-8 py-6">
                    <h2 class="text-xl font-semibold text-gray-800">Posisi yang Dibutuhkan</h2>
                </div>
                <div class="p-8">
                    <div id="positions-container" class="space-y-4">
                        <div class="flex items-center gap-4">
                            <input type="text" name="positions[]" required
                                class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Contoh: Frontend Developer">
                            <button type="button" onclick="addPosition()"
                                class="inline-flex items-center rounded-md bg-teal-100 px-4 py-2 text-sm font-medium text-teal-700 hover:bg-teal-200">
                                Tambah Posisi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Benefit -->
                <div class="border-t border-gray-200 bg-gray-100 px-8 py-6">
                    <h2 class="text-xl font-semibold text-gray-800">Benefit Proyek</h2>
                </div>
                <div class="p-8">
                    <textarea name="benefits" rows="4" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Contoh:\n- Sertifikat\n- Uang Saku\n- Pengalaman Proyek"></textarea>
                </div>

                <!-- Upload Foto -->
                <div class="border-t border-gray-200 bg-gray-100 px-8 py-6">
                    <h2 class="text-xl font-semibold text-gray-800">Upload Foto</h2>
                </div>
                <div class="p-8">
                    <div class="flex flex-col items-center rounded-lg border border-dashed border-gray-400 p-10 bg-gray-50">
                        <div id="image-preview" class="mb-4">
                            <!-- Preview image akan muncul di sini -->
                            <img id="preview-img" src="#" alt="Preview Foto" class="hidden w-40 h-40 object-cover rounded-lg shadow-md">
                        </div>
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm text-gray-600">
                                <label for="photo"
                                    class="relative cursor-pointer rounded-md bg-white font-semibold text-teal-600 hover:text-teal-500">
                                    <span>Upload foto</span>
                                    <input id="photo" name="photo" type="file" class="sr-only" accept="image/*"
                                        onchange="previewImage(event)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>

                </div>

                <!-- Submit -->
                <div class="bg-gray-100 px-8 py-6 flex justify-end gap-4">
                    <button type="button" onclick="history.back()"
                        class="rounded-lg px-6 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg px-6 py-2 text-sm font-semibold text-white bg-teal-600 hover:bg-teal-500">
                        Buat Proyek
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addPosition() {
            const container = document.getElementById('positions-container');
            const newPosition = document.createElement('div');
            newPosition.className = 'flex items-center gap-4';
            newPosition.innerHTML = `
            <input type="text" name="positions[]" required
                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                placeholder="Contoh: Frontend Developer">
            <button type="button" onclick="removePosition(this)"
                class="inline-flex items-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-200">
                Hapus
            </button>
        `;
            container.appendChild(newPosition);
        }

        function removePosition(button) {
            button.parentElement.remove();
        }

        function previewImage(event) {
            const input = event.target;
            const previewImg = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</x-app-layout>
