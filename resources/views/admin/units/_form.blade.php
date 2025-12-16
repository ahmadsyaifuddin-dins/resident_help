<div class="space-y-4">
    @if ($errors->any())
        <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Blok</label>
            <input type="text" name="block" value="{{ old('block', $unit->block) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                placeholder="A" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nomor Unit</label>
            <input type="text" name="number" value="{{ old('number', $unit->number) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                placeholder="10" required>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipe Rumah</label>
            <select name="type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @foreach (['36', '45', '54', '60', '70', '100'] as $t)
                    <option value="{{ $t }}" {{ old('type', $unit->type) == $t ? 'selected' : '' }}>Tipe
                        {{ $t }}</option>
                @endforeach
            </select>
        </div>

        {{-- MODIFIKASI INPUT HARGA (AUTO FORMAT) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>

            <input type="text" id="price_display"
                value="{{ old('price', $unit->price ? number_format($unit->price, 0, ',', '.') : '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                placeholder="Contoh: 350.000.000">

            <input type="hidden" name="price" id="price_actual" value="{{ old('price', $unit->price) }}">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Luas Tanah (m²)</label>
            <input type="number" name="land_size" value="{{ old('land_size', $unit->land_size) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Luas Bangunan (m²)</label>
            <input type="number" name="building_size" value="{{ old('building_size', $unit->building_size) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                required>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Daya Listrik (VA)</label>
            <select name="electricity"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @foreach (['900', '1300', '2200', '3500'] as $e)
                    <option value="{{ $e }}"
                        {{ old('electricity', $unit->electricity) == $e ? 'selected' : '' }}>{{ $e }} VA
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Sumber Air</label>
            <select name="water_source"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                <option value="PDAM" {{ old('water_source', $unit->water_source) == 'PDAM' ? 'selected' : '' }}>PDAM
                </option>
                <option value="Sumur Bor"
                    {{ old('water_source', $unit->water_source) == 'Sumur Bor' ? 'selected' : '' }}>Sumur Bor</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Spesifikasi Ruangan</label>
        <textarea name="room_details" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            placeholder="Contoh: 2 Kamar Tidur, 1 Kamar Mandi, Dapur, Carport">{{ old('room_details', $unit->room_details) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Status Unit</label>
        <select name="status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            <option value="Tersedia" {{ old('status', $unit->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia (Belum
                Terjual)</option>
            <option value="Terjual" {{ old('status', $unit->status) == 'Terjual' ? 'selected' : '' }}>Terjual (Sudah
                Ada Pemilik)</option>
        </select>
    </div>

    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.units.index') }}"
            class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
            Batal
        </a>
        <button type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </div>
</div>

{{-- SCRIPT FORMAT RUPIAH --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const displayInput = document.getElementById('price_display');
        const actualInput = document.getElementById('price_actual');

        // Fungsi Format Angka ke Rupiah (Titik-titik)
        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        // Event Listener saat mengetik
        displayInput.addEventListener('keyup', function(e) {
            // Tampilkan format rupiah di layar
            displayInput.value = formatRupiah(this.value);

            // Simpan angka murni (tanpa titik) ke input hidden buat dikirim ke DB
            // Contoh: 10.000.000 -> 10000000
            actualInput.value = this.value.replace(/\./g, '');
        });
    });
</script>
