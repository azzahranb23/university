@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-white text-2xl font-bold">Edit {{ $user->role === 'student' ? 'Mahasiswa' : 'Dosen' }}</h2>
                <p class="text-white/80 mt-1">Edit informasi user</p>
            </div>
            <a href="{{ route('admin.users') }}"
                class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto Profil Current -->
                <div class="md:col-span-2 flex justify-center">
                    <div class="text-center">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}" alt="Profile Photo"
                            class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                        <p class="text-gray-400 text-sm">Foto Profil Saat Ini</p>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM/NIP -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">{{ $user->role === 'student' ? 'NIM' : 'NIP' }}</label>
                    <input type="text" name="nim_nip" value="{{ old('nim_nip', $user->nim_nip) }}" required
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nim_nip')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password"
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Jenis Kelamin</label>
                    <select name="gender" required
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                @if ($user->role === 'student')
                    <!-- Program Studi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Program Studi</label>
                        <select name="major_id" required
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach ($majors as $major)
                                <option value="{{ $major->major_id }}" {{ old('major_id', $user->major_id) == $major->major_id ? 'selected' : '' }}>
                                    {{ $major->major_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('major_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <!-- Departemen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Departemen</label>
                        <select name="department_id" required
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach ($departments as $department)
                                <option value="{{ $department->department_id }}"
                                    {{ old('department_id', $user->department_id) == $department->department_id ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Ganti Foto</label>
                    <input type="file" name="photo" accept="image/*"
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('photo')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        // Fungsi untuk memuat program studi berdasarkan departemen
        function loadMajors(departmentId) {
            const majorSelect = document.getElementById('major_id');

            // Reset opsi program studi
            majorSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

            if (!departmentId) return;

            // Ambil data program studi berdasarkan departemen
            fetch(`/api/departments/${departmentId}/majors`)
                .then(response => response.json())
                .then(majors => {
                    majors.forEach(major => {
                        const option = document.createElement('option');
                        option.value = major.major_id;
                        option.textContent = major.major_name;
                        majorSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Event listener untuk perubahan departemen
        document.getElementById('department_id')?.addEventListener('change', function() {
            loadMajors(this.value);
        });

        // Load majors saat halaman dimuat jika ada departemen yang dipilih
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department_id');
            if (departmentSelect?.value) {
                loadMajors(departmentSelect.value);
            }
        });
    </script>
@endsection
