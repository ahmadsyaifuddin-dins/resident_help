<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        // Tampilkan data terbaru, paginate 10
        $units = Unit::latest()->paginate(10);

        return view('admin.units.index', compact('units'));
    }

    public function show(Unit $unit)
    {
        return view('admin.units.show', compact('unit'));
    }

    public function create()
    {
        // Kirim object kosong biar form tidak error
        return view('admin.units.create', ['unit' => new Unit]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'block' => 'required|string|max:25',
            'number' => 'required|string|max:10',
            'type' => 'required|string|max:10',
            'land_size' => 'required|integer',
            'building_size' => 'required|integer',
            'electricity' => 'required|integer',
            'water_source' => 'required|string',
            'room_details' => 'required|string',
            'price' => 'nullable|numeric',
            'status' => 'required|in:Tersedia,Terjual',
        ]);

        Unit::create($request->all());

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit rumah berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'block' => 'required|string|max:25',
            'number' => 'required|string|max:10',
            'type' => 'required|string|max:10',
            'land_size' => 'required|integer',
            'building_size' => 'required|integer',
            'electricity' => 'required|integer',
            'water_source' => 'required|string',
            'room_details' => 'required|string',
            'price' => 'nullable|numeric',
            'status' => 'required|in:Tersedia,Terjual',
        ]);

        $unit->update($request->all());

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit rumah berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit rumah berhasil dihapus.');
    }
}
