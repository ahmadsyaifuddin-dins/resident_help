<x-app-layout>
    <x-slot name="header">
        {{ __('Riwayat Keluhan Saya') }}
    </x-slot>

    <div class="bg-white rounded-lg shadow-xs p-4">
        <div class="mb-4 text-right">
            <a href="{{ route('complaints.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                + Lapor Kerusakan Baru
            </a>
        </div>

        <div class="w-full overflow-hidden rounded-lg border">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Unit & Keluhan</th>
                            <th class="px-4 py-3">Status Laporan</th>
                            <th class="px-4 py-3">Biaya</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($orders as $order)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $order->complaint_date->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="font-semibold">Blok
                                        {{ $order->ownership->unit->block }}-{{ $order->ownership->unit->number }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->complaint_title }}</div>
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if ($order->status == 'Pending')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Menunggu</span>
                                    @elseif($order->status == 'In_Progress')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full">Diproses</span>
                                    @elseif($order->status == 'Done')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Selesai</span>
                                    @endif
                                </td>

                                {{-- ISI KOLOM BIAYA --}}
                                <td class="px-4 py-3 text-xs">
                                    @if ($order->cost == 0)
                                        <span class="font-bold text-gray-500">-</span>
                                    @else
                                        <div class="font-bold">Rp {{ number_format($order->cost, 0, ',', '.') }}</div>
                                        @if ($order->payment_status == 'Unpaid')
                                            <span class="text-red-600 font-bold animate-pulse">BELUM BAYAR</span>
                                        @else
                                            <span class="text-green-600 font-bold">LUNAS</span>
                                        @endif
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ route('complaints.show', $order->id) }}"
                                        class="text-indigo-600 hover:underline mr-2 text-sm">Detail</a>
                                    <a href="{{ route('complaints.print', $order->id) }}" target="_blank"
                                        class="text-gray-600 hover:text-gray-900" title="Cetak Tiket">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire('Berhasil', '{{ session('success') }}', 'success');
            @endif
        });
    </script>
</x-app-layout>
