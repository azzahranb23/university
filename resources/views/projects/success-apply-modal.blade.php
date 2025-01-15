<div x-show="showSuccessApplyModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="fixed inset-0 bg-gray-800 bg-opacity-70 transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white px-6 pb-6 pt-8 text-center shadow-2xl transition-all w-full max-w-md">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 shadow-lg mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Berhasil Daftar!</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                Pendaftaranmu sedang diverifikasi oleh pemilik proyek.
                Cek status secara berkala pada halaman <strong>Proyek Saya</strong>.
            </p>
            <a href="{{ route('home') }}"
                class="inline-block w-full py-3 bg-green-500 text-white rounded-lg font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 transition-all duration-200">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
