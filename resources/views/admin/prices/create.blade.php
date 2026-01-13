<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Biaya Perbaikan') }}
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.prices.store') }}" method="POST">
            @csrf
            @include('admin.prices._form')
        </form>
    </div>
</x-app-layout>
