<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Biodata Nasabah') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.customers._form')
            </form>
        </div>
    </div>
</x-app-layout>
