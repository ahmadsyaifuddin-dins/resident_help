<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Models\MaintenanceOrder;
use App\Models\Technician;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini buat query statistik
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    // 1. REKAPITULASI KELUHAN
    public function complaintsPdf(Request $request)
    {
        $orders = MaintenanceOrder::with(['ownership.unit', 'technician'])
            ->orderBy('complaint_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.complaints', compact('orders'));

        return $pdf->stream('Laporan-Keluhan-Warga.pdf');
    }

    // 2. KINERJA TEKNISI
    public function techniciansPdf()
    {
        $technicians = Technician::withCount(['maintenanceOrders as total_jobs' => function ($query) {
            $query->where('status', 'Done');
        }])->get();

        $pdf = Pdf::loadView('admin.reports.pdf.technicians', compact('technicians'));

        return $pdf->stream('Laporan-Data-Teknisi.pdf');
    }

    // 3. ANALISIS KATEGORI KERUSAKAN (STATISTIK)
    public function categoryStatsPdf()
    {
        // Hitung jumlah kasus berdasarkan Spesialisasi Teknisi
        // Contoh: Listrik (5), Air (2), dll.
        $stats = MaintenanceOrder::join('technicians', 'maintenance_orders.technician_id', '=', 'technicians.id')
            ->select('technicians.specialty', DB::raw('count(*) as total'))
            ->groupBy('technicians.specialty')
            ->get();

        $totalCases = $stats->sum('total');

        $pdf = Pdf::loadView('admin.reports.pdf.category_stats', compact('stats', 'totalCases'));

        return $pdf->stream('Laporan-Statistik-Kerusakan.pdf');
    }

    // 4. KINERJA KECEPATAN RESPON (SLA)
    public function slaPdf()
    {
        // Ambil data yang sudah selesai (Done)
        $orders = MaintenanceOrder::with(['ownership.customer', 'technician'])
            ->where('status', 'Done')
            ->orderBy('complaint_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.sla', compact('orders'));

        return $pdf->stream('Laporan-SLA-Respon.pdf');
    }

    // 5. INDEKS KEPUASAN PELANGGAN (FEEDBACK)
    public function ratingsPdf()
    {
        // Ambil data yang sudah ada ratingnya
        $reviews = MaintenanceOrder::with(['ownership.customer', 'ownership.unit'])
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc') // Rating tertinggi diatas
            ->get();

        // Hitung rata-rata rating
        $averageRating = $reviews->avg('rating');

        $pdf = Pdf::loadView('admin.reports.pdf.ratings', compact('reviews', 'averageRating'));

        return $pdf->stream('Laporan-Kepuasan-Pelanggan.pdf');
    }

    // EXPORT EXCEL NASABAH
    public function customersExcel()
    {
        return Excel::download(new CustomersExport, 'Database-Nasabah-Sekumpul.xlsx');
    }
}
