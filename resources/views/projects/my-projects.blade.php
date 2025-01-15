<x-app-layout>
    <div class="min-h-screen bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Proyek Saya</h2>
                <a href="{{ route('projects.public') }}" class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                    + Proyek
                </a>
            </div>

            <!-- Tabs -->
            <div class="flex gap-2 mb-6">
                <a href="{{ route('application.all') }}"
                    class="px-4 py-2 rounded-lg {{ $activeTab === 'semua' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-teal-50' }}">
                    Semua
                </a>
                <a href="{{ route('application.request') }}"
                    class="px-4 py-2 rounded-lg {{ $activeTab === 'request' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Request
                </a>
                <a href="{{ route('application.on-going') }}"
                    class="px-4 py-2 rounded-lg {{ $activeTab === 'on-going' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    On Going
                </a>
                <a href="{{ route('application.finished') }}"
                    class="px-4 py-2 rounded-lg {{ $activeTab === 'selesai' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Selesai
                </a>
                <a href="{{ route('application.rejected') }}"
                    class="px-4 py-2 rounded-lg {{ $activeTab === 'ditolak' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Ditolak
                </a>
            </div>

            <!-- Project List -->
            <div class="space-y-4">
                @forelse($applications as $application)
                    <div class="bg-white rounded-lg border border-gray-200 hover:border-teal-200 transition-colors p-6">
                        <!-- Project Info -->
                        <div class="flex justify-between items-start">
                            <div class="flex items-start space-x-4">
                                <img src="{{ $application->project->photo ? asset($application->project->photo) : asset('images/project-icon.jpg') }}"
                                    class="w-16 h-16 rounded" alt="Project">
                                <div>
                                    <h3 class="font-medium text-lg text-gray-900">{{ $application->project->title }}</h3>
                                    <p class="text-gray-600">Posisi: {{ $application->position }}</p>

                                    <!-- Project Owner Info -->
                                    <div class="flex items-center mt-2 space-x-2">
                                        <img src="{{ $application->project->user->photo ? asset('storage/' . $application->project->user->photo) : asset('images/default-avatar.jpg') }}"
                                            class="w-6 h-6 rounded-full" alt="{{ $application->project->user->name }}">
                                        <span class="text-sm text-gray-600">
                                            {{ $application->project->user->name }} |
                                            {{ $application->project->user->role === 'lecturer' ? 'Dosen' : 'Mahasiswa' }}
                                        </span>
                                    </div>

                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        @if ($application->progress !== null && $application->progress < 100)
                                            <p>Progress: {{ $application->progress }}%/100%</p>
                                        @elseif ($application->progress == 100)
                                            <p>Progress: Selesai</p>
                                        @endif
                                        @if ($application->finish_date)
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span
                                                    class="font-medium {{ $application->finish_date && now()->greaterThan(Carbon\Carbon::parse($application->finish_date)) ? 'text-red-500' : 'text-teal-600' }}">
                                                    {{ $application->remaining_days }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                @if ($application->status === 'pending')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">Request</span>
                                @elseif($application->status === 'accepted' && $application->progress < 100)
                                    <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full">On Going</span>
                                @elseif($application->status === 'accepted' && $application->progress == 100)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full">Selesai</span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full">Ditolak</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full">Unknown</span>
                                @endif

                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if ($application->status === 'accepted')
                            <div class="mt-4 flex justify-end space-x-4">
                                @if ($application->progress < 100)
                                    <button onclick="finishProject({{ $application->application_id }})"
                                        class="px-4 py-2 border border-teal-500 text-teal-500 rounded-lg hover:bg-teal-50">
                                        Proyek Selesai
                                    </button>
                                @endif
                                @if ($application->link_room_discus)
                                    <a href="{{ route('applications.show', $application->application_id) }}"
                                        class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">
                                        Detail Proyek
                                    </a>
                                    <a href="{{ $application->link_room_discus }}" target="_blank"
                                        class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-teal-600">
                                        Masuk Ruang Diskusi
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        Tidak ada proyek yang ditemukan
                    </div>
                @endforelse
            </div>
        </div>
</x-app-layout>

<script>
    function finishProject(applicationId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Proyek akan ditandai sebagai selesai dan tidak dapat diubah lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proyek Selesai!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan POST menggunakan fetch
                fetch(`/applications/${applicationId}/finish`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Berhasil!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.href = '{{ route('application.finished') }}';
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghubungi server.',
                            'error'
                        );
                    });
            }
        });
    }
</script>
