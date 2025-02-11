<div id="contentModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <!-- Modal content -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white">Tambah Penugasan</h3>
                    <button type="button" onclick="hideContentModal()" class="text-white hover:text-teal-100 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            @if ($selectedApplication)
                <form id="contentForm" class="p-8 space-y-8">
                    <input type="hidden" name="application_id" value="{{ $selectedApplication->application_id }}">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Judul Penugasan
                                </span>
                            </label>
                            <input type="text" name="title" id="title" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors px-4 py-3">
                        </div>

                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    Deskripsi
                                </span>
                            </label>
                            <textarea name="description" id="description" rows="4" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors px-4 py-3"></textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 space-y-6">
                        <h4 class="font-medium text-gray-900">Timeline Pengerjaan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Tanggal Mulai
                                    </span>
                                </label>
                                <input type="date" name="start_date" id="start_date" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 px-4 py-3">
                            </div>

                            <div class="space-y-2">
                                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Tanggal Jatuh Tempo
                                    </span>
                                </label>
                                <input type="date" name="due_date" id="due_date" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 px-4 py-3">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t">
                        <button type="button" onclick="hideContentModal()"
                            class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Penugasan
                        </button>
                    </div>
                </form>
            @endif


        </div>
    </div>
</div>

<script>
    // Definisi fungsi global
    function showAddContent(applicationId) {
        const modal = document.getElementById('contentModal');
        const form = document.getElementById('contentForm');

        // Reset form dan set application_id
        if (form) {
            form.reset();
            form.querySelector('input[name="application_id"]').value = applicationId;
        }

        // Tampilkan modal
        modal.classList.remove('hidden');

        // Set minimum date untuk input tanggal
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').min = today;
        document.getElementById('due_date').min = today;

        // Update remaining time
        updateRemainingTime();
    }

    function hideContentModal() {
        document.getElementById('contentModal').classList.add('hidden');
    }

    function updateRemainingTime() {
        const startDate = new Date(document.getElementById('start_date').value);
        const dueDate = new Date(document.getElementById('due_date').value);
        const today = new Date();

        const remainingEl = document.querySelector('.remaining-time');
        if (startDate && dueDate && remainingEl) {
            const remaining = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
            remainingEl.textContent = remaining > 0 ? `${remaining} hari` : 'Waktu habis';
        }
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {

        // Close modal when clicking outside
        const modal = document.getElementById('contentModal');
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideContentModal();
            }
        });

        // Date input handlers
        const startDateInput = document.getElementById('start_date');
        const dueDateInput = document.getElementById('due_date');

        startDateInput.addEventListener('change', function() {
            dueDateInput.min = this.value;
            if (dueDateInput.value && dueDateInput.value < this.value) {
                dueDateInput.value = this.value;
            }
            updateRemainingTime();
        });

        dueDateInput.addEventListener('change', updateRemainingTime);

        // Form submit handler
        const form = document.getElementById('contentForm');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                try {
                    const response = await fetch('/project-contents', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        hideContentModal();
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
                        throw new Error(result.message || 'Terjadi kesalahan saat menambahkan penugasan');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message || 'Terjadi kesalahan saat menambahkan penugasan'
                    });
                }
            });
        }
    });
</script>
