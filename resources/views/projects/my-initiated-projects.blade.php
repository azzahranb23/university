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
                                    @if ($application->project->status == 'completed')
                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    @else
                                        @switch($application->status)
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
                                    @endif
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
                                    <p class="mt-4">Tidak ada proyek</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Main Content -->
                    @if ($selectedApplication)
                        <div class="col-span-8">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                                <h2 class="text-2xl font-bold mb-4">{{ $selectedApplication->project->title }}</h2>

                                <div class="space-y-6">
                                    <!-- Project Image -->
                                    <div class="relative h-48 rounded-xl overflow-hidden">
                                        <img src="{{ $selectedApplication->project->photo ? asset($selectedApplication->project->photo) : asset('images/project-banner.jpg') }}"
                                            class="w-full h-full object-cover" alt="{{ $selectedApplication->project->title }}">
                                    </div>

                                    <!-- Project Description -->
                                    <div class="text-gray-600 leading-relaxed">
                                        {{ $selectedApplication->project->description }}
                                    </div>

                                    <!-- Status Section -->
                                    <div class="bg-gray-50 rounded-xl p-6">
                                        @if ($application->project->status == 'completed')
                                            <div class="flex items-center justify-between w-full">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-gray-700 font-medium">Status:</span>
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Selesai
                                                    </span>
                                                </div>

                                                <button onclick="confirmActive()"
                                                    class="inline-flex items-center px-4 py-2 border-2 border-teal-500 text-teal-600 hover:bg-teal-50 rounded-lg transition-all duration-200 font-medium">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Aktifkan Kembali
                                                </button>
                                            </div>
                                        @else
                                            @switch($selectedApplication->status)
                                                @case('pending')
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-gray-700 font-medium">Status:</span>
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Menunggu
                                                        </span>
                                                    </div>
                                                @break

                                                @case('accepted')
                                                    <div class="flex items-center justify-between w-full">
                                                        <div class="flex items-center gap-3">
                                                            <span class="text-gray-700 font-medium">Status:</span>
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                </svg>
                                                                On Going
                                                            </span>
                                                        </div>

                                                        <button onclick="confirmComplete()"
                                                            class="inline-flex items-center px-4 py-2 border-2 border-cyan-500 text-cyan-600 hover:bg-cyan-50 rounded-lg transition-all duration-200 font-medium">
                                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Tandai Selesai
                                                        </button>
                                                    </div>
                                                @break

                                                @case('rejected')
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-gray-700 font-medium">Status:</span>
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Ditolak
                                                        </span>
                                                    </div>
                                                @break
                                            @endswitch
                                        @endif
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
                                                    {{ $selectedApplication->user->role === 'student' ? 'Mahasiswa' : 'Dosen' }}
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

                                        {{-- Document Link --}}
                                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                            <div class="mb-4">
                                                <label class="text-lg font-semibold text-gray-800">
                                                    Dokumen Pendukung
                                                </label>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                <input type="text" value="{{ $selectedApplication->documents }}"
                                                    class="flex-1 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-600" readonly>

                                                <a href="{{ $selectedApplication->documents }}" target="_blank"
                                                    class="inline-flex items-center px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    Buka Link
                                                </a>
                                            </div>
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
                                                    <div class="flex justify-between items-center mb-3">
                                                        <div class="flex items-center gap-3">
                                                            <div class="p-2 bg-gray-100 rounded-lg">
                                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                            <h3 class="font-semibold text-gray-800">Periode Kegiatan</h3>
                                                        </div>
                                                        @if ($application->project->status == 'active')
                                                            <button onclick="showEditPeriodModal('{{ $selectedApplication->application_id }}')"
                                                                class="p-2 text-gray-500 hover:text-teal-600 transition-colors">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </button>
                                                        @endif
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
                                                        <h3 class="text-xl font-bold text-gray-800">Penugasan</h3>
                                                        @if ($application->project->status == 'active')
                                                            <button onclick="showAddContent('{{ $selectedApplication->application_id }}')"
                                                                class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors">
                                                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 4v16m8-8H4" />
                                                                </svg>
                                                                Tambah Penugasan
                                                            </button>
                                                        @endif
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
                                                                    @if ($application->project->status == 'active')
                                                                        <!-- Delete Button -->
                                                                        <button onclick="deleteContent('{{ $content->content_id }}')"
                                                                            class="p-1.5 text-gray-500 hover:text-red-600 transition-colors">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                                viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                            </svg>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="text-center py-6 text-gray-500">
                                                                <p>Belum ada penugasan</p>
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
        @include('projects.Modal.edit-period')

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
                const confirmResult = await Swal.fire({
                    title: 'Hapus Penugasan?',
                    text: "Penugasan yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                });

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
                            throw new Error(result.message || 'Terjadi kesalahan saat menghapus penugasan');
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message || 'Terjadi kesalahan saat menghapus penugasan'
                        });
                    }
                }
            }

            function confirmComplete() {
                Swal.fire({
                    title: 'Selesaikan Proyek?',
                    text: "Apakah Anda yakin ingin menandai proyek ini sebagai selesai?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Selesaikan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat form untuk submit
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('projects.complete', $selectedApplication->application_id) }}';

                        // Tambahkan CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;

                        // Tambahkan method spoofing karena menggunakan PATCH
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PATCH';

                        // Append semua ke form dan submit
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            function confirmActive() {
                Swal.fire({
                    title: 'Aktifkan Proyek?',
                    text: "Apakah Anda yakin ingin mengaktifkan kembali proyek ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Aktifkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat form untuk submit
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('projects.activate', $selectedApplication->application_id) }}';

                        // Tambahkan CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;

                        // Tambahkan method spoofing karena menggunakan PATCH
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PATCH';

                        // Append semua ke form dan submit
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            // Fungsi untuk menampilkan modal edit periode
            function showEditPeriodModal(applicationId) {
                // Set action URL form
                const form = document.getElementById('editPeriodForm');
                form.action = `/applications/${applicationId}/update-period`;

                // Debug untuk melihat nilai yang akan diset
                console.log('Start Date:', @json($selectedApplication->start_date));
                console.log('Finish Date:', @json($selectedApplication->finish_date));

                // Set nilai awal form
                document.getElementById('edit_start_date').value = '{{ \Carbon\Carbon::parse($selectedApplication->start_date)->format('Y-m-d') }}';
                document.getElementById('edit_finish_date').value = '{{ \Carbon\Carbon::parse($selectedApplication->finish_date)->format('Y-m-d') }}';
                document.getElementById('edit_link_room_discus').value = '{{ $selectedApplication->link_room_discus }}';

                // Tampilkan modal
                document.getElementById('editPeriodModal').classList.remove('hidden');
            }

            // Fungsi untuk menutup modal
            function closeEditPeriodModal() {
                document.getElementById('editPeriodModal').classList.add('hidden');
            }

            // Event listener untuk form edit
            document.addEventListener('DOMContentLoaded', function() {
                const editPeriodForm = document.getElementById('editPeriodForm');
                if (editPeriodForm) {
                    editPeriodForm.addEventListener('submit', async function(e) {
                        e.preventDefault();

                        try {
                            const response = await fetch(this.action, {
                                method: 'POST',
                                body: new FormData(this),
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                }
                            });

                            const result = await response.json();

                            if (result.success) {
                                // Tutup modal
                                closeEditPeriodModal();

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
                                throw new Error(result.message || 'Terjadi kesalahan saat memperbarui data');
                            }
                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message || 'Terjadi kesalahan saat memperbarui data'
                            });
                        }
                    });
                }
            });
        </script>
    </x-app-layout>
