<!-- Modal Edit Period -->
<div id="editPeriodModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal content -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white">Edit Periode & Ruang Diskusi</h3>
                    <button type="button" onclick="closeEditPeriodModal()" class="text-white hover:text-teal-100 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form content -->
            <form id="editPeriodForm" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-4">
                    <!-- Periode Section -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <h4 class="font-medium text-gray-900">Periode Kegiatan</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tanggal Mulai -->
                            <div>
                                <label for="edit_start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="start_date" id="edit_start_date" required
                                    value="{{ \Carbon\Carbon::parse($selectedApplication->start_date)->format('Y-m-d') }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>

                            <!-- Tanggal Selesai -->
                            <div>
                                <label for="edit_finish_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="finish_date" id="edit_finish_date" required
                                    value="{{ \Carbon\Carbon::parse($selectedApplication->finish_date)->format('Y-m-d') }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                        </div>
                    </div>

                    <!-- Ruang Diskusi Section -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-4">Tautan Ruang Diskusi</h4>
                        <input type="url" name="link_room_discus" id="edit_link_room_discus" required placeholder="https://meet.google.com/..."
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditPeriodModal()"
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
    function showEditPeriodModal(applicationId) {
        // Set action URL form
        const form = document.getElementById('editPeriodForm');
        form.action = `/applications/${applicationId}/update-period`;

        // Set nilai awal form
        document.getElementById('edit_start_date').value = '{{ $selectedApplication->start_date }}';
        document.getElementById('edit_finish_date').value = '{{ $selectedApplication->finish_date }}';
        document.getElementById('edit_link_room_discus').value = '{{ $selectedApplication->link_room_discus }}';

        // Tampilkan modal
        document.getElementById('editPeriodModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeEditPeriodModal() {
        document.getElementById('editPeriodModal').classList.add('hidden');
    }

    // Event listener untuk form edit
    document.addEventListener('DOMContentLoaded', function() {
        const editPeriodForm = document.getElementById('editPeriodForm');
        if (editPeriodForm) {
            editPeriodForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: new FormData(this)
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Tutup modal
                        closeEditPeriodModal();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: result.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(result.message || 'Terjadi kesalahan saat memperbarui data');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message || 'Terjadi kesalahan saat memperbarui data'
                    });
                }
            });
        }
    });
</script>
