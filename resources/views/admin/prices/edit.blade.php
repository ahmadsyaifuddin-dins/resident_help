<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Biaya Perbaikan') }}
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.prices.update', $price->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.prices._form')
        </form>
    </div>
</x-app-layout>
