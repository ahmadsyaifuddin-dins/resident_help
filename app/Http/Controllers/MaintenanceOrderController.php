<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'status' => 'required',
            'cost' => 'nullable|numeric',
        ]);

        $order->status = $request->status;

        if ($request->status == 'In_Progress' && $request->technician_id) {
            $order->technician_id = $request->technician_id;
            Technician::where('id', $request->technician_id)->update(['status' => 'Busy']);
        }

        if ($request->status == 'Done') {
            $order->completion_date = now();
            if ($order->technician_id) {
                Technician::where('id', $order->technician_id)->update(['status' => 'Available']);
            }

            // LOGIC BIAYA (Langsung ambil dari request)
            $cost = $request->input('cost'); // Ambil nilai langsung

            if ($cost > 0) {
                $order->cost = $cost;
                $order->payment_status = 'Unpaid';
            } else {
                $order->cost = 0;
                $order->payment_status = 'Free';
            }
        }

        $order->save();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Status perbaikan berhasil diperbarui.');
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
        // User harus pilih rumah mana yang rusak
        // Logic: Cari ownership dimana user ini adalah customer-nya
        // ATAU kalau dia Warga, cari ownership customer terkait (ini agak kompleks, kita simpelkan dulu: ambil semua unit active)

        $myHomes = Ownership::where('status', 'Active')->with('unit')->get();

        // Note: Idealnya difilter berdasarkan Customer ID user login,
        // tapi untuk demo PKL, ambil semua Active ownership gapapa biar gampang ngetesnya.

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
