<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-teal-50 to-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                    <!-- Left Column - Photo -->
                    <div class="flex flex-col items-center space-y-4">
                        <div class="relative">
                            <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.jpg') }}"
                                class="w-40 h-40 rounded-full object-cover border-4 border-teal-100 shadow-lg"
                                alt="Profile Photo">
                            <div class="absolute -bottom-2 left-0 right-0 flex justify-center">
                                <span class="px-4 py-1 bg-teal-500 text-white text-sm rounded-full shadow-md">
                                    {{ auth()->user()->role === 'student' ? 'Mahasiswa' : 'Dosen' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Info -->
                    <div class="flex-1 w-full">
                        <h1 class="text-3xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                        <p class="text-lg text-teal-600 mt-1">{{ auth()->user()->nim_nip }}</p>

                        <div class="mt-6 grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                @if (auth()->user()->role === 'student')
                                    <p class="text-sm text-gray-500">Program Studi</p>
                                    <p class="text-base font-medium">{{ auth()->user()->major->major_name ?? '-' }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Departemen</p>
                                    <p class="text-base font-medium">
                                        {{ auth()->user()->department->department_name ?? '-' }}</p>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                                    <p class="text-base font-medium">
                                        {{ auth()->user()->gender === 'male' ? 'Laki-laki' : (auth()->user()->gender === 'female' ? 'Perempuan' : '-') }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-500">No. Telepon</p>
                                    <p class="text-base font-medium">{{ auth()->user()->phone }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-base font-medium">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <button onclick="window.location.href='{{ route('profile.edit') }}'"
                                class="flex-1 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Update Profile</span>
                            </button>

                            <button onclick="window.location.href='{{ route('profile.password') }}'"
                                class="flex-1 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <span>Change Password</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
