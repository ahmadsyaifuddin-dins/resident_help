<x-app-layout>
    <x-slot name="header">
        {{ __('Detail Pengguna') }}
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center space-x-4 mb-6">
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-user fa-2x"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'nasabah' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-4">
            <div>
                <label class="text-sm text-gray-500">Email Address</label>
                <p class="font-medium text-gray-800">{{ $user->email }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Nomor HP</label>
                <p class="font-medium text-gray-800">{{ $user->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Terdaftar Sejak</label>
                <p class="font-medium text-gray-800">{{ $user->created_at->translatedFormat('d F Y') }}</p>
            </div>

            {{-- TAMBAHAN: INFO UNIT JIKA ROLE WARGA --}}
            @if ($user->role == 'warga')
                <div class="col-span-1 md:col-span-2 bg-yellow-50 p-4 rounded border border-yellow-200">
                    <label class="text-sm font-bold text-yellow-800 block mb-1">
                        <i class="fas fa-home mr-1"></i> Unit Tempat Tinggal
                    </label>
                    @if ($user->ownership)
                        <p class="text-lg font-bold text-gray-800">
                            Blok {{ $user->ownership->unit->block }} - No {{ $user->ownership->unit->number }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Milik Nasabah: <strong>{{ $user->ownership->customer->name }}</strong>
                        </p>
                    @else
                        <span class="text-red-500 font-semibold text-sm">Belum dihubungkan ke Unit Rumah.</span>
                    @endif
                </div>
            @endif

        </div>

        <div class="mt-8 flex justify-end space-x-2">
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit</a>
        </div>
    </div>
</x-app-layout>
