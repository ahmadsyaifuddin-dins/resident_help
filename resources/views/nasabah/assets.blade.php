<x-app-layout>
    <x-slot name="header">
        {{ __('Aset Properti Saya') }}
    </x-slot>

    <div class="container mx-auto">
        @if ($ownerships->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-home fa-4x"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700">Belum Ada Data Rumah</h3>
                <p class="text-gray-500 mt-2">
                    Data kepemilikan unit Anda belum terdaftar di sistem.<br>
                    Silakan hubungi Admin/Developer untuk sinkronisasi data.
                </p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($ownerships as $asset)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="bg-purple-600 p-4 text-white flex justify-between items-center">
                            <div>
                                <p class="text-xs uppercase tracking-wider opacity-80">Unit Rumah</p>
                                <h3 class="text-2xl font-bold">Blok {{ $asset->unit->block }} -
                                    {{ $asset->unit->number }}</h3>
                            </div>
                            <div class="text-right">
                                <span class="bg-purple-700 px-2 py-1 rounded text-xs font-bold">
                                    Tipe {{ $asset->unit->type }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 space-y-4">

                            <div class="flex justify-between items-center pb-2 border-b">
                                <span class="text-sm text-gray-500">Status Huni</span>
                                <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                    {{ $asset->status }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <i class="fas fa-ruler-combined text-purple-500 mr-2"></i>
                                    LT: {{ $asset->unit->land_size }} m²
                                </div>
                                <div>
                                    <i class="fas fa-home text-purple-500 mr-2"></i>
                                    LB: {{ $asset->unit->building_size }} m²
                                </div>
                                <div>
                                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                                    {{ $asset->unit->electricity }} VA
                                </div>
                                <div>
                                    <i class="fas fa-tint text-blue-500 mr-2"></i>
                                    {{ $asset->unit->water_source }}
                                </div>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-md text-xs text-gray-600">
                                <strong>Detail:</strong> {{ $asset->unit->room_details }}
                            </div>

                            @php
                                $isExpired = \Carbon\Carbon::now()->greaterThan($asset->warranty_end_date);
                            @endphp
                            <div
                                class="mt-4 p-3 rounded-lg border {{ $isExpired ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200' }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span
                                        class="font-bold text-sm {{ $isExpired ? 'text-red-700' : 'text-blue-700' }}">
                                        <i class="fas fa-shield-alt mr-1"></i> Status Garansi
                                    </span>
                                    @if (!$isExpired)
                                        <span
                                            class="text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded">AKTIF</span>
                                    @else
                                        <span
                                            class="text-xs font-bold text-white bg-red-600 px-2 py-0.5 rounded">EXPIRED</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600">
                                    Berlaku s/d:
                                    <strong>{{ $asset->warranty_end_date->locale('id')->translatedFormat('d F Y') }}</strong>
                                </p>
                            </div>

                        </div>

                        <div class="bg-gray-50 p-4 border-t flex justify-between items-center">
                            <div class="text-xs text-gray-500">
                                Akad: {{ $asset->handover_date->locale('id')->translatedFormat('d F Y') }}
                            </div>
                            <a href="{{ route('complaints.create') }}"
                                class="text-sm bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                <i class="fas fa-tools mr-1"></i> Lapor Kerusakan
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
