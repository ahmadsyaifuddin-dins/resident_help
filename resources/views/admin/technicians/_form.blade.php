<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $technician->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            placeholder="Contoh: Mang Udin" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nomor HP / WhatsApp</label>
        <input type="number" name="phone" value="{{ old('phone', $technician->phone) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            placeholder="08xxxxx" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Spesialisasi Keahlian</label>
        <select name="specialty"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            @php
                $specialties = ['Listrik', 'Air/Pipa', 'Bangunan/Semen', 'Atap', 'Kayu', 'Keramik', 'Lainnya'];
            @endphp
            @foreach ($specialties as $spec)
                <option value="{{ $spec }}"
                    {{ old('specialty', $technician->specialty) == $spec ? 'selected' : '' }}>
                    {{ $spec }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Status Saat Ini</label>
        <select name="status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            <option value="Available" {{ old('status', $technician->status) == 'Available' ? 'selected' : '' }}>
                Available (Siap Kerja)</option>
            <option value="Busy" {{ old('status', $technician->status) == 'Busy' ? 'selected' : '' }}>Busy (Sedang
                Mengerjakan)</option>
        </select>
    </div>

    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.technicians.index') }}"
            class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
            Batal
        </a>
        <button type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </div>
</div>
