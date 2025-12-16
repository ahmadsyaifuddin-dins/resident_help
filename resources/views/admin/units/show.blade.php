<x-app-layout>
    <x-slot name="header">
        {{ __('Detail Unit Rumah') }}
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-purple-600 p-4 text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Blok {{ $unit->block }} - Nomor {{ $unit->number }}</h2>
            <span class="bg-white text-purple-700 px-2 py-1 rounded text-sm font-bold">Tipe {{ $unit->type }}</span>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-1 md:col-span-2 bg-green-50 p-4 rounded border border-green-200 text-center">
                    <label class="text-sm text-green-600 font-bold">Harga Jual</label>
                    <p class="text-3xl font-bold text-green-800">Rp {{ number_format($unit->price, 0, ',', '.') }}</p>
                </div>

                <div>
                    <h4 class="font-bold text-gray-700 mb-3 border-b pb-1">Spesifikasi Fisik</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex justify-between"><span>Luas Tanah:</span> <strong>{{ $unit->land_size }}
                                m²</strong></li>
                        <li class="flex justify-between"><span>Luas Bangunan:</span> <strong>{{ $unit->building_size }}
                                m²</strong></li>
                        <li class="flex justify-between"><span>Listrik:</span> <strong>{{ $unit->electricity }}
                                VA</strong></li>
                        <li class="flex justify-between"><span>Air:</span> <strong>{{ $unit->water_source }}</strong>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-700 mb-3 border-b pb-1">Status & Lainnya</h4>
                    <p class="mb-2">
                        Status:
                        @if ($unit->status == 'Tersedia')
                            <span class="text-green-600 font-bold">Tersedia</span>
                        @else
                            <span class="text-red-600 font-bold">Terjual</span>
                        @endif
                    </p>
                    <label class="text-xs text-gray-400 uppercase">Deskripsi Ruangan:</label>
                    <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded mt-1">{{ $unit->room_details }}</p>
                </div>
            </div>

            <div class="flex justify-end space-x-2 border-t pt-4">
                <a href="{{ route('admin.units.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                <a href="{{ route('admin.units.edit', $unit->id) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit</a>
            </div>
        </div>
    </div>
</x-app-layout>
