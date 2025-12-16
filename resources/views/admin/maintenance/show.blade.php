<x-app-layout>
    <x-slot name="header">
        {{ __('Proses Laporan Keluhan') }}
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 text-gray-700">Detail Masalah</h3>

            <div class="mb-4 border-b pb-4">
                <p class="text-sm text-gray-500">Unit Rumah:</p>
                <p class="font-semibold text-lg">Blok {{ $order->ownership->unit->block }} - No.
                    {{ $order->ownership->unit->number }}</p>
                <p class="text-sm text-gray-600">Pemilik: {{ $order->ownership->customer->name }}
                    ({{ $order->ownership->customer->phone }})</p>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Keluhan:</p>
                <h4 class="font-bold">{{ $order->complaint_title }}</h4>
                <p class="text-gray-700 mt-2 bg-gray-50 p-3 rounded">{{ $order->complaint_description }}</p>
            </div>

            @if ($order->complaint_photo)
                <div>
                    <p class="text-sm text-gray-500 mb-2">Foto:</p>
                    <a href="{{ asset('storage/' . $order->complaint_photo) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->complaint_photo) }}"
                            class="h-40 rounded border hover:opacity-75">
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 text-gray-700">Tindak Lanjut Admin</h3>

            <form action="{{ route('admin.maintenance.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status Pengerjaan</label>
                    <select name="status" id="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu)
                        </option>
                        <option value="In_Progress" {{ $order->status == 'In_Progress' ? 'selected' : '' }}>In Progress
                            (Sedang Dikerjakan)</option>
                        <option value="Done" {{ $order->status == 'Done' ? 'selected' : '' }}>Done (Selesai)</option>
                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled
                            (Ditolak)</option>
                    </select>
                </div>

                <div class="mb-6" id="technician-wrapper">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tugaskan Teknisi</label>
                    <select name="technician_id"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">-- Pilih Teknisi Available --</option>
                        @foreach ($technicians as $tech)
                            <option value="{{ $tech->id }}"
                                {{ $order->technician_id == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }} - Spesialis {{ $tech->specialty }}
                            </option>
                        @endforeach
                    </select>
                    @if ($order->technician)
                        <p class="text-xs text-blue-600 mt-1">Saat ini: {{ $order->technician->name }}</p>
                    @endif
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 font-bold shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
