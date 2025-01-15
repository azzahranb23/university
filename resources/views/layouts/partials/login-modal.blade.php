<div x-show="openLoginModal" class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <!-- Modal content here (copied from previous login modal) -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:p-6"
            @click.away="openLoginModal = false">
            <div class="absolute right-4 top-4">
                <button type="button" @click="openLoginModal = false" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold text-teal-600 mb-2">Projects</h3>
                <h4 class="text-xl font-semibold text-gray-900">Log in to Project System</h4>
            </div>
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <!-- NIM/NIP Field -->
                <div>
                    <label for="nim_nip" class="block text-sm font-medium text-gray-700">NIM/NIP</label>
                    <input type="text" name="nim_nip" id="nim_nip" required
                        class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
placeholder-gray-400 shadow-sm hover:shadow-md">
                </div>
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="block w-full px-4 py-3 border rounded-lg bg-white border-gray-200 transition-all duration-300
hover:border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 focus:outline-none
placeholder-gray-400 shadow-sm hover:shadow-md">
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit"
                    class="w-full rounded-md bg-gradient-to-r from-teal-500 to-teal-600 py-3 text-white font-semibold hover:from-teal-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Sign In
                </button>
                <!-- Register Link -->
                <div class="text-center text-sm text-gray-500">
                    Belum punya akun?
                    <button @click="openLoginModal = false; openRoleModal = true" class="font-medium text-teal-600 hover:text-teal-500">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
