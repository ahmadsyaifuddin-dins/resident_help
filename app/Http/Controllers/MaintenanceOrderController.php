<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceOrder;
use App\Models\Ownership;
use App\Models\RepairPrice;
use App\Models\Technician;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceOrderController extends Controller
{
    // --- FITUR ADMIN ---

    public function indexAdmin()
    {
        // Admin lihat semua keluhan (Urut yang terbaru & status pending duluan)
        $orders = MaintenanceOrder::with(['ownership.unit', 'ownership.customer', 'technician'])
            ->orderByRaw("FIELD(status, 'Pending', 'In_Progress', 'Done', 'Cancelled')")
            ->latest()
            ->paginate(10);

        return view('admin.maintenance.index', compact('orders'));
    }

    public function showAdmin($id)
    {
        $order = MaintenanceOrder::with(['ownership.unit', 'ownership.customer', 'technician', 'reporter'])->findOrFail($id);
        $technicians = Technician::where('status', 'Available')->get();

        // Ambil list harga buat referensi admin
        $repairPrices = RepairPrice::all();

        // Cek Status Garansi (Logic yang sama kayak di view)
        $isWarrantyExpired = Carbon::now()->greaterThan($order->ownership->warranty_end_date);

        return view('admin.maintenance.show', compact('order', 'technicians', 'repairPrices', 'isWarrantyExpired'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = MaintenanceOrder::findOrFail($id);

        // 1. SANITASI INPUT BIAYA (Ubah ke Integer murni)
        // Ini memastikan input kosong jadi 0, dan input angka jadi integer
        $costInput = $request->input('cost');
        $cleanCost = (int) $costInput;

        // 2. VALIDASI
        $request->validate([
            'status' => 'required',
        ]);

        // 3. UPDATE STATUS & DATA LAIN
        $order->status = $request->status;

        // Logic Teknisi (Busy/Available)
        if ($request->status == 'In_Progress' && $request->technician_id) {
            $order->technician_id = $request->technician_id;
            Technician::where('id', $request->technician_id)->update(['status' => 'Busy']);
        }

        if ($request->status == 'Done') {
            $order->completion_date = now();
            if ($order->technician_id) {
                Technician::where('id', $order->technician_id)->update(['status' => 'Available']);
            }
        }
        // Logic Biaya dipindah KELUAR dari if(Done).
        // Jadi mau statusnya 'Pending', 'In_Progress', atau 'Done', biaya tetap tersimpan.

        if ($cleanCost > 0) {
            $order->cost = $cleanCost;

            // Set Unpaid hanya jika belum lunas
            if ($order->payment_status != 'Paid') {
                $order->payment_status = 'Unpaid';
            }
        } else {
            // Jika admin input 0 atau kosong
            $order->cost = 0;

            // Kembalikan ke Free jika belum lunas
            if ($order->payment_status != 'Paid') {
                $order->payment_status = 'Free';
            }
        }

        $order->save();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Status & Biaya berhasil diperbarui.');
    }
    // --- FITUR WARGA / USER ---

    public function indexUser()
    {
        // User cuma lihat keluhan dia sendiri
        $orders = MaintenanceOrder::with(['ownership.unit', 'technician'])
            ->where('reporter_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('complaints.index', compact('orders'));
    }

    public function create()
    {
        $user = Auth::user();
        $myHomes = collect([]); // Default kosong

        // SKENARIO 1: ROLE NASABAH (Cek via tabel Customers & Ownerships)
        if ($user->role === 'nasabah') {
            $customer = Customer::where('user_id', $user->id)->first();
            if ($customer) {
                $myHomes = Ownership::where('customer_id', $customer->id)
                    ->where('status', 'Active')
                    ->with('unit')
                    ->get();
            }
        }

        // SKENARIO 2: ROLE WARGA (Cek via kolom ownership_id di tabel Users)
        elseif ($user->role === 'warga') {
            if ($user->ownership_id) {
                // Ambil data ownership berdasarkan ID yang ditempel di user
                $myHomes = Ownership::where('id', $user->ownership_id)
                    ->where('status', 'Active')
                    ->with('unit')
                    ->get();
            }
        }

        // Jika Admin iseng buka, biarkan kosong atau tampilkan semua (opsional)

        return view('complaints.create', compact('myHomes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ownership_id' => 'required|exists:ownerships,id',
            'complaint_title' => 'required|string|max:255',
            'complaint_description' => 'required|string',
            'complaint_photo' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $photoPath = null;
        if ($request->hasFile('complaint_photo')) {
            $photoPath = $request->file('complaint_photo')->store('complaints', 'public');
        }

        MaintenanceOrder::create([
            'ownership_id' => $request->ownership_id,
            'reporter_id' => Auth::id(),
            'complaint_title' => $request->complaint_title,
            'complaint_description' => $request->complaint_description,
            'complaint_photo' => $photoPath,
            'complaint_date' => now(),
            'status' => 'Pending',
            'cost' => 0,
            'payment_status' => 'Free',
        ]);

        return redirect()->route('complaints.index')
            ->with('success', 'Keluhan berhasil dikirim. Menunggu respon Admin.');
    }

    // --- FITUR UPDATE PEMBAYARAN ---
    public function markAsPaid($id)
    {
        $order = MaintenanceOrder::findOrFail($id);

        // Cek dulu apakah ada tagihan
        if ($order->cost <= 0) {
            return back()->with('error', 'Tidak ada tagihan untuk pesanan ini.');
        }

        // Update jadi Lunas
        $order->update([
            'payment_status' => 'Paid',
        ]);

        return back()->with('success', 'Tagihan berhasil ditandai LUNAS.');
    }

    public function showUser($id)
    {
        $order = MaintenanceOrder::where('reporter_id', Auth::id())->with('technician')->findOrFail($id);

        return view('complaints.show', compact('order'));
    }

    public function rateService(Request $request, $id)
    {
        $order = MaintenanceOrder::where('reporter_id', Auth::id())->findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $order->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Terima kasih atas penilaian Anda!');
    }

    // CETAK TIKET (BONUS)
    public function printTicket($id)
    {
        $order = MaintenanceOrder::with(['ownership.unit', 'technician'])
            ->where('reporter_id', Auth::id()) // Pastikan punya dia sendiri
            ->findOrFail($id);

        $pdf = Pdf::loadView('complaints.ticket', compact('order'));

        // Set ukuran kertas struk (opsional, kita pakai A4 setengah aja biar rapi)
        $pdf->setPaper('A5', 'landscape');

        return $pdf->stream('Tiket-Laporan-#'.$order->id.'.pdf');
    }
}
