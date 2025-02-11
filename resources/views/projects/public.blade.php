<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header dan Search Section -->
            <div class="bg-gray-100 rounded-xl p-6 mb-6">
                <form action="{{ route('projects.public') }}" method="GET" class="flex gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari proyek..."
                        class="flex-1 rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 px-6 py-3 bg-white">
                    <div class="relative w-64">
                        <!-- Ikon Kategori -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 16h14M7 12h10"></path>
                            </svg>
                        </div>
                        <!-- Dropdown -->
                        <select name="category"
                            class="block w-full pl-10 pr-6 py-3 bg-white text-gray-800 rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm appearance-none">
                            <option value="" class="text-gray-500">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Panah Dropdown -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="px-8 py-3 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition-colors min-w-[120px]">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </span>
                    </button>
                </form>
            </div>

            <!-- Content Area -->
            <div class="grid grid-cols-12 gap-6">
                <!-- Sidebar Project List -->
                <div class="col-span-4 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="max-h-[calc(100vh-200px)] overflow-y-auto">
                        @forelse($projects as $project)
                            <a href="{{ route('projects.public', ['project' => $project->project_id] + request()->only(['search', 'category'])) }}"
                                class="block p-4 hover:bg-gray-50 border-b border-gray-100 {{ $selectedProject && $selectedProject->project_id === $project->project_id ? 'bg-teal-50' : '' }}">
                                <div class="flex gap-4">
                                    <img src="{{ $project->photo ? asset($project->photo) : asset('images/project-banner.jpg') }}"
                                        class="w-16 h-16 rounded object-cover" alt="{{ $project->title }}">
                                    <div>
                                        <span class="inline-block px-2 py-1 text-xs text-white rounded-full bg-teal-500 mb-1">
                                            {{ $project->category->category_name }}
                                        </span>
                                        <h4 class="font-medium text-gray-900 line-clamp-1">{{ $project->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ $project->duration }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Tidak ada proyek yang ditemukan
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Main Project Content -->
                @if ($selectedProject)
                    <div class="col-span-8">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Project Header/Banner -->
                            <div class="relative h-64">
                                <img src="{{ $selectedProject->photo ? asset($selectedProject->photo) : asset('images/project-banner.jpg') }}"
                                    class="w-full h-full object-cover" alt="{{ $selectedProject->title }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-6 text-white">
                                    <h1 class="text-3xl font-bold mb-2">{{ $selectedProject->title }}</h1>
                                    <div class="flex items-center gap-4">
                                        <span class="px-3 py-1 text-sm bg-yellow-400 text-yellow-900 rounded-full font-medium">
                                            {{ $selectedProject->status }}
                                        </span>
                                        <span class="text-sm">
                                            Durasi: {{ $selectedProject->duration }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Project Content -->
                            <div class="p-6">
                                <div class="mb-8">
                                    <p class="text-gray-600 mb-6">{{ $selectedProject->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-8">
                                            <div>
                                                <p class="text-sm text-gray-500">Kategori</p>
                                                <p class="font-semibold">{{ $selectedProject->category->category_name }}</p>
                                            </div>
                                        </div>
                                        <div class="space-x-4">
                                            @if ($selectedProject->user_id != Auth::id())
                                                @if ($selectedProject->applicants >= $selectedProject->quota)
                                                    <button disabled class="px-6 py-2.5 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                                        Kuota Penuh ({{ $selectedProject->applicants }}/{{ $selectedProject->quota }})
                                                    </button>
                                                @else
                                                    <button @click="showApplyModal = true"
                                                        class="px-6 py-2.5 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                                                        Daftar Sekarang ({{ $selectedProject->applicants }}/{{ $selectedProject->quota }})
                                                    </button>
                                                @endif
                                            @endif
                                            <button id="shareButton"
                                                class="px-6 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                Bagikan
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Project Details -->
                                <div class="space-y-8">
                                    <div>
                                        <!-- Positions -->
                                        <div class="mb-6">
                                            <p class="font-medium text-gray-900 mb-2">Posisi Proyek:</p>
                                            <div class="grid grid-cols-2 gap-2">
                                                @if ($selectedProject->positions)
                                                    @foreach (json_decode($selectedProject->positions) as $position)
                                                        <div class="px-3 py-2 bg-gray-50 rounded-lg text-gray-700">
                                                            {{ $position }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Benefits -->
                                        <div class="mb-6">
                                            <p class="font-medium text-gray-900 mb-2">Benefit:</p>
                                            <div class="text-gray-600 space-y-1">
                                                {!! nl2br($selectedProject->benefits ?? '-') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Project Owner -->
                                    <div class="border-t pt-8">
                                        <h3 class="text-lg font-semibold mb-6 text-gray-800">Tentang Pemilik Proyek</h3>
                                        <div class="flex items-center bg-gray-50 p-4 rounded-lg shadow-sm">
                                            <img src="{{ $selectedProject->user->photo ? asset('storage/' . $selectedProject->user->photo) : asset('images/default-avatar.jpg') }}"
                                                class="w-16 h-16 rounded-full border border-gray-300 shadow-sm" alt="Profile">
                                            <div class="ml-4">
                                                <p class="text-xl font-semibold text-gray-800">{{ $selectedProject->user->name }}</p>
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    {{ $selectedProject->user->role === 'student' ? 'Mahasiswa' : 'Dosen' }}
                                                    <span class="mx-2">|</span>
                                                    {{ $selectedProject->user->major->major_name ?? ($selectedProject->user->department->department_name ?? 'Universitas') }}
                                                </p>
                                            </div>
                                            <div class="ml-auto">
                                                <a href="{{ route('projects.owner', $selectedProject->user->user_id) }}"
                                                    class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                                                    Lihat Profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($projects->isEmpty())
                        <div class="col-span-8">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Pencarian tidak ditemukan</h3>
                                    <p class="text-gray-500 mb-6">Tidak ada proyek yang sesuai dengan kriteria pencarian Anda</p>
                                    <a href="{{ route('projects.public') }}"
                                        class="inline-flex items-center px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Kembali ke Semua Proyek
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-span-8">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Pilih Project</h3>
                                    <p class="text-gray-500">Pilih project yang ingin di lihat detailnya</p>
                                </div>
                            </div>
                        </div>
                @endif
            </div>
        </div>
    </div>
    @include('projects.apply-form')
    @include('projects.success-apply-modal')

    <div id="copyNotification" class="hidden fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg text-sm animate-bounce">
            <span class="font-semibold">Link berhasil disalin!</span>
        </div>
    </div>

    <style>
        /* Animasi notifikasi */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            10%,
            90% {
                opacity: 1;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(0.95);
            }
        }

        .animate-bounce {
            animation: fadeInOut 2s ease-in-out;
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shareButton = document.getElementById('shareButton');
            if (shareButton) {
                shareButton.addEventListener('click', function() {
                    // Salin URL halaman saat ini ke clipboard
                    const currentUrl = window.location.href;
                    navigator.clipboard.writeText(currentUrl)
                        .then(() => {
                            // Tampilkan notifikasi jika berhasil disalin
                            const notification = document.getElementById('copyNotification');
                            notification.classList.remove('hidden');
                            setTimeout(() => {
                                notification.classList.add('hidden');
                            }, 2000); // Sembunyikan setelah 2 detik
                        })
                        .catch(err => {
                            console.error('Gagal menyalin link:', err);
                        });
                });
            }
        });
    </script>

</x-app-layout>
