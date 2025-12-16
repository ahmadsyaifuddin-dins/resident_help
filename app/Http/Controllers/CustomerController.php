<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Ambil data customer beserta data user-nya (nama/email)
        $customers = Customer::with('user')->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        // Cari User (Role Nasabah) yang BELUM ada di tabel customers
        // Supaya tidak double data untuk satu orang
        $existingCustomerIds = Customer::pluck('user_id');

        $users = User::where('role', 'nasabah')
            ->whereNotIn('id', $existingCustomerIds)
            ->get();

        return view('admin.customers.create', [
            'customer' => new Customer,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:customers,user_id',
            'nik' => 'required|string|size:16|unique:customers,nik', // Wajib 16 digit
            'phone' => 'required|string|max:15',
            'name' => 'required|string|max:255', // Nama di KTP (bisa beda dgn nama akun)
            'address' => 'required|string',
            'domicile_address' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')
            ->with('success', 'Biodata Nasabah berhasil dilengkapi.');
    }

    public function edit(Customer $customer)
    {
        // Di edit, kita tidak bisa ganti User ID (sudah terkunci)
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:customers,nik,'.$customer->id,
            'phone' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'domicile_address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('admin.customers.index')
            ->with('success', 'Biodata Nasabah berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Data Nasabah dihapus (Akun login tetap ada).');
    }
}
