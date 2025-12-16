<x-app-layout>
    <x-slot name="header">
        {{ __('Input Data Kepemilikan & Garansi') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.ownerships.store') }}" method="POST">
                @csrf
                @include('admin.ownerships._form')
            </form>
        </div>
    </div>
</x-app-layout>
