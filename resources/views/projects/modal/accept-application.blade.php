<!-- resources/views/projects/modal/accept-application.blade.php -->
<div id="acceptModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div
            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <!-- Modal Header -->
            <div class="text-center mb-4">
                <h3 class="text-lg font-semibold">Berhasil Diterima!</h3>
                <p class="text-sm text-gray-500 mt-1">Masukkan periode kegiatan dimulai dan berakhir</p>
            </div>

            <!-- Form -->
            <form id="acceptForm" class="space-y-4">
                <!-- Tanggal Mulai -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>

                <!-- Tanggal Berakhir -->
                <div>
                    <label for="finish_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="date" id="finish_date" name="finish_date" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>

                <!-- Tautan Ruang Diskusi -->
                <div class="space-y-2">
                    <label for="link_room_discus" class="block text-sm font-medium text-gray-700">
                        Masukkan Tautan Ruang Diskusi
                    </label>
                    <div class="relative group">
                        <!-- Icon Link -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-teal-500 transition-colors duration-150"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>

                        <!-- Input Field -->
                        <input type="url" id="link_room_discus" name="link_room_discus" required
                            class="block w-full pl-10 pr-12 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-200 focus:border-teal-500 hover:border-teal-300 transition-all duration-150 placeholder-gray-400 bg-white"
                            placeholder="https://chat.whatsapp.com/xxx atau https://t.me/xxx" />

                        <!-- Paste Button -->
                        <button type="button" onclick="pasteFromClipboard()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <span class="px-2 py-1 text-sm text-gray-400 hover:text-teal-600 cursor-pointer rounded transition-colors duration-150">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- Helper Text -->
                    <p class="text-sm text-gray-500">
                        Masukkan tautan ruang diskusi seperti grup WhatsApp, Line, atau Telegram
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="hideAcceptModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-600">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentApplicationId = null;

    // Fungsi untuk menampilkan modal
    function showAcceptModal(applicationId) {
        currentApplicationId = applicationId;
        document.getElementById('acceptModal').classList.remove('hidden');
        // Reset form ketika modal dibuka
        document.getElementById('acceptForm').reset();
    }

    // Fungsi untuk menyembunyikan modal
    function hideAcceptModal() {
        document.getElementById('acceptModal').classList.add('hidden');
        currentApplicationId = null;
    }

    // Fungsi untuk paste dari clipboard
    async function pasteFromClipboard() {
        try {
            const text = await navigator.clipboard.readText();
            document.getElementById('link_room_discus').value = text;
        } catch (err) {
            console.error('Failed to read clipboard:', err);
        }
    }

    // Fungsi untuk validasi form
    function validateForm(formData) {
        const startDate = formData.get('start_date');
        const finishDate = formData.get('finish_date');
        const linkRoom = formData.get('link_room_discus');

        if (!startDate || !finishDate || !linkRoom) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Mohon lengkapi semua field!'
            });
            return false;
        }

        if (new Date(finishDate) < new Date(startDate)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tanggal berakhir harus setelah tanggal mulai!'
            });
            return false;
        }

        return true;
    }

    // Initialize ketika DOM sudah siap
    document.addEventListener('DOMContentLoaded', function() {
        const acceptForm = document.getElementById('acceptForm');
        const modal = document.getElementById('acceptModal');
        const startDateInput = document.getElementById('start_date');
        const finishDateInput = document.getElementById('finish_date');

        // Set minimum date untuk kedua input tanggal ke hari ini
        const today = new Date().toISOString().split('T')[0];
        startDateInput.min = today;
        finishDateInput.min = today;

        // Update minimum tanggal berakhir ketika tanggal mulai diubah
        startDateInput.addEventListener('change', function() {
            finishDateInput.min = this.value;
            if (finishDateInput.value && finishDateInput.value < this.value) {
                finishDateInput.value = this.value;
            }
        });

        // Form submit handler
        if (acceptForm) {
            acceptForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                if (!validateForm(formData)) return;

                try {
                    const response = await fetch(`/applications/${currentApplicationId}/accept`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            start_date: formData.get('start_date'),
                            finish_date: formData.get('finish_date'),
                            link_room_discus: formData.get('link_room_discus')
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        hideAcceptModal();
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
                        throw new Error(result.message);
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message || 'Terjadi kesalahan saat memproses aplikasi.'
                    });
                }
            });
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideAcceptModal();
            }
        });
    });
</script>
