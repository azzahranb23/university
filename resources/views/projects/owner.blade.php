<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Profile Section -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Profile</h1>
                <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}"
                    class="w-32 h-32 rounded-full mx-auto shadow-md border border-gray-200">
            </div>

            <!-- User Details -->
            <div class="bg-white p-6 rounded-lg shadow-md border">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Pengguna</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" readonly value="{{ $user->nim_nip }}"
                            class="w-full px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" readonly value="{{ $user->name }}"
                            class="w-full px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <input type="text" readonly value="{{ $user->major->name ?? 'Tidak ada jurusan' }}"
                            class="w-full px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <input type="text" readonly value="{{ $user->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}"
                            class="w-full px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <input type="text" readonly value="{{ $user->phone }}"
                            class="w-full px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input type="email" readonly value="{{ $user->email }}"
                            class="w-full px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg text-gray-600 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div class="mt-12">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Inisiasi Proyek</h2>
                <div class="grid grid-cols-1 gap-6">
                    @forelse ($projects as $project)
                        <div class="flex items-center bg-white p-6 rounded-lg shadow-md border hover:shadow-lg transition-shadow">
                            <img src="{{ asset($project->photo) }}" alt="{{ $project->title }}" class="w-16 h-16 rounded-lg object-cover">
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $project->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $project->duration }}</p>
                            </div>
                            <a href="{{ route('projects.public', ['project' => $project->project_id] + request()->only(['search', 'category'])) }}"
                                class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-colors">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    @empty
                        <p class="text-center text-gray-600">Belum ada proyek yang diinisiasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
