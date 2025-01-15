<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-white py-12">
        <div class="max-w-xl mx-auto px-6 sm:px-8 lg:px-10 bg-white text-center relative">
            <!-- Gambar Utama -->
            <div class="mb-6">
                <img src="{{ asset('images/under-devlop.webp') }}" alt="Under Development" class="mx-auto w-64 h-auto object-contain animate-bounce-slow">
            </div>

            <!-- Teks Judul -->
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Fitur Sedang Dalam Pengembangan</h2>

            <!-- Deskripsi -->
            <p class="text-lg text-gray-600 mb-8">
                Maaf, fitur yang Anda coba akses sedang dalam pengembangan. Kami sedang bekerja keras untuk menyelesaikannya!
            </p>

            <!-- Tombol Kembali -->
            <div>
                <a href="{{ route('home') }}" class="inline-block py-3 px-6 bg-teal-500 text-white font-semibold rounded-lg hover:bg-teal-600 transform transition-transform duration-200 ease-in-out hover:scale-105 shadow-lg">
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Animasi Awan -->
            <div class="absolute top-0 left-[-50px] animate-cloud bg-gray-200 w-24 h-16 rounded-full opacity-50"></div>
            <div class="absolute top-10 right-[-50px] animate-cloud bg-gray-300 w-32 h-20 rounded-full opacity-60"></div>
        </div>
    </div>

    <!-- Tambahkan Animasi -->
    <style>
        /* Animasi bounce lambat untuk gambar */
        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }

        /* Animasi untuk elemen awan */
        .animate-cloud {
            animation: move-cloud 8s linear infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes move-cloud {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(200px);
            }
        }
    </style>
</x-app-layout>
