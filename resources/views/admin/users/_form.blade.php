<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Role User</label>
        {{-- Tambahkan ID 'role-select' --}}
        <select name="role" id="role-select"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="warga" {{ old('role', $user->role) == 'warga' ? 'selected' : '' }}>Warga (Penghuni)</option>
            <option value="nasabah" {{ old('role', $user->role) == 'nasabah' ? 'selected' : '' }}>Nasabah (Pemilik)
            </option>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Staff)</option>
        </select>
    </div>

    {{-- LOGIC: PILIH UNIT RUMAH (KHUSUS WARGA) --}}
    {{-- Tambahkan ID 'unit-wrapper' agar bisa di-hide via JS --}}
    <div class="mt-4" id="unit-wrapper" style="display: none;">
        <label class="block text-sm font-medium text-gray-700">Assign Unit Rumah (Khusus Warga/Penghuni)</label>
        <select name="ownership_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
            <option value="">-- Tidak Terikat Unit --</option>
            @foreach ($ownerships as $own)
                <option value="{{ $own->id }}" {{ $user->ownership_id == $own->id ? 'selected' : '' }}>
                    Blok {{ $own->unit->block }} No {{ $own->unit->number }} - (Pemilik: {{ $own->customer->name }})
                </option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Pilih unit ini jika user adalah anak/keluarga dari pemilik rumah.</p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Password {{ $user->exists ? '(Kosongkan jika tidak diganti)' : '' }}
            </label>
            <input type="password" name="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                {{ $user->exists ? '' : 'required' }}>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                {{ $user->exists ? '' : 'required' }}>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </div>
</div>

{{-- SCRIPT SEDERHANA UNTUK SHOW/HIDE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role-select');
        const unitWrapper = document.getElementById('unit-wrapper');

        function toggleUnitWrapper() {
            if (roleSelect.value === 'warga') {
                unitWrapper.style.display = 'block';
            } else {
                unitWrapper.style.display = 'none';
                // Opsional: Reset value select unit jika di-hide
                // unitWrapper.querySelector('select').value = ""; 
            }
        }

        // Jalankan saat pertama kali load (untuk edit mode)
        toggleUnitWrapper();

        // Jalankan setiap kali user ganti pilihan dropdown
        roleSelect.addEventListener('change', toggleUnitWrapper);
    });
</script>
