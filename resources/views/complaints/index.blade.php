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
                            <th class="px-4 py-3">Keluhan</th>
                            <th class="px-4 py-3">Teknisi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($orders as $order)
                            <tr class="text-gray-700 text-sm">
                                <td class="px-4 py-3">{{ $order->complaint_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold">{{ $order->complaint_title }}</div>
                                    <div class="text-xs text-gray-500 truncate w-48">{{ $order->complaint_description }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($order->technician)
                                        {{ $order->technician->name }} <br>
                                        <span class="text-xs text-gray-500">({{ $order->technician->specialty }})</span>
                                    @else
                                        <span class="text-gray-400 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($order->status == 'Pending')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                                    @elseif($order->status == 'In_Progress')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Diproses</span>
                                    @elseif($order->status == 'Done')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Selesai</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Batal</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('complaints.show', $order->id) }}"
                                        class="text-indigo-600 hover:underline">Detail</a>
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
