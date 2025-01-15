<x-app-layout>
    <div class="min-h-screen py-12 bg-gray-50">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-6">
                    <h2 class="text-2xl font-bold text-white">Ubah Password</h2>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                            <input type="password" name="current_password" required
                                   class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                            <input type="password" name="password" required
                                   class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                   class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex space-x-4 pt-4">
                            <button type="submit"
                                    class="flex-1 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                                Simpan
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
</x-app-layout>
