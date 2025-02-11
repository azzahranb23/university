<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Back Button -->
            <div class="mb-6">
                <button onclick="history.back()"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </button>
            </div>

            <!-- Header Card with Project Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Banner with Project Photo -->
                <div class="relative h-48">
                    <img src="{{ $application->project->photo ? asset($application->project->photo) : asset('images/default-project.jpg') }}"
                        class="w-full h-48 object-cover" alt="{{ $application->project->title }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                    <!-- Project Title & Basic Info -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">{{ $application->project->title }}</h1>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-sm">{{ $application->project->category->category_name }}</span>
                                    <span class="w-1 h-1 bg-white rounded-full"></span>
                                    <span class="text-sm">ID: #{{ $application->project->project_id }}</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-orange-500 rounded-full text-sm">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Two Column Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - User Info -->
                        <div class="lg:col-span-1">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="{{ $application->user->photo ? asset($application->user->photo) : asset('images/default-avatar.jpg') }}"
                                    class="h-16 w-16 rounded-full object-cover border-2 border-gray-200" alt="{{ $application->user->name }}">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">{{ $application->user->name }}</h2>
                                    <p class="text-sm text-gray-600">{{ $application->position }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                <p><span class="text-gray-500">NIM/NIP:</span> {{ $application->user->nim_nip }}</p>
                                <p><span class="text-gray-500">Jurusan:</span> {{ $application->user->major->major_name ?? '-' }}</p>
                                <p><span class="text-gray-500">Departemen:</span> {{ $application->user->department->department_name ?? '-' }}</p>
                            </div>

                            <!-- Link Diskusi -->
                            @if ($application->link_room_discus)
                                <a href="{{ $application->link_room_discus }}" target="_blank"
                                    class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Ruang Diskusi
                                </a>
                            @endif
                        </div>

                        <!-- Right Column - Project Details -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Project Description -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Proyek</h3>
                                <p class="text-gray-600 text-sm">{{ $application->project->description }}</p>
                            </div>

                            <!-- Progress Stats -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-sm text-gray-500">Progress</p>
                                    <!-- Progress Section -->
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="progress-bar bg-teal-600 h-2.5 rounded-full transition-all duration-300"
                                            style="width: {{ $application->progress ?? 0 }}%">
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        Progress: <span class="progress-text">{{ $application->progress ?? 0 }}%</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-500">Sisa Waktu</p>
                                    <p class="text-sm font-medium">
                                        {{ $application->remaining_days }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-500">Mulai</p>
                                    <p class="text-sm font-medium">
                                        {{ $application->start_date ? Carbon\Carbon::parse($application->start_date)->format('d M Y') : '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-500">Selesai</p>
                                    <p class="text-sm font-medium">
                                        {{ $application->finish_date ? Carbon\Carbon::parse($application->finish_date)->format('d M Y') : '-' }}</p>
                                </div>
                            </div>

                            <!-- Benefits & Positions -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Benefits</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        {!! nl2br(e($application->project->benefits)) !!}
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Posisi</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach (json_decode($application->project->positions) as $position)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                                                {{ $position }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Contents -->
            <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <!-- Title Section -->
                <div class="relative px-8 py-5 bg-gray-50 border-b border-gray-200">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-10 bg-teal-500 rounded-r"></div>
                    <h3 class="text-2xl font-semibold text-gray-800 pl-6">Penugasan</h3>
                </div>

                <!-- Content Section -->
                <div class="p-8 space-y-6">
                    @forelse($projectContents ?? [] as $content)
                        <!-- Content Card -->
                        <div class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-300"
                            id="card_{{ $content->content_id }}">
                            <!-- Header dengan toggle button -->
                            <div class="bg-gradient-to-r from-gray-50 to-white p-6 border-b border-gray-200">
                                <div class="flex justify-between items-center gap-6">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-teal-600 transition-colors">
                                                    {{ $content->title }}
                                                </h4>
                                                <!-- Indikator Link -->
                                                <div id="link_indicator_{{ $content->document_path }}">
                                                    @if ($content->document_path)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-700">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                            Terhubung
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                            Belum Terhubung
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Toggle Button -->
                                            <button onclick="toggleDetails('{{ $content->content_id }}')"
                                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-full transition-all duration-200">
                                                <span class="mr-1" id="buttonText_{{ $content->content_id }}">Detail</span>
                                                <svg id="icon_{{ $content->content_id }}"
                                                    class="w-4 h-4 transform transition-transform duration-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600">{{ $content->description }}</p>
                                    </div>
                                    <div class="text-center">
                                        <div
                                            class="px-4 py-2 rounded-lg text-sm font-medium {{ Carbon\Carbon::parse($content->due_date)->isPast() ? 'bg-red-100 text-red-600' : 'bg-teal-100 text-teal-600' }}">
                                            Jatuh Tempo
                                            <p class="text-sm font-bold">{{ Carbon\Carbon::parse($content->due_date)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details -->
                            <div id="details_{{ $content->content_id }}" class="hidden transition-all duration-200">
                                <div class="p-6 space-y-4">
                                    <!-- Upload Document Section -->
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Dokumen Tugas</span>
                                            @if ($content->document_path)
                                                <span class="flex items-center text-xs text-green-600">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Terakhir diupdate: {{ Carbon\Carbon::parse($content->updated_at)->format('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- File Upload Area -->
                                        <div class="space-y-4">
                                            @if ($content->document_path)
                                                <!-- Preview Area jika sudah ada dokumen -->
                                                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="p-2 bg-teal-50 rounded-lg">
                                                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">Dokumen Tersimpan</p>
                                                            <p class="text-xs text-gray-500">{{ basename($content->document_path) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <!-- Download Button -->
                                                        <a href="{{ asset($content->document_path) }}" target="_blank"
                                                            class="inline-flex items-center px-3 py-1.5 text-sm text-teal-600 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                            Unduh
                                                        </a>
                                                        <!-- Delete Button -->
                                                        <button onclick="deleteDocument('{{ $content->content_id }}')"
                                                            class="inline-flex items-center px-3 py-1.5 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Upload Form -->
                                                <form id="uploadForm_{{ $content->content_id }}"
                                                    class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-teal-500 transition-colors">
                                                    <input type="file" id="document_{{ $content->content_id }}"
                                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                        onchange="handleFileUpload('{{ $content->content_id }}')">
                                                    <div class="space-y-2">
                                                        <svg class="mx-auto w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                        </svg>
                                                        <p class="text-sm text-gray-600">
                                                            <span class="font-medium text-teal-600">Klik untuk upload</span> atau drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500">PDF, DOC, DOCX, TXT, RAR, atau ZIP (Max. 5MB)</p>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>


                                    <!-- Info Grid -->
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm text-gray-700">
                                        <!-- Created By -->
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Dibuat oleh</p>
                                                <p class="font-medium text-gray-900">{{ $content->creator->name }}</p>
                                            </div>
                                        </div>

                                        <!-- Assigned To -->
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Ditugaskan ke</p>
                                                <p class="font-medium text-gray-900">{{ $content->assignee->name ?? 'Belum ditugaskan' }}</p>
                                            </div>
                                        </div>

                                        <!-- Start Date -->
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Mulai</p>
                                                <p class="font-medium text-gray-900">
                                                    {{ Carbon\Carbon::parse($content->start_date)->format('d M Y') }}</p>
                                            </div>
                                        </div>

                                        <!-- Duration -->
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Durasi</p>
                                                <p class="font-medium text-gray-900">
                                                    {{ Carbon\Carbon::parse($content->start_date)->diffInDays($content->due_date) }} hari
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada penugasan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        async function updateLink(contentId) {
            const linkInput = document.getElementById(`link_${contentId}`);
            const progressBar = document.querySelector('.progress-bar');
            const progressText = document.querySelector('.progress-text');
            const linkIndicator = document.getElementById(`link_indicator_${contentId}`);
            const newLink = linkInput.value;

            try {
                const response = await fetch(`/project-contents/${contentId}/update-link`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        link_task: newLink
                    })
                });

                const result = await response.json();

                if (result.success) {
                    console.log('Response:', result);

                    // Update progress bar
                    if (result.progress !== undefined) {
                        if (progressBar) {
                            progressBar.style.width = `${result.progress}%`;
                        }
                        if (progressText) {
                            progressText.textContent = `${result.progress}%`;
                        }
                    }

                    // Update link indicator
                    if (linkIndicator) {
                        if (newLink) {
                            linkIndicator.innerHTML = `
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Terhubung
                            </span>`;
                        } else {
                            linkIndicator.innerHTML = `
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Belum Terhubung
                            </span>`;
                        }
                    }

                    // Update timestamp
                    const timestampElement = document.getElementById(`timestamp_${contentId}`);
                    if (timestampElement) {
                        const now = new Date().toLocaleString('id-ID');
                        timestampElement.innerHTML = `
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Terakhir diupdate: ${now}
                    `;
                    }

                    // Tampilkan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Gagal menyimpan link tugas'
                });
            }
        }
    </script>

    <script>
        function toggleDetails(contentId) {
            const details = document.getElementById('details_' + contentId);
            const icon = document.getElementById('icon_' + contentId);
            const buttonText = document.getElementById('buttonText_' + contentId);

            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
                icon.classList.add('rotate-180');
                buttonText.textContent = 'Tutup';
            } else {
                details.classList.add('hidden');
                icon.classList.remove('rotate-180');
                buttonText.textContent = 'Detail';
            }
        }
    </script>

    <script>
        function handleFileUpload(contentId) {
            const fileInput = document.getElementById(`document_${contentId}`);
            const file = fileInput.files[0];

            if (!file) return;

            // Validasi tipe file - menambahkan RAR dan ZIP
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'text/plain',
                'application/x-rar-compressed', // untuk RAR
                'application/rar', // untuk RAR
                'application/x-zip-compressed', // untuk ZIP
                'application/zip' // untuk ZIP
            ];

            // Validasi extensi file sebagai backup
            const allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'rar', 'zip'];
            const fileExtension = file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Tidak Didukung',
                    text: 'Harap upload file dalam format PDF, DOC, DOCX, TXT, RAR, atau ZIP'
                });
                return;
            }

            // Validasi ukuran file (5MB)
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal adalah 5MB'
                });
                return;
            }

            // Buat FormData
            const formData = new FormData();
            formData.append('document', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            // Loading state
            Swal.fire({
                title: 'Mengupload...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Upload file
            fetch(`/project-contents/${contentId}/upload-document`, {
                    method: 'POST',
                    body: formData
                })
                .then(async response => {
                    if (!response.ok) {
                        // Coba untuk mendapatkan pesan error dari response
                        let errorMessage;
                        try {
                            const errorData = await response.json();
                            errorMessage = errorData.message;
                        } catch {
                            errorMessage = `HTTP error! status: ${response.status}`;
                        }
                        throw new Error(errorMessage);
                    }
                    return response.json();
                })
                .then(result => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Dokumen berhasil diupload',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message || 'Terjadi kesalahan saat mengupload dokumen. Silakan coba lagi.'
                    });
                });
        }

        function deleteDocument(contentId) {
            Swal.fire({
                title: 'Hapus Dokumen?',
                text: "Dokumen yang dihapus tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/project-contents/${contentId}/delete-document`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(async response => {
                            if (!response.ok) {
                                let errorMessage;
                                try {
                                    const errorData = await response.json();
                                    errorMessage = errorData.message;
                                } catch {
                                    errorMessage = `HTTP error! status: ${response.status}`;
                                }
                                throw new Error(errorMessage);
                            }
                            return response.json();
                        })
                        .then(result => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Dokumen berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message || 'Terjadi kesalahan saat menghapus dokumen. Silakan coba lagi.'
                            });
                        });
                }
            });
        }
    </script>
</x-app-layout>
