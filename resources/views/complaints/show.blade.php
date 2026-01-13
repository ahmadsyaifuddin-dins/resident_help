<x-app-layout>
    <x-slot name="header">
        {{ __('Detail Laporan') }}
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">{{ $order->complaint_title }}</h2>

            <div class="mb-4">
                <span class="text-gray-500 text-sm">Status:</span>
                @if ($order->status == 'Pending')
                    <span class="px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Menunggu
                        Respon Admin</span>
                @elseif($order->status == 'In_Progress')
                    <span class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Sedang
                        Dikerjakan Teknisi</span>
                @elseif($order->status == 'Done')
                    <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Perbaikan
                        Selesai</span>
                @endif
            </div>

            {{-- TAMPILKAN TAGIHAN JIKA ADA --}}
            @if ($order->cost > 0)
                <div class="mt-4 p-4 bg-white border-l-4 border-orange-500 shadow-sm rounded">
                    <h4 class="font-bold text-orange-600 text-lg">Tagihan Perbaikan</h4>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-gray-600">Total Biaya:</span>
                        <span class="text-2xl font-bold text-gray-800">Rp
                            {{ number_format($order->cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 text-sm">
                        Status:
                        @if ($order->payment_status == 'Paid')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full font-bold">LUNAS</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full font-bold">BELUM DIBAYAR</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-2">*Silakan lakukan pembayaran ke Admin Developer.</p>
                </div>
            @endif

            <p class="text-gray-700 mb-6">{{ $order->complaint_description }}</p>

            @if ($order->complaint_photo)
                <div class="mb-4">
                    <p class="text-sm font-semibold mb-2">Foto Bukti:</p>
                    <img src="{{ asset('storage/' . $order->complaint_photo) }}"
                        class="w-full max-w-md rounded-lg border">
                </div>
            @endif
        </div>

        <div class="space-y-6">
            @if ($order->technician)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg mb-2">Teknisi Bertugas</h3>
                    <div class="flex items-center space-x-3">
                        <div class="bg-gray-200 p-3 rounded-full">
                            <i class="fa-solid fa-helmet-safety text-gray-600 fa-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $order->technician->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->technician->specialty }}</p>
                            <p class="text-sm text-blue-600"><i class="fab fa-whatsapp"></i>
                                {{ $order->technician->phone }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($order->status == 'Done' && $order->rating == null)
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-400">
                    <h3 class="font-bold text-lg mb-2">Beri Penilaian</h3>
                    <p class="text-sm text-gray-600 mb-4">Bagaimana hasil kerja teknisi kami?</p>

                    <form action="{{ route('complaints.rate', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex space-x-2 mb-4">
                            <select name="rating" class="w-full border-gray-300 rounded-md">
                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                <option value="2">⭐⭐ (Kurang)</option>
                                <option value="1">⭐ (Kecewa)</option>
                            </select>
                        </div>

                        <textarea name="review" rows="2" class="w-full border-gray-300 rounded-md text-sm mb-2"
                            placeholder="Tulis ulasan..."></textarea>

                        <button type="submit"
                            class="w-full bg-yellow-500 text-white py-2 rounded-md hover:bg-yellow-600 font-semibold">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            @elseif($order->rating)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-lg mb-2">Ulasan Anda</h3>
                    <div class="text-yellow-500 mb-1">
                        @for ($i = 0; $i < $order->rating; $i++)
                            ⭐
                        @endfor
                    </div>
                    <p class="text-gray-600 italic">"{{ $order->review }}"</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
