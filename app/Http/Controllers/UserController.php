<?php

namespace App\Http\Controllers;

use App\Models\Ownership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // Method CREATE (Menampilkan Form Tambah)
    public function create()
    {
        // 1. Ambil list kepemilikan Active (sama seperti di edit)
        $ownerships = Ownership::with(['unit', 'customer'])
            ->where('status', 'Active')
            ->get();

        // 2. Kirim $ownerships ke view
        // Kita juga kirim 'user' kosong agar _form.blade.php tidak error saat akses $user->name, dll.
        return view('admin.users.create', [
            'user' => new User,
            'ownerships' => $ownerships,
        ]);
    }

    // Method STORE (Menyimpan Data Baru)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            'ownership_id' => 'nullable|exists:ownerships,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,

            // Simpan ownership_id (bisa null jika bukan warga)
            'ownership_id' => $request->ownership_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Ambil list kepemilikan yang ACTIVE saja untuk dipilih
        $ownerships = Ownership::with(['unit', 'customer'])
            ->where('status', 'Active')
            ->get();

        return view('admin.users.edit', compact('user', 'ownerships'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
            // Validasi ownership_id opsional (boleh kosong kalau bukan warga)
            'ownership_id' => 'nullable|exists:ownerships,id',
        ]);

        $data = $request->only(['name', 'email', 'role', 'ownership_id']);

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna diperbarui');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
