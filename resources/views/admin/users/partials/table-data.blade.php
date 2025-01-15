@foreach ($users as $user)
    <tr class="hover:bg-gray-700/50">
        <!-- User Info -->
        <td class="px-6 py-4">
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full object-cover"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}">
                <div class="ml-4">
                    <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                    <div class="text-sm text-gray-400">{{ $user->email }}</div>
                    <div class="text-xs text-gray-500">NIM/NIP: {{ $user->nim_nip }}</div>
                </div>
            </div>
        </td>

        <!-- Role -->
        <td class="px-6 py-4">
            <span
                class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $user->role === 'student'
                                        ? 'bg-blue-500/20 text-blue-400'
                                        : ($user->role === 'admin'
                                            ? 'bg-purple-500/20 text-purple-400'
                                            : 'bg-yellow-500/20 text-yellow-400') }}">
                {{ ucfirst($user->role) }}
            </span>
        </td>

        <!-- Department/Major -->
        <td class="px-6 py-4">
            @if ($user->department)
                <div class="text-sm text-white">{{ $user->department->department_name }}</div>
            @endif
            @if ($user->major)
                <div class="text-xs text-gray-400">{{ $user->major->major_name }}</div>
            @endif
        </td>

        <!-- Projects -->
        <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs rounded-full font-medium bg-green-500/20 text-green-400">
                {{ $user->projects->count() }} Proyek
            </span>
        </td>

        <!-- Status -->
        <td class="px-6 py-4">
            <span class="flex items-center">
                <span class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></span>
                <span class="text-sm text-gray-400">Aktif</span>
            </span>
        </td>

        <!-- Actions -->
        <td class="px-6 py-4 text-right space-x-3">
            <button class="text-gray-400 hover:text-blue-400 transition-colors" title="Detail">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
            <button class="text-gray-400 hover:text-yellow-400 transition-colors" title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </button>
            <button class="text-gray-400 hover:text-red-400 transition-colors" title="Hapus">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </td>
    </tr>
@endforeach
