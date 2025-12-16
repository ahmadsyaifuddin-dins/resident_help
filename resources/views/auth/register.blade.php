<x-guest-layout>
    <div class="flex flex-col items-center mb-8 border-b pb-6">
        <a href="/" class="flex justify-center items-center mb-3">
            <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500">Bergabunglah bersama Resident Help</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="col-span-1 md:col-span-2">
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus placeholder="Nama sesuai KTP" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required placeholder="email@contoh.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('No. HP / WhatsApp')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')"
                    required placeholder="08xxxxxxxx" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="col-span-1 md:col-span-2">
                <x-input-label for="role" :value="__('Daftar Sebagai')" />
                <select id="role" name="role"
                    class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                    <option value="warga">Warga (Penghuni / Anak / Istri)</option>
                    <option value="nasabah">Nasabah (Pemilik Rumah)</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col items-center mt-8 space-y-4 border-t pt-6">
            <x-primary-button
                class="w-full justify-center py-3 bg-purple-600 hover:bg-purple-700 text-lg shadow-md transition transform hover:-translate-y-0.5">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>

            <div class="text-sm text-gray-600">
                Sudah punya akun?
                <a class="underline text-purple-600 hover:text-purple-900 font-semibold" href="{{ route('login') }}">
                    Masuk disini
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
