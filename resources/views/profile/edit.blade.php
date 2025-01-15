<x-app-layout>
    <div class="min-h-screen py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-6">
                    <h2 class="text-2xl font-bold text-white">Update Profile</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Photo Section -->
                    <div class="flex justify-center">
                        <div class="relative group">
                            <img id="profile-photo"
                                src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.jpg') }}"
                                alt="Profile" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            <label for="photo-input"
                                class="absolute bottom-0 right-0 bg-teal-500 text-white p-2 rounded-full cursor-pointer hover:bg-teal-600 transition-colors shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" id="photo-input" name="photo" class="hidden" accept="image/*" onchange="previewPhoto(event)">
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid gap-6">
                        <!-- Existing form fields with enhanced styling -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIM/NIP</label>
                                <input type="text" value="{{ auth()->user()->nim_nip }}" readonly
                                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required
                                    class="mt-1 block w-full px-4 py-3 border rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if (auth()->user()->role === 'student')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                                    <input type="text" value="{{ auth()->user()->major->major_name ?? '-' }}" readonly
                                        class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                </div>
                            @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Departemen</label>
                                    <input type="text" value="{{ auth()->user()->department->department_name ?? '-' }}" readonly
                                        class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <input type="text" value="{{ auth()->user()->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}" readonly
                                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone }}" required
                                    class="mt-1 block w-full px-4 py-3 border rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" required
                                    class="mt-1 block w-full px-4 py-3 border rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4 pt-6">
                            <button type="submit"
                                class="flex-1 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('profile') }}"
                                class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-photo').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
