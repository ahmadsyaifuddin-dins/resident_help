<x-app-layout>
    <x-slot name="header">
        {{ __('Data Mitra Teknisi (Tukang)') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <div class="flex justify-between mb-4">
            <h4 class="mb-4 text-lg font-semibold text-gray-600">
                List Database Tukang
            </h4>
            <a href="{{ route('admin.technicians.create') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="fas fa-plus mr-2"></i> Tambah Tukang
            </a>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Nama Tukang</th>
                            <th class="px-4 py-3">No HP / WA</th>
                            <th class="px-4 py-3">Spesialisasi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($technicians as $tech)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 font-semibold">{{ $tech->name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $tech->phone }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">
                                        {{ $tech->specialty }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($tech->status == 'Available')
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Available
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Busy
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('admin.technicians.show', $tech->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Lihat Data">
                                            <i class="fas fa-eye fa-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.technicians.edit', $tech->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>

                                        <form action="{{ route('admin.technicians.destroy', $tech->id) }}"
                                            method="POST" class="inline-block">
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
                {{ $technicians->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Alert Success (Popup)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 1500,
                    showConfirmButton: false
                });
            @endif

            // 2. Alert Error (Popup - Jaga-jaga kalau ada error)
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                });
            @endif

            // 3. Fungsi Delete Global
            window.confirmDelete = function(button) {
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: "Data tukang akan dihapus permanen!",
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
