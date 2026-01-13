<x-app-layout>
    <x-slot name="header">
        {{ __('Master Biaya Perbaikan (Non-Garansi)') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <div class="flex justify-between mb-4">
            <h4 class="mb-4 text-lg font-semibold text-gray-600">
                Daftar Harga Jasa
            </h4>
            <a href="{{ route('admin.prices.create') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                + Tambah Harga
            </a>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Nama Jasa / Perbaikan</th>
                            <th class="px-4 py-3">Biaya Standar</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($prices as $item)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 font-semibold">{{ $item->service_name }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.prices.edit', $item->id) }}"
                                            class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.prices.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t">
                {{ $prices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
