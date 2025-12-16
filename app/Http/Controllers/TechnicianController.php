<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index()
    {
        $technicians = Technician::latest()->paginate(10);

        return view('admin.technicians.index', compact('technicians'));
    }

    public function show(Technician $technician)
    {
        // Opsional: Load history pekerjaan kalau mau lebih canggih
        // $technician->load('maintenanceOrders');
        return view('admin.technicians.show', compact('technician'));
    }

    public function create()
    {
        return view('admin.technicians.create', ['technician' => new Technician]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'specialty' => 'required|in:Listrik,Air/Pipa,Bangunan/Semen,Atap,Kayu,Keramik,Lainnya',
            'status' => 'required|in:Available,Busy',
        ]);

        Technician::create($request->all());

        return redirect()->route('admin.technicians.index')
            ->with('success', 'Data tukang berhasil ditambahkan.');
    }

    public function edit(Technician $technician)
    {
        return view('admin.technicians.edit', ['technician' => $technician]);
    }

    public function update(Request $request, Technician $technician)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'specialty' => 'required|in:Listrik,Air/Pipa,Bangunan/Semen,Atap,Kayu,Keramik,Lainnya',
            'status' => 'required|in:Available,Busy',
        ]);

        $technician->update($request->all());

        return redirect()->route('admin.technicians.index')
            ->with('success', 'Data tukang berhasil diperbarui.');
    }

    public function destroy(Technician $technician)
    {
        $technician->delete();

        return redirect()->route('admin.technicians.index')
            ->with('success', 'Data tukang berhasil dihapus.');
    }
}
