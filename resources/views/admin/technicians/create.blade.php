<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Data Tukang') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.technicians.store') }}" method="POST">
                @csrf
                @include('admin.technicians._form')
            </form>
        </div>
    </div>
</x-app-layout>
