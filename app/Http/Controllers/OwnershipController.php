<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ownership;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnershipController extends Controller
{
    public function index()
    {
        // Load data kepemilikan beserta relasi unit dan customer
        $ownerships = Ownership::with(['unit', 'customer'])->latest()->paginate(10);

        return view('admin.ownerships.index', compact('ownerships'));
    }

    public function show(Ownership $ownership)
    {
        return view('admin.ownerships.show', compact('ownership'));
    }

    public function create()
    {
        // 1. Ambil Unit yang statusnya 'Tersedia' (Biar rumah yg udah laku gak dijual lagi)
        $units = Unit::where('status', 'Tersedia')->get();

        // 2. Ambil semua Customer
        $customers = Customer::all();

        return view('admin.ownerships.create', [
            'ownership' => new Ownership,
            'units' => $units,
            'customers' => $customers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'customer_id' => 'required|exists:customers,id',
            'purchase_method' => 'required|in:CASH,KREDIT',
            'bank_name' => 'nullable|string', // Wajib jika Kredit (validasi di UI aja biar simpel)
            'handover_date' => 'required|date',
            'status' => 'required|in:Active,Sold,Moved Out',
        ]);

        // LOGIC GARANSI: Tanggal Serah Terima + 3 TAHUN
        $handoverDate = Carbon::parse($request->handover_date);
        $warrantyEndDate = $handoverDate->copy()->addYears(3);

        Ownership::create([
            'unit_id' => $request->unit_id,
            'customer_id' => $request->customer_id,
            'purchase_method' => $request->purchase_method,
            'bank_name' => $request->bank_name,
            'handover_date' => $handoverDate,
            'warranty_end_date' => $warrantyEndDate, // Simpan hasil hitungan
            'status' => $request->status,
        ]);

        // AUTO UPDATE STATUS UNIT JADI 'TERJUAL'
        Unit::where('id', $request->unit_id)->update(['status' => 'Terjual']);

        return redirect()->route('admin.ownerships.index')
            ->with('success', 'Data Kepemilikan berhasil disimpan. Garansi aktif s/d '.$warrantyEndDate->format('d-m-Y'));
    }

    public function edit(Ownership $ownership)
    {
        // Di edit, kita tampilkan semua unit (termasuk yg sudah sold oleh orang ini)
        $units = Unit::all();
        $customers = Customer::all();

        return view('admin.ownerships.edit', compact('ownership', 'units', 'customers'));
    }

    public function update(Request $request, Ownership $ownership)
    {
        $request->validate([
            'purchase_method' => 'required|in:CASH,KREDIT',
            'bank_name' => 'nullable|string',
            'handover_date' => 'required|date',
            'status' => 'required|in:Active,Sold,Moved Out',
        ]);

        // Hitung ulang garansi jika tanggal serah terima diedit
        $handoverDate = Carbon::parse($request->handover_date);
        $warrantyEndDate = $handoverDate->copy()->addYears(3);

        $ownership->update([
            'purchase_method' => $request->purchase_method,
            'bank_name' => $request->bank_name,
            'handover_date' => $handoverDate,
            'warranty_end_date' => $warrantyEndDate,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.ownerships.index')
            ->with('success', 'Data Kepemilikan diperbarui.');
    }

    // --- FITUR KHUSUS NASABAH ---
    public function myAssets()
    {
        $user = Auth::user();

        // 1. Cari data Customer milik User yang sedang login
        $customer = Customer::where('user_id', $user->id)->first();

        // 2. Jika user belum didaftarkan biodatanya oleh Admin
        if (! $customer) {
            return view('nasabah.assets', ['ownerships' => collect([])]);
        }

        // 3. Ambil data kepemilikan rumah berdasarkan customer_id
        $ownerships = Ownership::with('unit')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('nasabah.assets', compact('ownerships'));
    }

    public function destroy(Ownership $ownership)
    {
        // Kembalikan status unit jadi 'Tersedia' jika data dihapus
        $ownership->unit()->update(['status' => 'Tersedia']);

        $ownership->delete();

        return redirect()->route('admin.ownerships.index')
            ->with('success', 'Data Kepemilikan dihapus.');
    }
}
