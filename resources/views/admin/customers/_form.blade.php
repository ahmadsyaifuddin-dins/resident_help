<div class="space-y-4">

    @if (!$customer->exists)
        <div>
            <label class="block text-sm font-medium text-gray-700">Pilih Akun Nasabah</label>
            <select name="user_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">*Hanya menampilkan user role 'Nasabah' yang belum punya biodata.</p>
        </div>
    @else
        <div>
            <label class="block text-sm font-medium text-gray-700">Akun Terkait</label>
            <input type="text" value="{{ $customer->user->name ?? 'User Terhapus' }}" disabled
                class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 text-gray-500 sm:text-sm">
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap (Sesuai KTP)</label>
        <input type="text" name="name" value="{{ old('name', $customer->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan)</label>
            <input type="number" name="nik" value="{{ old('nik', $customer->nik) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                placeholder="16 Digit Angka" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nomor HP / WA</label>
            <input type="number" name="phone" value="{{ old('phone', $customer->phone) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                required>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap (Sesuai KTP)</label>
        <textarea name="address" rows="2"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            required>{{ old('address', $customer->address) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Alamat Domisili Saat Ini (Jika beda dengan KTP)</label>
        <textarea name="domicile_address" rows="2"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
            placeholder="Kosongkan jika sama dengan KTP">{{ old('domicile_address', $customer->domicile_address) }}</textarea>
    </div>

    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.customers.index') }}"
            class="mr-2 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
            Batal
        </a>
        <button type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="fas fa-save mr-2"></i> Simpan Biodata
        </button>
    </div>
</div>
