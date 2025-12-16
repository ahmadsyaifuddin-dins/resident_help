<x-app-layout>
    <x-slot name="header">
        {{ __('Pusat Laporan & Cetak') }}
    </x-slot>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">

        <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-purple-500">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-purple-100 rounded-full text-purple-500 mr-4">
                    <i class="fas fa-file-alt fa-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700">1. Rekapitulasi Keluhan</h4>
                    <p class="text-xs text-gray-500">Daftar semua laporan masuk</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.complaints.pdf') }}" target="_blank"
                    class="block w-full bg-red-600 text-white text-center py-2 rounded text-sm hover:bg-red-700">
                    <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-yellow-500">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-yellow-100 rounded-full text-yellow-500 mr-4">
                    <i class="fas fa-chart-pie fa-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700">2. Analisis Kategori</h4>
                    <p class="text-xs text-gray-500">Statistik jenis kerusakan</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.category.pdf') }}" target="_blank"
                    class="block w-full bg-red-600 text-white text-center py-2 rounded text-sm hover:bg-red-700">
                    <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-indigo-500">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-indigo-100 rounded-full text-indigo-500 mr-4">
                    <i class="fas fa-stopwatch fa-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700">3. Kecepatan Respon (SLA)</h4>
                    <p class="text-xs text-gray-500">Analisis durasi perbaikan</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.sla.pdf') }}" target="_blank"
                    class="block w-full bg-red-600 text-white text-center py-2 rounded text-sm hover:bg-red-700">
                    <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 rounded-full text-blue-500 mr-4">
                    <i class="fas fa-users-cog fa-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700">4. Kinerja Teknisi</h4>
                    <p class="text-xs text-gray-500">Data mitra & total pekerjaan</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.technicians.pdf') }}" target="_blank"
                    class="block w-full bg-red-600 text-white text-center py-2 rounded text-sm hover:bg-red-700">
                    <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-orange-500">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-orange-100 rounded-full text-orange-500 mr-4">
                    <i class="fas fa-star fa-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700">5. Indeks Kepuasan</h4>
                    <p class="text-xs text-gray-500">Rating & Testimoni Warga</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.ratings.pdf') }}" target="_blank"
                    class="block w-full bg-red-600 text-white text-center py-2 rounded text-sm hover:bg-red-700">
                    <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                </a>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-green-500">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-green-100 rounded-full text-green-500 mr-4">
                    <i class="fas fa-address-book fa-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700">Database Nasabah</h4>
                    <p class="text-xs text-gray-500">Export data lengkap ke Excel</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.customers.excel') }}"
                    class="block w-full bg-green-600 text-white text-center py-2 rounded text-sm hover:bg-green-700">
                    <i class="fas fa-file-excel mr-1"></i> Download Excel
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
