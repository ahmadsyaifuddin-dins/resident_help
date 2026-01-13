<x-app-layout>
    <x-slot name="header">
        {{ __('Laporan Keluhan Masuk') }}
    </x-slot>

    <div class="bg-white rounded-lg shadow-xs p-4">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Tanggal & Unit</th>
                            <th class="px-4 py-3">Keluhan</th>
                            <th class="px-4 py-3">Teknisi</th>
                            <th class="px-4 py-3">Status Pengerjaan</th>
                            <th class="px-4 py-3">Tagihan</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($orders as $order)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">
                                                Blok
                                                {{ $order->ownership->unit->block }}-{{ $order->ownership->unit->number }}
                                            </p>
                                            <p class="text-xs text-gray-600">
                                                {{ $order->complaint_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="font-bold block">{{ Str::limit($order->complaint_title, 20) }}</span>
                                    <span class="text-xs text-gray-500">{{ $order->ownership->customer->name }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $order->technician->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if ($order->status == 'Pending')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Pending
                                        </span>
                                    @elseif($order->status == 'In_Progress')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full">
                                            Proses
                                        </span>
                                    @elseif($order->status == 'Done')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Selesai
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </td>

                                {{-- ISI KOLOM BARU (TAGIHAN) --}}
                                <td class="px-4 py-3 text-xs">
                                    @if ($order->payment_status == 'Free')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">
                                            Gratis (Garansi)
                                        </span>
                                    @elseif($order->payment_status == 'Paid')
                                        <div class="font-bold text-green-600">Rp
                                            {{ number_format($order->cost, 0, ',', '.') }}</div>
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-semibold text-green-700 bg-green-100 rounded-full">
                                            LUNAS
                                        </span>
                                    @else
                                        <div class="font-bold text-red-600">Rp
                                            {{ number_format($order->cost, 0, ',', '.') }}</div>
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-semibold text-red-700 bg-red-100 rounded-full">
                                            BELUM BAYAR
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="{{ route('admin.maintenance.show', $order->id) }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t">
                {{ $orders->links() }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    Swal.fire('Berhasil', '{{ session('success') }}', 'success');
                @endif
            });
        </script>
</x-app-layout>
