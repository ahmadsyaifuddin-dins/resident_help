<x-app-layout>
    <x-slot name="header">
        {{ __('Detail Teknisi') }}
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $technician->name }}</h3>
                <p class="text-gray-500">Spesialis: <strong>{{ $technician->specialty }}</strong></p>
            </div>
            <span
                class="px-3 py-1 rounded-full text-sm font-bold {{ $technician->status == 'Available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $technician->status }}
            </span>
        </div>

        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="text-xs font-bold text-gray-400 uppercase">Kontak</label>
                <div class="flex items-center mt-1">
                    <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                    <span class="text-lg font-mono text-gray-800">{{ $technician->phone }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-2">
            <a href="{{ route('admin.technicians.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            <a href="{{ route('admin.technicians.edit', $technician->id) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit</a>
        </div>
    </div>
</x-app-layout>
