<x-app-layout>
    <x-slot name="header">
        {{ __('Data Unit Rumah') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <div class="flex justify-between mb-4">
            <h4 class="mb-4 text-lg font-semibold text-gray-600">
                List Unit Rumah & Kavling
            </h4>
            <a href="{{ route('admin.units.create') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="fas fa-plus mr-2"></i> Tambah Unit
            </a>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Blok / No</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Spek (T/B)</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($units as $unit)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3">
                                    <div class="font-semibold">Blok {{ $unit->block }}</div>
                                    <div class="text-sm text-gray-500">No. {{ $unit->number }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    Tipe {{ $unit->type }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div>LT: {{ $unit->land_size }} m²</div>
                                    <div>LB: {{ $unit->building_size }} m²</div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    Rp {{ number_format($unit->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($unit->status == 'Tersedia')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Tersedia
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Terjual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('admin.units.edit', $unit->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>

                                        <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900"
                                                onclick="confirmDelete(this)" title="Hapus">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t bg-gray-50">
                {{ $units->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 1500,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                });
            @endif

            window.confirmDelete = function(button) {
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: "Data unit akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                })
            }
        });
    </script>
</x-app-layout>
