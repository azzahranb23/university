<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header dan Search Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex flex-col lg:flex-row gap-4 items-stretch">
                    <form action="{{ route('projects.my') }}" method="GET" class="flex-1 flex flex-wrap gap-4">
                        <!-- Pencarian -->
                        <div class="flex-1 min-w-[200px]">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out"
                                    placeholder="Cari nama, NIM pelamar, atau nama proyek...">
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div class="min-w-[200px]">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697A9.001 9.001 0 0121 12a9.001 9.001 0 01-7.835 7.303" />
                                    </svg>
                                </div>
                                <select name="status"
                                    class="w-full pl-10 pr-10 py-3 rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 appearance-none bg-white transition duration-150 ease-in-out">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filter Posisi -->
                        <div class="min-w-[200px]">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <select name="position"
                                    class="w-full pl-10 pr-10 py-3 rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 appearance-none bg-white transition duration-150 ease-in-out">
                                    <option value="">Semua Posisi</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Tombol-tombol -->
                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-6 py-3 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition-all duration-150 ease-in-out flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>

                            @if (request()->hasAny(['search', 'status', 'position']))
                                <a href="{{ route('projects.my') }}"
                                    class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-150 ease-in-out flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reset
                                </a>
                            @endif

                            <!-- Tombol Inisiasi Proyek -->
                            <a href="{{ route('projects.public') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-colors whitespace-nowrap">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Inisiasi Proyek
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Content Area -->
            <div class="grid grid-cols-12 gap-6">
                <!-- Sidebar Project List -->
                <div class="col-span-4 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="max-h-[calc(100vh-200px)] overflow-y-auto divide-y divide-gray-200">
                        @forelse($applications as $application)
                            <a href="{{ route('projects.my', ['application' => $application->application_id] + request()->only(['search', 'category'])) }}"
                                class="block p-4 hover:bg-gray-50 transition-colors relative {{ $selectedApplication && $selectedApplication->application_id === $application->application_id ? 'bg-teal-50' : '' }}">

                                <!-- Status Badge -->
                                <div class="absolute top-0 right-0">
                                    @switch($application->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Request
                                            </span>
                                        @break

                                        @case('accepted')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Accepted
                                            </span>
                                        @break

                                        @case('rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @break
                                    @endswitch
                                </div>

                                <div class="flex gap-4 items-start pt-2">
                                    <img src="{{ $application->project->photo ? asset($application->project->photo) : asset('images/project-banner.jpg') }}"
                                        class="w-16 h-16 rounded-lg object-cover shadow" alt="{{ $application->project->title }}">

                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-gray-900 truncate">{{ $application->user->name }}</h3>
                                        <p class="text-sm text-gray-900 mt-1">{{ $application->project->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $application->position }}</p>
                                    </div>
                                </div>
                            </a>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-4">Belum ada pelamar proyek</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Main Content -->
                    @if ($selectedApplication)
                        <div class="col-span-8">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                                <h2 class="text-2xl font-bold mb-4">{{ $selectedApplication->project->title }}</h2>

                                <div class="mb-3">
                                    <img src="{{ $selectedApplication->project->photo ? asset($selectedApplication->project->photo) : asset('images/project-banner.jpg') }}"
                                        class="w-full h-48 object-cover rounded-lg mb-4" alt="{{ $selectedApplication->project->title }}">

                                    <p class="text-gray-600">{{ $selectedApplication->project->description }}</p>

                                    <div class="mt-4 flex items-center justify-between">
                                        <p class="text-sm text-gray-500">Kuota Peserta:
                                            <span class="font-semibold">5/10</span>
                                        </p>
                                        <!-- Status Badge Bar -->
                                        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-gray-700 font-medium">Status:</span>
                                                @switch($selectedApplication->status)
                                                    @case('pending')
                                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                            Menunggu
                                                        </span>
                                                    @break

                                                    @case('accepted')
                                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                                                            On Going
                                                        </span>
                                                    @break

                                                    @case('rejected')
                                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                            Ditolak
                                                        </span>
                                                    @break
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tentang Pelamar -->
                                <div class=" mx-auto bg-white rounded-xl overflow-hidden">
                                    {{-- Header Section --}}
                                    <div class="border-b bg-gray-50/50 p-6">
                                        <h3 class="text-xl font-bold text-gray-800">Tentang Pelamar Proyek</h3>
                                    </div>

                                    {{-- Content Section --}}
                                    <div class="p-6">
                                        {{-- Profile Header --}}
                                        <div class="flex items-center gap-6 mb-8">
                                            <div class="relative">
                                                <img src="{{ $selectedApplication->user->photo ? asset('storage/' . $selectedApplication->user->photo) : asset('images/default-avatar.jpg') }}"
                                                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg" alt="Profile">
                                                <span
                                                    class="absolute -bottom-2 right-0 px-3 py-1 bg-teal-500 text-white text-xs font-medium rounded-full">
                                                    {{ $selectedApplication->user->role === 'student' ? 'Mahasiswa' : 'Staff' }}
                                                </span>
                                            </div>
                                            <div>
                                                <h4 class="text-2xl font-bold text-gray-900">{{ $selectedApplication->user->name }}</h4>
                                                <p class="text-gray-500">{{ $selectedApplication->user->nim_nip }}</p>
                                            </div>
                                        </div>

                                        {{-- Info Grid --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                            {{-- Program/Departemen --}}
                                            <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-all">
                                                <label class="text-sm font-medium text-gray-600 block mb-1">
                                                    {{ $selectedApplication->user->role === 'student' ? 'Program Studi' : 'Departemen' }}
                                                </label>
                                                <p class="text-gray-900">
                                                    {{ $selectedApplication->user->role === 'student'
                                                        ? $selectedApplication->user->major->major_name ?? '-'
                                                        : $selectedApplication->user->department->department_name ?? '-' }}
                                                </p>
                                            </div>

                                            {{-- Posisi Proyek --}}
                                            <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-all">
                                                <label class="text-sm font-medium text-gray-600 block mb-1">Posisi Proyek</label>
                                                <p class="text-gray-900">{{ $selectedApplication->position }}</p>
                                            </div>

                                            {{-- No. Telepon --}}
                                            <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-all">
                                                <label class="text-sm font-medium text-gray-600 block mb-1">No. Telepon</label>
                                                <p class="text-gray-900">{{ $selectedApplication->user->phone }}</p>
                                            </div>

                                            {{-- Email --}}
                                            <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-all">
                                                <label class="text-sm font-medium text-gray-600 block mb-1">Alamat Email</label>
                                                <p class="text-gray-900">{{ $selectedApplication->user->email }}</p>
                                            </div>
                                        </div>

                                        {{-- Motivation Section --}}
                                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                            <label class="text-lg font-semibold text-gray-800 block mb-3">Motivasi Mengikuti Proyek</label>
                                            <p class="text-gray-700 leading-relaxed">{{ $selectedApplication->motivation }}</p>
                                        </div>

                                        {{-- Action Buttons --}}
                                        @if ($selectedApplication->status === 'pending')
                                            <div class="flex gap-4">
                                                <button onclick="showAcceptModal('{{ $selectedApplication->application_id }}')"
                                                    class="flex-1 py-4 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                                                    Terima Aplikasi
                                                </button>
                                                <button onclick="rejectApplication({{ $selectedApplication->application_id }})"
                                                    class="flex-1 py-4 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                                    Tolak Aplikasi
                                                </button>
                                            </div>
                                        @endif

                                        @if ($selectedApplication->status === 'accepted')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <!-- Periode Kegiatan -->
                                                <div class="bg-white rounded-xl border border-gray-200 p-4">
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <div class="p-2 bg-gray-100 rounded-lg">
                                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                        <h3 class="font-semibold text-gray-800">Periode Kegiatan</h3>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <div class="flex justify-between items-center text-sm">
                                                            <span class="text-gray-600">Tanggal Mulai:</span>
                                                            <span
                                                                class="font-medium">{{ \Carbon\Carbon::parse($selectedApplication->start_date)->format('d/m/Y') }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center text-sm">
                                                            <span class="text-gray-600">Tanggal Berakhir:</span>
                                                            <span
                                                                class="font-medium">{{ \Carbon\Carbon::parse($selectedApplication->finish_date)->format('d/m/Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tautan Ruang Diskusi -->
                                                <div class="bg-white rounded-xl border border-gray-200 p-4">
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <div class="p-2 bg-gray-100 rounded-lg">
                                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                        </div>
                                                        <h3 class="font-semibold text-gray-800">Tautan Ruang Diskusi</h3>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <input type="text" value="{{ $selectedApplication->link_room_discus }}" readonly
                                                            class="flex-1 text-sm bg-gray-50 border-0 rounded p-2 mr-2 focus:ring-0">
                                                        <a href="{{ $selectedApplication->link_room_discus }}" target="_blank"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                            </svg>
                                                            Buka
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Status Progress -->
                                                <div class="bg-white rounded-xl border border-gray-200 p-4 md:col-span-2">
                                                    <div class="flex items-center gap-3 mb-3">
                                                        <div class="p-2 bg-gray-100 rounded-lg">
                                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                        </div>
                                                        <h3 class="font-semibold text-gray-800">Progress Pengerjaan</h3>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <div class="flex justify-between text-sm mb-1">
                                                            <span class="text-gray-600">Status Pengerjaan</span>
                                                            <span class="font-medium">{{ $selectedApplication->progress }}%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                            <div class="bg-teal-500 h-2.5 rounded-full transition-all duration-300"
                                                                style="width: {{ $selectedApplication->progress }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-white rounded-xl border border-gray-200 p-4 md:col-span-2">
                                                    <!-- Header -->
                                                    <div class="flex justify-between items-center mb-6">
                                                        <h3 class="text-xl font-bold text-gray-800">Konten Proyek</h3>

                                                        <button onclick="showAddContent('{{ $selectedApplication->application_id }}')"
                                                            class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors">
                                                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 4v16m8-8H4" />
                                                            </svg>
                                                            Tambah Konten Proyek
                                                        </button>
                                                    </div>

                                                    <!-- List Konten -->
                                                    <div class="space-y-3">
                                                        @forelse($projectContents ?? [] as $content)
                                                            <div
                                                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg group hover:bg-gray-100 transition-colors">
                                                                <span class="text-gray-700">{{ $content->title }}</span>
                                                                <div class="flex items-center gap-2">
                                                                    <!-- Edit Button -->
                                                                    <button onclick="editContent('{{ $content->content_id }}')"
                                                                        class="p-1.5 text-gray-500 hover:text-teal-600 transition-colors">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                        </svg>
                                                                    </button>
                                                                    <!-- Delete Button -->
                                                                    <button onclick="deleteContent('{{ $content->content_id }}')"
                                                                        class="p-1.5 text-gray-500 hover:text-red-600 transition-colors">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="text-center py-6 text-gray-500">
                                                                <p>Belum ada konten proyek</p>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-span-8 flex justify-center items-center bg-white rounded-xl p-8">
                            <p class="text-gray-500">Pilih pelamar untuk melihat detail</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @include('projects.Modal.edit-content')
        @include('projects.Modal.accept-application')
        @include('projects.Modal.add-content')

        <script>
            // Fungsi untuk menangani penolakan aplikasi
            async function rejectApplication(applicationId) {
                // Tampilkan konfirmasi terlebih dahulu
                const confirmResult = await Swal.fire({
                    title: 'Tolak Aplikasi?',
                    text: "Apakah Anda yakin ingin menolak aplikasi ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#14b8a6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                });

                // Jika user mengkonfirmasi
                if (confirmResult.isConfirmed) {
                    try {
                        // Kirim request ke endpoint reject
                        const response = await fetch(`/applications/${applicationId}/reject`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: result.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(result.message || 'Terjadi kesalahan saat menolak aplikasi');
                        }
                    } catch (error) {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message || 'Terjadi kesalahan saat menolak aplikasi.'
                        });
                    }
                }
            }

            // Fungsi untuk menghapus konten
            async function deleteContent(contentId) {
                // Konfirmasi penghapusan dengan SweetAlert
                const confirmResult = await Swal.fire({
                    title: 'Hapus Konten?',
                    text: "Konten yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Warna merah untuk delete
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                });

                // Jika user mengkonfirmasi penghapusan
                if (confirmResult.isConfirmed) {
                    try {
                        const response = await fetch(`/project-contents/${contentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: result.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(result.message || 'Terjadi kesalahan saat menghapus konten');
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message || 'Terjadi kesalahan saat menghapus konten'
                        });
                    }
                }
            }
        </script>
    </x-app-layout>
