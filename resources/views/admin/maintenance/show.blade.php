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

                @if ($isWarrantyExpired)
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center mb-2 text-red-700 font-bold">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>Masa Garansi Unit Habis!</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">
                            Unit ini sudah melewati masa garansi. Silakan input biaya perbaikan yang harus dibayar
                            warga.
                        </p>

                        {{-- Tabel Referensi Harga (Biar Admin gak usah ngafalin harga) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Referensi Daftar Harga:</label>
                            <select class="w-full text-sm border-gray-300 rounded-md bg-gray-100"
                                onchange="document.getElementById('costInput').value = this.value">
                                <option value="0">-- Pilih dari List Harga (Opsional) --</option>
                                @foreach ($repairPrices as $price)
                                    <option value="{{ (int) $price->price }}">{{ $price->service_name }} - Rp
                                        {{ number_format($price->price) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Input Biaya Manual --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Tagihan (Rp)</label>
                            <input type="number" name="cost" id="costInput" value="{{ $order->cost }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 font-bold"
                                placeholder="0">
                            <p class="text-xs text-gray-500 mt-1">*Masukkan 0 jika digratiskan.</p>
                        </div>
                    </div>
                @else
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center text-green-700 font-bold">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Garansi Aktif</span>
                        </div>
                        <p class="text-sm text-gray-600">Perbaikan ini ditanggung developer (Gratis).</p>
                        <input type="hidden" name="cost" value="0">
                    </div>
                @endif

                <div class="flex justify-end">
                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 font-bold shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            {{-- KOTAK KONFIRMASI PEMBAYARAN (Hanya muncul jika ada tagihan & belum lunas) --}}
            @if ($order->cost > 0 && $order->payment_status == 'Unpaid')
                <div class="mt-6 border-t pt-6">
                    <h4 class="font-bold text-gray-700 mb-2">Status Pembayaran</h4>
                    <div class="bg-orange-50 border border-orange-200 p-4 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="text-orange-800 font-bold">BELUM DIBAYAR (Unpaid)</p>
                            <p class="text-sm text-gray-600">Total: Rp {{ number_format($order->cost, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Tombol Aksi --}}
                        {{-- Tambah ID form & Hapus onsubmit bawaan --}}
                        <form id="form-mark-paid" action="{{ route('admin.maintenance.paid', $order->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Ganti type="button" & tambah onclick --}}
                            <button type="button" onclick="confirmPayment()"
                                class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 font-bold text-sm">
                                <i class="fas fa-money-bill-wave mr-1"></i> Tandai Lunas
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($order->cost > 0 && $order->payment_status == 'Paid')
                {{-- JIKA SUDAH LUNAS (Bagian ini tetap sama) --}}
                <div class="mt-6 border-t pt-6">
                    <h4 class="font-bold text-gray-700 mb-2">Status Pembayaran</h4>
                    <div class="bg-green-50 border border-green-200 p-4 rounded-lg flex items-center">
                        <div class="p-2 bg-green-200 rounded-full text-green-700 mr-3">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="text-green-800 font-bold">LUNAS (Paid)</p>
                            <p class="text-sm text-gray-600">Terima kasih, pembayaran telah diverifikasi.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Tambahkan Script SweetAlert di bagian bawah --}}
    <script>
        function confirmPayment() {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: "Yakin ingin menandai tagihan ini sebagai LUNAS? Pastikan Anda sudah menerima pembayaran dari warga.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a', // Warna Hijau (sesuai tailwind green-600)
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tandai Lunas!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, submit form secara manual via JS
                    document.getElementById('form-mark-paid').submit();
                }
            })
        }
    </script>
</x-app-layout>
