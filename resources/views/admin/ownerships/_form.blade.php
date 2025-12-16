<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Pilih Unit Rumah</label>
            <select name="unit_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                {{ $ownership->exists ? 'disabled' : 'required' }}>
                <option value="">-- Pilih Unit --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('unit_id', $ownership->unit_id) == $unit->id ? 'selected' : '' }}>
                        Blok {{ $unit->block }} No. {{ $unit->number }} (Tipe {{ $unit->type }}) -
                        {{ $unit->status }}
                    </option>
                @endforeach
            </select>
            @if ($ownership->exists)
                <input type="hidden" name="unit_id" value="{{ $ownership->unit_id }}">
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Pilih Nasabah (Pemilik)</label>
            <select name="customer_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                {{ $ownership->exists ? 'disabled' : 'required' }}>
                <option value="">-- Pilih Nasabah --</option>
                @foreach ($customers as $cust)
                    <option value="{{ $cust->id }}"
                        {{ old('customer_id', $ownership->customer_id) == $cust->id ? 'selected' : '' }}>
                        {{ $cust->name }} (NIK: {{ $cust->nik }})
                    </option>
                @endforeach
            </select>
            @if ($ownership->exists)
                <input type="hidden" name="customer_id" value="{{ $ownership->customer_id }}">
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Metode Pembelian</label>
            <select name="purchase_method" id="purchase_method"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                <option value="CASH"
                    {{ old('purchase_method', $ownership->purchase_method) == 'CASH' ? 'selected' : '' }}>CASH
                    Keras/Bertahap</option>
                <option value="KREDIT"
                    {{ old('purchase_method', $ownership->purchase_method) == 'KREDIT' ? 'selected' : '' }}>KREDIT
                    (KPR)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Bank (Jika KPR)</label>
            <input type="text" name="bank_name" value="{{ old('bank_name', $ownership->bank_name) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                placeholder="Contoh: BTN Syariah">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Serah Terima Kunci (Akad)</label>
            <input type="date" name="handover_date"
                value="{{ old('handover_date', optional($ownership->handover_date)->format('Y-m-d')) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Status Penghuni</label>
            <select name="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                <option value="Active" {{ old('status', $ownership->status) == 'Active' ? 'selected' : '' }}>Active
                    (Dihuni/Disewakan)</option>
                <option value="Moved Out" {{ old('status', $ownership->status) == 'Moved Out' ? 'selected' : '' }}>
                    Moved Out (Pindah/Kosong)</option>
                <option value="Sold" {{ old('status', $ownership->status) == 'Sold' ? 'selected' : '' }}>Sold (Dijual
                    Kembali)</option>
            </select>
        </div>
    </div>

    @if ($ownership->exists)
        <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
            <p class="text-sm text-blue-800 font-semibold">
                <i class="fas fa-info-circle mr-1"></i> Informasi Garansi
            </p>
            <p class="text-sm text-blue-600 mt-1">
                Masa garansi berakhir pada:
                <strong>{{ $ownership->warranty_end_date->locale('id')->translatedFormat('d F Y') }}</strong>
            </p>
        </div>
    @endif

    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.ownerships.index') }}"
            class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
            Batal
        </a>
        <button type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="fas fa-save mr-2"></i> Simpan Transaksi
        </button>
    </div>
</div>
