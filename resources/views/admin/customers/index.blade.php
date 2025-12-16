<x-app-layout>
    <x-slot name="header">
        {{ __('Data Biodata Nasabah') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <div class="flex justify-between mb-4">
            <h4 class="mb-4 text-lg font-semibold text-gray-600">
                Database Nasabah (KTP)
            </h4>
            <a href="{{ route('admin.customers.create') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="fas fa-plus mr-2"></i> Lengkapi Data Nasabah
            </a>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Nama (User / KTP)</th>
                            <th class="px-4 py-3">NIK</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Kontak</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($customers as $cust)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3">
                                    <div class="font-semibold">{{ $cust->name }}</div>
                                    <div class="text-xs text-gray-500">Akun: {{ $cust->user->email ?? 'Terhapus' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono">
                                    {{ $cust->nik }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ Str::limit($cust->address, 40) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $cust->phone }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('admin.customers.show', $cust->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Lihat Biodata">
                                            <i class="fas fa-eye fa-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $cust->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit Biodata">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>

                                        <form action="{{ route('admin.customers.destroy', $cust->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900"
                                                onclick="confirmDelete(this)" title="Hapus Biodata">
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
                {{ $customers->links() }}
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
                    title: 'Yakin hapus biodata ini?',
                    text: "Data KTP & Alamat akan hilang, tapi Akun Login tetap ada.",
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
