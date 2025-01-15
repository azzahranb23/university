@extends('layouts.admin')

@section('title', 'Manajemen Aplikasi')

@section('content')
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Manajemen Aplikasi</h2>
                <p class="text-white/80 mt-1">Kelola semua aplikasi pendaftaran dari mahasiswa</p>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Applications -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-500/10 p-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Total Aplikasi</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['totalApplications'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-yellow-500/10 p-3">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Menunggu Review</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['pendingApplications'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Accepted Applications -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-green-500/10 p-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Diterima</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['acceptedApplications'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Rejected Applications -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="rounded-full bg-red-500/10 p-3">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-400 text-sm">Ditolak</p>
                    <h3 class="text-2xl font-semibold text-white">{{ $stats['rejectedApplications'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <table id="applicationsTable" class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($applications as $application)
                        <tr>
                            <!-- Mahasiswa -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="{{ $application->user->photo ? asset($application->user->photo) : asset('images/default-avatar.jpg') }}"
                                        alt="{{ $application->user->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $application->user->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $application->user->major->major_name }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Proyek -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded object-cover"
                                        src="{{ $application->project->photo ? asset($application->project->photo) : asset('images/project-banner.jpg') }}"
                                        alt="{{ $application->project->title }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $application->project->title }}</div>
                                        <div class="text-sm text-gray-400">
                                            Dosen: {{ $application->project->user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Posisi -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium bg-gray-700 text-white">
                                    {{ $application->position }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $application->status === 'accepted'
                                        ? 'bg-green-500/20 text-green-400'
                                        : ($application->status === 'rejected'
                                            ? 'bg-red-500/20 text-red-400'
                                            : 'bg-yellow-500/20 text-yellow-400') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>

                            <!-- Progress -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $application->progress ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-400">
                                        {{ $application->progress ?? 0 }}%
                                    </span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right space-x-2">
                                <button class="btn-detail text-blue-400 hover:text-blue-300" data-id="{{ $application->application_id }}" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                @if ($application->status === 'pending')
                                    <button class="btn-accept text-green-400 hover:text-green-300" data-id="{{ $application->application_id }}"
                                        title="Terima">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    <button class="btn-reject text-red-400 hover:text-red-300" data-id="{{ $application->application_id }}"
                                        title="Tolak">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block w-full max-w-3xl bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                <!-- Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">Detail Aplikasi</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-200 btn-close-modal">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Informasi Aplikasi -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Tanggal Aplikasi</label>
                                <p class="mt-1 text-white" id="detailDate"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Status</label>
                                <p class="mt-1" id="detailStatus"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Posisi yang Dilamar</label>
                                <p class="mt-1 text-white" id="detailPosition"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Progress</label>
                                <div class="mt-1 flex items-center">
                                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                                        <div id="detailProgressBar" class="bg-blue-600 h-2.5 rounded-full"></div>
                                    </div>
                                    <span id="detailProgressText" class="ml-2 text-white"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Timeline</label>
                            <div class="space-y-4">
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <div id="startDateDot" class="h-3 w-3 rounded-full bg-gray-400"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Start Date</p>
                                        <p class="text-white" id="detailStartDate">-</p>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <div id="finishDateDot" class="h-3 w-3 rounded-full bg-gray-400"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Finish Date</p>
                                        <p class="text-white" id="detailFinishDate">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Motivasi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Motivasi</label>
                        <div class="mt-1 p-4 bg-gray-700 rounded-lg">
                            <p class="text-white whitespace-pre-line" id="detailMotivation"></p>
                        </div>
                    </div>

                    <!-- Link Room Diskusi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Link Room Diskusi</label>
                        <a id="detailRoomLink" href="#" target="_blank" class="mt-1 text-blue-400 hover:text-blue-300 break-all"></a>
                    </div>

                    <!-- Documents -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Dokumen</label>
                        <a id="detailDocuments" href="#" target="_blank"
                            class="mt-1 inline-flex items-center text-blue-400 hover:text-blue-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Download Dokumen</span>
                        </a>
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
            // Ganti konfigurasi DataTables
            $('#applicationsTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 10,
                ordering: true,
                responsive: true,
                dom: '<"flex flex-col md:flex-row justify-between items-start md:items-center mb-4"lf>rtip',
                drawCallback: function() {
                    // Styling untuk input search
                    $('.dataTables_filter input').addClass(
                        'bg-gray-700 text-white rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500'
                    );

                    // Styling untuk select length
                    $('.dataTables_length select').addClass(
                        'bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'
                    );

                    // Styling untuk pagination
                    $('.dataTables_paginate .paginate_button').addClass('px-3 py-1 border border-gray-700 hover:bg-gray-700');
                    $('.dataTables_paginate .paginate_button.current').addClass(
                        'bg-blue-500 text-white border-blue-500 hover:bg-blue-600');
                }
            });

            // Detail Button Click
            $('.btn-detail').click(function() {
                const id = $(this).data('id');
                const application = @json($applications->keyBy('application_id'));
                const data = application[id];

                // Set data to modal
                $('#detailDate').text(moment(data.date).format('DD MMMM YYYY'));
                $('#detailPosition').text(data.position);
                $('#detailMotivation').text(data.motivation);
                $('#detailProgressBar').css('width', `${data.progress || 0}%`);
                $('#detailProgressText').text(`${data.progress || 0}%`);

                // Set status with color
                const statusElement = $('<span>').text(data.status.charAt(0).toUpperCase() + data.status.slice(1))
                    .addClass('px-2 py-1 text-xs rounded-full font-medium');

                if (data.status === 'accepted') {
                    statusElement.addClass('bg-green-500/20 text-green-400');
                } else if (data.status === 'rejected') {
                    statusElement.addClass('bg-red-500/20 text-red-400');
                } else {
                    statusElement.addClass('bg-yellow-500/20 text-yellow-400');
                }

                $('#detailStatus').html(statusElement);

                // Set dates
                if (data.start_date) {
                    $('#detailStartDate').text(moment(data.start_date).format('DD MMMM YYYY'));
                    $('#startDateDot').removeClass('bg-gray-400').addClass('bg-green-400');
                }
                if (data.finish_date) {
                    $('#detailFinishDate').text(moment(data.finish_date).format('DD MMMM YYYY'));
                    $('#finishDateDot').removeClass('bg-gray-400').addClass('bg-green-400');
                }

                // Set links and documents
                if (data.link_room_discus) {
                    $('#detailRoomLink').attr('href', data.link_room_discus).text(data.link_room_discus);
                } else {
                    $('#detailRoomLink').text('Belum tersedia');
                }

                if (data.documents) {
                    $('#detailDocuments').attr('href', data.documents).show();
                } else {
                    $('#detailDocuments').hide();
                }

                // Show modal
                $('#detailModal').removeClass('hidden');
            });

            // Accept Button Click
            $('.btn-accept').click(function() {
                const id = $(this).data('id');
                updateStatus(id, 'accepted');
            });

            // Reject Button Click
            $('.btn-reject').click(function() {
                const id = $(this).data('id');
                updateStatus(id, 'rejected');
            });

            // Update Status Function
            function updateStatus(id, status) {
                Swal.fire({
                    title: `Yakin ingin ${status === 'accepted' ? 'menerima' : 'menolak'} aplikasi ini?`,
                    text: "Status aplikasi akan diperbarui!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: status === 'accepted' ? '#10B981' : '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, update!',
                    cancelButtonText: 'Batal',
                    background: '#1F2937',
                    color: '#FFF'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/applications/${id}/status`;
                        form.innerHTML = `
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="${status}">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

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
    </script>
@endsection
