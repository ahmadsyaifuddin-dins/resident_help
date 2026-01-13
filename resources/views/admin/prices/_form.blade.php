<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Jasa / Perbaikan</label>
        <input type="text" name="service_name" value="{{ old('service_name', $price->service_name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            placeholder="Contoh: Ganti Kran Air" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Biaya Standar (Rp)</label>
        {{-- Input Tampilan (Format Rupiah) --}}
        <input type="text" id="price_display"
            value="{{ old('price', $price->price ? number_format($price->price, 0, ',', '.') : '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            placeholder="Contoh: 50.000" required>

        {{-- Input Asli ke Database --}}
        <input type="hidden" name="price" id="price_actual" value="{{ old('price', $price->price) }}">
    </div>

    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.prices.index') }}"
            class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Batal
        </a>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 shadow-sm">
            Simpan
        </button>
    </div>
</div>

{{-- Script Auto Format Rupiah (Copy dari Unit tadi) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const displayInput = document.getElementById('price_display');
        const actualInput = document.getElementById('price_actual');

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

        displayInput.addEventListener('keyup', function(e) {
            displayInput.value = formatRupiah(this.value);
            actualInput.value = this.value.replace(/\./g, '');
        });
    });
</script>
