<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceOrder;
use App\Models\Technician;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // JIKA ADMIN: Tampilkan Statistik Global
        if ($user->role === 'admin') {
            // 1. Data Kartu Atas
            $totalUnits = Unit::count();
            $soldUnits = Unit::where('status', 'Terjual')->count();
            $availableUnits = Unit::where('status', 'Tersedia')->count();

            $technicians = Technician::count();
            $techAvailable = Technician::where('status', 'Available')->count();

            $pendingComplaints = MaintenanceOrder::where('status', 'Pending')->count();
            $processComplaints = MaintenanceOrder::where('status', 'In_Progress')->count();

            // 2. Data Chart 1: Unit Status (Pie Chart)
            // Kita sudah punya $soldUnits dan $availableUnits

            // 3. Data Chart 2: Keluhan per Bulan (Bar Chart) - 6 Bulan Terakhir
            $complaintsPerMonth = MaintenanceOrder::select(
                DB::raw('count(id) as total'),
                DB::raw("DATE_FORMAT(complaint_date, '%M') as month_name"),
                DB::raw('MONTH(complaint_date) as month')
            )
                ->whereYear('complaint_date', date('Y'))
                ->groupBy('month_name', 'month')
                ->orderBy('month')
                ->limit(6)
                ->pluck('total', 'month_name'); // Hasil: ['January' => 5, 'February' => 2]

            return view('dashboard', compact(
                'totalUnits', 'soldUnits', 'availableUnits',
                'technicians', 'techAvailable',
                'pendingComplaints', 'processComplaints',
                'complaintsPerMonth'
            ));
        }

        // JIKA WARGA/NASABAH: Tampilkan Statistik Pribadi
        else {
            $myComplaintsTotal = MaintenanceOrder::where('reporter_id', $user->id)->count();
            $myComplaintsPending = MaintenanceOrder::where('reporter_id', $user->id)->where('status', 'Pending')->count();
            $myComplaintsDone = MaintenanceOrder::where('reporter_id', $user->id)->where('status', 'Done')->count();

            return view('dashboard', compact('myComplaintsTotal', 'myComplaintsPending', 'myComplaintsDone'));
        }
    }
}
