<x-app-layout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white to-teal-50/30 py-20">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Text Content -->
                <div class="space-y-8">
                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight text-gray-800">
                        Platform Proyek Lintas Disiplin Ilmu
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Kami dengan bangga mempersembahkan sistem yang inovatif dan kolaboratif untuk mahasiswa dan dosen
                        dari berbagai bidang studi. Di sini, kami percaya bahwa sukses terletak dalam kolaborasi lintas disiplin ilmu.
                    </p>
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ route('projects.initiate') }}"
                                class="px-8 py-4 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all transform hover:scale-105 shadow-lg inline-flex items-center group font-semibold">
                                Buat Proyek Baru
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                            <a href="{{ route('projects.public') }}"
                                class="px-8 py-4 bg-white border-2 border-teal-500 text-teal-700 rounded-xl hover:bg-teal-50 transition-all font-semibold">
                                Lihat Semua Proyek
                            </a>
                        @else
                            <button @click="mobileMenuOpen = false; openLoginModal = true"
                                class="px-8 py-4 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all transform hover:scale-105 shadow-lg font-semibold">
                                Masuk untuk Melihat Proyek
                            </button>
                            <button @click="openRoleModal = true"
                                class="px-8 py-4 bg-white border-2 border-teal-500 text-teal-700 rounded-xl hover:bg-teal-50 transition-all font-semibold">
                                Daftar Baru
                            </button>
                        @endauth
                    </div>
                </div>
                <div class="relative lg:w-[600px] lg:h-[400px] mx-auto">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Virtual Meeting Illustration"
                        class="w-full h-full object-contain mix-blend-multiply" style="filter: contrast(1.1) brightness(1.05);">
                    <!-- UPN Logo -->
                    <div class="absolute -top-2 -left-2 w-24 h-24 flex items-center justify-center z-10">
                        <img src="{{ asset('images/logoupn.png') }}" alt="Logo UPN"
                            class="w-full h-full object-contain drop-shadow-lg transform hover:scale-105 transition-transform duration-300"
                            style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                    </div>
                    <!-- Subtle shadow underneath -->
                    <div
                        class="absolute -bottom-6 left-1/2 -translate-x-1/2 w-2/3 h-4 bg-gradient-to-r from-transparent via-teal-200/20 to-transparent blur-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-teal-600 mb-2">{{ $stats['projects'] }}+</div>
                    <div class="text-gray-600">Proyek Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-teal-600 mb-2">{{ $stats['departments'] }}</div>
                    <div class="text-gray-600">Departemen</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-teal-600 mb-2">{{ $stats['students'] }}+</div>
                    <div class="text-gray-600">Mahasiswa</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-teal-600 mb-2">{{ $stats['lecturers'] }}+</div>
                    <div class="text-gray-600">Dosen</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 text-gray-800">Kategori Lintas Disiplin Ilmu</h2>
            <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto">
                Jelajahi berbagai kategori proyek yang tersedia dan temukan kolaborasi yang sesuai dengan minat Anda
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($categories as $category)
                    <div
                        class="bg-white rounded-2xl shadow-[0_0_15px_rgba(20,184,166,0.1)] overflow-hidden transform hover:scale-105 transition-all group">
                        <div class="relative">
                            <img src="{{ $category->image ? asset($category->image) : asset('images/default-category.jpg') }}"
                                alt="{{ $category->category_name }}" class="w-full h-48 object-cover group-hover:opacity-90 transition-opacity">
                            <div class="absolute bottom-0 inset-x-0 h-20 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <h3 class="font-bold text-xl mb-1">{{ $category->category_name }}</h3>
                                <p class="text-teal-200">{{ $category->projects_count }} proyek</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-teal-500 to-teal-700">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-8 text-white">
                @auth
                    @if (auth()->user()->role === 'student')
                        Temukan Proyek yang Sesuai Minat Anda
                    @else
                        Mulai Inisiasi Proyek Kolaboratif Anda
                    @endif
                @else
                    Siap Untuk Memulai Proyek Anda?
                @endauth
            </h2>
            <p class="text-xl text-teal-100 mb-8 max-w-2xl mx-auto">
                @auth
                    @if (auth()->user()->role === 'student')
                        Jelajahi berbagai proyek menarik dan ajukan lamaran Anda sekarang
                    @else
                        Buat proyek baru dan temukan mahasiswa berbakat untuk tim Anda
                    @endif
                @else
                    Bergabunglah dengan komunitas kami dan mulai kolaborasi lintas disiplin Anda hari ini.
                @endauth
            </p>
            @auth
                <div class="flex justify-center gap-4">
                    @if (auth()->user()->role === 'student')
                        <a href="#" class="px-8 py-4 bg-white text-teal-700 rounded-xl hover:bg-teal-50 transition-all font-semibold">
                            Jelajahi Proyek
                        </a>
                    @else
                        <a href="#" class="px-8 py-4 bg-white text-teal-700 rounded-xl hover:bg-teal-50 transition-all font-semibold">
                            Buat Proyek Baru
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </section>
</x-app-layout>
