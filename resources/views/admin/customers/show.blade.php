<x-app-layout>
    <x-slot name="header">
        {{ __('Detail Biodata Nasabah') }}
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $customer->name }}</h3>
        <p class="text-gray-500 mb-6 flex items-center">
            <i class="fas fa-id-card mr-2 text-purple-500"></i> NIK: {{ $customer->nik }}
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-bold text-sm text-gray-700 mb-3">Informasi Kontak</h4>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-500">Nomor HP / WA</label>
                        <p class="font-medium">{{ $customer->phone }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Akun User Terkait</label>
                        <p class="font-medium text-indigo-600">{{ $customer->user->email ?? 'Tidak ada akun' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-bold text-sm text-gray-700 mb-3">Alamat</h4>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-500">Alamat KTP</label>
                        <p class="text-sm">{{ $customer->address }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Alamat Domisili</label>
                        <p class="text-sm">{{ $customer->domicile_address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.customers.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            <a href="{{ route('admin.customers.edit', $customer->id) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit Biodata</a>
        </div>
    </div>
</x-app-layout>
