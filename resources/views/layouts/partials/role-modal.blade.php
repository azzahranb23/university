<div x-show="openRoleModal" class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal content here (copied from previous role modal) -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-8 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:p-6"
            @click.away="openRoleModal = false">
            <!-- Close button -->
            <div class="absolute right-4 top-4">
                <button type="button" @click="openRoleModal = false" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900">SIGN UP</h3>
                <p class="mt-2 text-gray-600">Anda merupakan mahasiswa atau dosen?</p>
            </div>
            <div class="flex flex-col space-y-4">
                <!-- Mahasiswa Button -->
                <a href="{{ route('register') }}?role=mahasiswa"
                    class="w-full py-4 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition-all text-center font-semibold">
                    Mahasiswa
                </a>
                <!-- Dosen Button -->
                <a href="{{ route('register') }}?role=dosen"
                    class="w-full py-4 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-all text-center font-semibold">
                    Dosen
                </a>
            </div>
        </div>
    </div>
</div>
