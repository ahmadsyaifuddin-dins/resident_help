<?php

namespace App\Http\Controllers;

use App\Models\RepairPrice;
use Illuminate\Http\Request;

class RepairPriceController extends Controller
{
    // Tampilkan Daftar Harga
    public function index()
    {
        $prices = RepairPrice::latest()->paginate(10);

        return view('admin.prices.index', compact('prices'));
    }

    // Form Tambah
    public function create()
    {
        return view('admin.prices.create', ['price' => new RepairPrice]);
    }

    // Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        RepairPrice::create($request->all());

        return redirect()->route('admin.prices.index')
            ->with('success', 'Biaya perbaikan berhasil ditambahkan.');
    }

    // Form Edit
    public function edit(RepairPrice $price)
    {
        return view('admin.prices.edit', compact('price'));
    }

    // Update Data
    public function update(Request $request, RepairPrice $price)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $price->update($request->all());

        return redirect()->route('admin.prices.index')
            ->with('success', 'Data biaya berhasil diperbarui.');
    }

    // Hapus Data
    public function destroy(RepairPrice $price)
    {
        $price->delete();

        return redirect()->route('admin.prices.index')
            ->with('success', 'Data biaya berhasil dihapus.');
    }
}
