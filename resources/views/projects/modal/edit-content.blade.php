<!-- Modal Edit Konten -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal content -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white">Edit Penugasan</h3>
                    <button type="button" onclick="closeEditModal()" class="text-white hover:text-teal-100 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form content -->
            <form id="editContentForm" class="p-6 space-y-6">
                <input type="hidden" id="edit_content_id" name="content_id">

                <div class="space-y-4">
                    <div>
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Penugasan</label>
                        <input type="text" name="title" id="edit_title" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <div>
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="edit_description" rows="4" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="edit_start_date" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label for="edit_due_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                            <input type="date" name="due_date" id="edit_due_date" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Penugasan</label>
                        <div class="mt-1">
                            <div id="documentPreview">
                                <div class="p-4 text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-lg">
                                    Belum ada dokumen yang diupload
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan modal
    function showEditModal() {
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Fungsi untuk edit konten
    async function editContent(contentId) {
        const baseUrl = '{{ asset('') }}';
        if (!contentId) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'ID penugasan tidak valid'
            });
            return;
        }

        try {
            const response = await fetch(`/project-contents/${contentId}`);
            const result = await response.json();

            if (result.success) {
                const content = result.data;

                // Isi form dengan data yang ada
                document.getElementById('edit_content_id').value = content.content_id;
                document.getElementById('edit_title').value = content.title;
                document.getElementById('edit_description').value = content.description;
                document.getElementById('edit_start_date').value = content.start_date;
                document.getElementById('edit_due_date').value = content.due_date;

                // Update document preview
                const documentPreview = document.getElementById('documentPreview');
                if (content.document_path) {
                    documentPreview.innerHTML = `
                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-teal-50 rounded-lg">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dokumen Tersimpan</p>
                                <p class="text-xs text-gray-500">${content.document_path.split('/').pop()}</p>
                            </div>
                        </div>
                        <a href="${baseUrl}${content.document_path}" target="_blank"
                            class="inline-flex items-center px-3 py-1.5 text-sm text-teal-600 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </a>
                    </div>
                `;
                } else {
                    documentPreview.innerHTML = `
                    <div class="p-4 text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-lg">
                        Belum ada dokumen yang diupload
                    </div>
                `;
                }

                // Buka modal
                showEditModal();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal mengambil data penugasan'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat mengambil data'
            });
        }
    }

    // Event listener untuk form edit
    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('editContentForm');
        if (editForm) {
            editForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const contentId = document.getElementById('edit_content_id').value;
                const formData = new FormData(this);

                try {
                    const response = await fetch(`/project-contents/${contentId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Tutup modal
                        closeEditModal();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Penugasan berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.message || 'Terjadi kesalahan saat memperbarui penugasan'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memperbarui penugasan'
                    });
                }
            });
        }
    });
</script>
