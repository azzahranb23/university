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
                    <h3 class="text-2xl font-bold text-white">Edit Konten Proyek</h3>
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
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Konten</label>
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
                        <label for="edit_link_task" class="block text-sm font-medium text-gray-700 mb-1">Link Tautan Penugasan</label>
                        <input type="url" name="link_task" id="edit_link_task"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" readonly>
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
        if (!contentId) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'ID konten tidak valid'
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
                document.getElementById('edit_link_task').value = content.link_task || '';

                // Buka modal
                showEditModal();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal mengambil data konten'
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
                            text: 'Konten proyek berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.message || 'Terjadi kesalahan saat memperbarui konten'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memperbarui konten'
                    });
                }
            });
        }
    });
</script>
