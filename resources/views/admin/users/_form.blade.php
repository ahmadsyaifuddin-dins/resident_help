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
        <select name="role"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="warga" {{ old('role', $user->role) == 'warga' ? 'selected' : '' }}>Warga (Penghuni)</option>
            <option value="nasabah" {{ old('role', $user->role) == 'nasabah' ? 'selected' : '' }}>Nasabah (Pemilik)
            </option>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Staff)</option>
        </select>
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
