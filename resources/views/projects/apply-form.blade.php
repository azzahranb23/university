<div x-show="showApplyModal" class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            class="relative transform overflow-hidden rounded-xl bg-white px-6 pb-6 pt-8 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">

            <!-- Close Button -->
            <div class="absolute right-0 top-0 pr-4 pt-4">
                <button @click="showApplyModal = false" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form Content -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">
                    Formulir Pendaftaran Proyek
                </h3>
            </div>

            @if ($selectedProject)
                <!-- Project Details -->
                <div class="text-left bg-gray-50 p-4 rounded-lg mb-6 shadow-inner">
                    <h4 class="text-lg font-medium text-gray-900">{{ $selectedProject->title }}</h4>
                    <p class="mt-2 text-gray-600">{{ $selectedProject->description }}</p>
                </div>
            @else
                <div class="text-left bg-gray-50 p-4 rounded-lg mb-6 shadow-inner">
                    <h4 class="text-lg font-medium text-gray-500">Tidak ada proyek yang dipilih</h4>
                    <p class="mt-2 text-gray-400">Silakan pilih proyek untuk melihat detail</p>
                </div>
            @endif

            @if ($selectedProject)
                <!-- Form -->
                <form action="{{ route('projects.apply', $selectedProject->project_id) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Posisi -->
                    <div class="mb-6">
                        <label for="position" class="block text-base font-medium text-gray-800 mb-2">
                            Posisi Proyek
                        </label>
                        <div class="relative">
                            <select id="position" name="position"
                                class="block w-full rounded-lg border border-gray-300 bg-white shadow-sm focus:border-teal-500 focus:ring-teal-500 text-gray-800 px-4 py-2 transition duration-200 ease-in-out">
                                <option value="" class="text-gray-500">Pilih Posisi</option>
                                @foreach (json_decode($selectedProject->positions) as $position)
                                    <option value="{{ $position }}">{{ $position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Motivasi -->
                    <div>
                        <label class="block text-base font-medium text-gray-800 mb-2">Motivasi Anda</label>
                        <textarea name="motivation" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-700 focus:border-teal-500 focus:ring-teal-500 hover:border-gray-400 transition-colors resize-none"
                            placeholder="Jelaskan motivasi Anda untuk bergabung dengan proyek ini"></textarea>
                    </div>

                    <!-- Kelengkapan Dokumen -->
                    <div>
                        <label class="block text-base font-medium text-gray-800 mb-2">
                            Link Dokumen Pendukung
                            <span class="text-gray-500">(Portofolio/Sertifikat/CV)</span>
                        </label>

                        <input type="text" name="documents"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 mb-2 focus:border-teal-500 focus:ring-teal-500 hover:border-gray-400 transition-colors"
                            placeholder="Masukkan link Google Drive/Dropbox yang berisi dokumen Anda">

                        <p class="text-sm text-gray-500 italic">
                            *Pastikan link dapat diakses secara publik
                        </p>
                    </div>


                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full rounded-md bg-teal-500 px-4 py-3 text-white font-semibold hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-offset-2 transition duration-200">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center p-6">
                    <p class="text-gray-500">Silakan pilih proyek terlebih dahulu untuk mendaftar</p>
                </div>
            @endif
        </div>
    </div>
</div>
