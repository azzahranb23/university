@extends('layouts.admin')

@section('title', 'Manajemen Konten Proyek')

@section('content')
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Manajemen Konten Proyek</h2>
                <p class="text-white/80 mt-1">Monitor progress dan konten dari setiap proyek</p>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Contents -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-indigo-500/10 p-3">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Total Konten</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['totalContents'] }}</h3>
                </div>
            </div>
        </div>

        <!-- With Link -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-green-500/10 p-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Sudah Ada Link</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['withLink'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Without Link -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-yellow-500/10 p-3">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Belum Ada Link</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['withoutLink'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-500/10 p-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Total Proyek</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['totalProjects'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Content List -->
    @foreach ($contentsByProject as $projectId => $projectContents)
        <div class="bg-gray-800 rounded-lg shadow-lg mb-4">
            <!-- Project Header (Clickable) -->
            <div class="p-4 border-b border-gray-700 cursor-pointer hover:bg-gray-700/50 transition-colors"
                onclick="toggleProject('project-{{ $projectId }}')">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-lg object-cover"
                            src="{{ $projectContents->first()->project->photo ? asset($projectContents->first()->project->photo) : asset('images/projects/default.jpg') }}"
                            alt="{{ $projectContents->first()->project->title }}">
                        <div class="ml-3">
                            <h3 class="text-white font-medium">{{ $projectContents->first()->project->title }}</h3>
                            <div class="flex items-center text-sm space-x-2">
                                <span class="text-gray-400">{{ $projectContents->count() }} Konten</span>
                                <span class="text-gray-600">•</span>
                                <span class="text-gray-400">{{ $projectContents->whereNotNull('link_task')->count() }} Link Tersedia</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Badge untuk status link -->
                        <div class="flex items-center space-x-1">
                            <span
                                class="px-2 py-1 text-xs rounded-full font-medium
                            {{ $projectContents->whereNotNull('link_task')->count() === $projectContents->count()
                                ? 'bg-green-500/20 text-green-400'
                                : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ $projectContents->whereNotNull('link_task')->count() }}/{{ $projectContents->count() }}
                            </span>
                        </div>
                        <!-- Arrow icon -->
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" id="arrow-{{ $projectId }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content List (Collapsible) -->
            <div class="hidden" id="project-{{ $projectId }}">
                <div class="p-4 space-y-2">
                    @foreach ($projectContents as $content)
                        <div class="bg-gray-700/30 rounded-lg p-3 hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-white text-sm">{{ $content->title }}</h4>
                                        <span class="text-xs text-gray-400">
                                            {{ \Carbon\Carbon::parse($content->due_date)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Link Status -->
                                        @if ($content->link_task)
                                            <a href="{{ $content->link_task }}" target="_blank"
                                                class="inline-flex items-center text-blue-400 hover:text-blue-300 text-xs">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                Link Tugas
                                            </a>
                                        @else
                                            <span class="text-yellow-400 text-xs">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Belum ada link
                                            </span>
                                        @endif

                                        <!-- Detail Button -->
                                        <button class="btn-detail text-gray-400 hover:text-gray-300" data-content="{{ json_encode($content) }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <!-- Detail Modal -->
    <div id="detailModal" class="modal fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block w-full max-w-3xl bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                <!-- Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">Detail Konten Proyek</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-200 btn-close-modal">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Judul</label>
                                <p class="mt-1 text-white" id="detailTitle"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400">Progress</label>
                                <div class="mt-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-white" id="detailProgress"></span>
                                        <span class="text-sm text-gray-400" id="detailDueDate"></span>
                                    </div>
                                    <div class="w-full bg-gray-600 rounded-full h-2.5">
                                        <div id="detailProgressBar" class="bg-blue-600 h-2.5 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400">Link Tugas</label>
                                <a id="detailLinkTask" href="#" target="_blank" class="mt-1 text-blue-400 hover:text-blue-300"></a>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Dibuat Oleh</label>
                                <p class="mt-1 text-white" id="detailCreatedBy"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400">Ditugaskan Kepada</label>
                                <p class="mt-1 text-white" id="detailAssignedTo"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400">Tanggal</label>
                                <div class="mt-1 text-sm space-y-1">
                                    <p class="text-gray-400">Mulai: <span class="text-white" id="detailStartDate"></span></p>
                                    <p class="text-gray-400">Selesai: <span class="text-white" id="detailDueDate2"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Deskripsi</label>
                        <div class="mt-1 p-4 bg-gray-700 rounded-lg">
                            <p class="text-white whitespace-pre-line" id="detailDescription"></p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-900/50 px-6 py-4 flex justify-end">
                    <button type="button" class="btn-cancel px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            // Detail Button Click
            $('.btn-detail').click(function() {
                const content = $(this).data('content');

                // Set data to modal
                $('#detailTitle').text(content.title);
                $('#detailDescription').text(content.description);

                // Set dates
                $('#detailStartDate').text(moment(content.start_date).format('DD MMMM YYYY'));
                $('#detailDueDate, #detailDueDate2').text(moment(content.due_date).format('DD MMMM YYYY'));

                // Set creator and assignee
                $('#detailCreatedBy').text(content.creator ? content.creator.name : '-');
                $('#detailAssignedTo').text(content.assignee ? content.assignee.name : '-');

                // Set link task
                if (content.link_task) {
                    $('#detailLinkTask').attr('href', content.link_task).text(content.link_task).show();
                } else {
                    $('#detailLinkTask').hide();
                }

                // Show modal
                $('#detailModal').removeClass('hidden');
                event.stopPropagation(); // Prevent collapse/expand trigger
            });

            // Close Modal
            $('.btn-close-modal, .btn-cancel').click(function() {
                $(this).closest('.modal').addClass('hidden');
            });

            // Close Modal when clicking outside
            $('.modal').click(function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });
        });

        // Function untuk collapse/expand
        function toggleProject(projectId) {
            const content = document.getElementById(projectId);
            const arrow = document.getElementById('arrow-' + projectId.split('-')[1]);

            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>

    <!-- Script untuk collapse/expand -->
    <script>
        function toggleProject(projectId) {
            const content = document.getElementById(projectId);
            const arrow = document.getElementById('arrow-' + projectId.split('-')[1]);

            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Expand project jika ada error di dalamnya
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                const projectId = '{{ session('projectId') }}';
                if (projectId) {
                    const element = document.getElementById('project-' + projectId);
                    if (element) {
                        element.classList.remove('hidden');
                        element.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            @endif
        });
    </script>
@endsection
