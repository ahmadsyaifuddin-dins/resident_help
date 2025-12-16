<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Keluhan Masuk') }}
    </x-slot>

    <div class="bg-white rounded-lg shadow-xs p-4">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">
                            <th class="px-4 py-3">Tgl</th>
                            <th class="px-4 py-3">Unit / Pelapor</th>
                            <th class="px-4 py-3">Keluhan</th>
                            <th class="px-4 py-3">Teknisi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($orders as $order)
                            <tr class="text-gray-700 text-sm">
                                <td class="px-4 py-3">{{ $order->complaint_date->format('d/m/y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold">
                                        {{ $order->ownership->unit->block }}-{{ $order->ownership->unit->number }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->ownership->customer->name }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-700">{{ $order->complaint_title }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $order->technician->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($order->status == 'Pending')
                                        <span
                                            class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full animate-pulse">BARU</span>
                                    @elseif($order->status == 'In_Progress')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Proses</span>
                                    @elseif($order->status == 'Done')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.maintenance.show', $order->id) }}"
                                        class="bg-purple-600 text-white px-3 py-1 rounded text-xs hover:bg-purple-700">
                                        Proses
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
