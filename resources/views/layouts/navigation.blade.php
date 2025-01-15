<nav class="bg-white shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-teal-600 hover:text-teal-700 transition">Projects</a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                @auth
                    <!-- Dropdown Inisiasi Proyek -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-teal-600 transition-colors duration-200">
                            <span>Inisiasi Proyek</span>
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10"
                            style="display: none;">
                            <a href="{{ route('projects.my') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                                Inisiasi Proyek Saya
                            </a>
                            <a href="{{ route('projects.initiate') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                                Buat Inisiasi Proyek
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('application.all') }}" class="px-3 py-2 text-gray-600 hover:text-teal-600 transition-colors duration-200">
                        Proyek Saya
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="inline-flex items-center px-3 py-2 text-gray-600 hover:text-teal-600 transition-colors duration-200">
                            <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : asset('images/default-avatar.jpg') }}" alt="User Avatar"
                                class="w-8 h-8 rounded-full object-cover border border-gray-300 mr-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>


                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10"
                            style="display: none;">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <button onclick="showLoginAlert()" class="px-3 py-2 text-gray-600 hover:text-teal-600 transition-colors duration-200">
                        Inisiasi Proyek
                    </button>
                    <button onclick="showLoginAlert()" class="px-3 py-2 text-gray-600 hover:text-teal-600 transition-colors duration-200">
                        Proyek Saya
                    </button>
                    <button @click="openLoginModal = true"
                        class="bg-gradient-to-r from-teal-500 to-teal-600 text-white px-6 py-2 rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-sm">
                        Masuk
                    </button>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-teal-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden" @click.away="mobileMenuOpen = false">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <a href="{{ route('projects.my') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                    Inisiasi Proyek Saya
                </a>
                <a href="{{ route('projects.initiate') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                    Buat Inisiasi Proyek
                </a>
                <a href="{{ route('application.all') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                    Proyek Saya
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-left text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                        Logout
                    </button>
                </form>
            @else
                <button onclick="showLoginAlert()" class="block w-full px-4 py-2 text-left text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                    Inisiasi Proyek
                </button>
                <button onclick="showLoginAlert()" class="block w-full px-4 py-2 text-left text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                    Proyek Saya
                </button>
                <button @click="mobileMenuOpen = false; openLoginModal = true"
                    class="block w-full px-4 py-2 text-left text-gray-700 hover:bg-teal-50 hover:text-teal-600">
                    Masuk
                </button>
            @endauth
        </div>
    </div>
</nav>
