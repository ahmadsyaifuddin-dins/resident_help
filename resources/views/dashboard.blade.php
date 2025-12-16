<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    @if (Auth::user()->role === 'admin')
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                    <i class="fas fa-home fa-lg"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Unit Terjual</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $soldUnits }} / {{ $totalUnits }}</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Keluhan Baru</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $pendingComplaints }}</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                    <i class="fas fa-tools fa-lg"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Sedang Proses</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $processComplaints }}</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
                <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                    <i class="fas fa-users-cog fa-lg"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600">Tukang Ready</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $techAvailable }} / {{ $technicians }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
                <h4 class="mb-4 font-semibold text-gray-800">Status Penjualan Unit</h4>
                <canvas id="pieChart"></canvas>
            </div>

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
                <h4 class="mb-4 font-semibold text-gray-800">Tren Keluhan Warga (Bulan Ini)</h4>
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 1. Konfigurasi Pie Chart (Unit)
                const pieCtx = document.getElementById('pieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Terjual', 'Tersedia'],
                        datasets: [{
                            data: [{{ $soldUnits }}, {{ $availableUnits }}],
                            backgroundColor: ['#10B981', '#E5E7EB'], // Green & Gray
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

                // 2. Konfigurasi Bar Chart (Keluhan)
                const barCtx = document.getElementById('barChart').getContext('2d');
                const complaintsData = @json($complaintsPerMonth); // Convert PHP array to JS

                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(complaintsData), // Nama Bulan
                        datasets: [{
                            label: 'Jumlah Laporan',
                            data: Object.values(complaintsData), // Jumlah
                            backgroundColor: '#7E3AF2', // Purple
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @else
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-600 mb-6">Berikut adalah ringkasan aktivitas akun Anda di Resident Help.</p>

            <div class="grid gap-6 mb-8 md:grid-cols-3">
                <div class="p-4 bg-purple-100 rounded-lg text-purple-700">
                    <div class="text-3xl font-bold">{{ $myComplaintsTotal }}</div>
                    <div class="text-sm">Total Laporan Saya</div>
                </div>
                <div class="p-4 bg-yellow-100 rounded-lg text-yellow-700">
                    <div class="text-3xl font-bold">{{ $myComplaintsPending }}</div>
                    <div class="text-sm">Menunggu Respon</div>
                </div>
                <div class="p-4 bg-green-100 rounded-lg text-green-700">
                    <div class="text-3xl font-bold">{{ $myComplaintsDone }}</div>
                    <div class="text-sm">Selesai Diperbaiki</div>
                </div>
            </div>

            <div class="border-t pt-4">
                <h3 class="font-semibold mb-3">Aksi Cepat:</h3>
                <a href="{{ route('complaints.create') }}"
                    class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 shadow transition">
                    <i class="fas fa-plus-circle mr-2"></i> Buat Laporan Baru
                </a>
            </div>
        </div>
    @endif
</x-app-layout>
