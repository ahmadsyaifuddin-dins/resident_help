<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\MaintenanceOrder;
use App\Models\Ownership;
use App\Models\Technician;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT USER (AKUN LOGIN)
        // Admin
        User::create([
            'name' => 'Admin Sekumpul',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '081122334455',
        ]);

        // Nasabah (Pemilik Asli)
        $userNasabah = User::create([
            'name' => 'Nasabah (Pemilik Asli)',
            'email' => 'nasabah@gmail.com',
            'role' => 'nasabah',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
        ]);

        // Warga (Penghuni/Anak)
        $userWarga = User::create([
            'name' => 'Warga (Penghuni Rumah 1)',
            'email' => 'warga@gmail.com',
            'role' => 'warga',
            'password' => Hash::make('password'),
            'phone' => '089876543210',
        ]);

        // 2. BUAT DATA TEKNISI (Sesuai Chat Dospem)
        $techs = [
            ['name' => 'Mang Peter', 'specialty' => 'Listrik', 'phone' => '0855112233'],
            ['name' => 'Pak Slamet', 'specialty' => 'Air/Pipa', 'phone' => '0855445566'],
            ['name' => 'Mas Joko', 'specialty' => 'Bangunan/Semen', 'phone' => '0855778899'],
            ['name' => 'Kang Asep', 'specialty' => 'Atap', 'phone' => '0855009988'],
            ['name' => 'Pak Budi', 'specialty' => 'Kayu', 'phone' => '0855123123'],
        ];

        foreach ($techs as $t) {
            Technician::create([
                'name' => $t['name'],
                'specialty' => $t['specialty'],
                'phone' => $t['phone'],
                'status' => 'Available',
            ]);
        }

        // 3. BUAT DATA UNIT RUMAH (Sesuai Spek Dospem)
        $unit1 = Unit::create([
            'block' => 'A',
            'number' => '10',
            'type' => '45',
            'land_size' => 120,
            'building_size' => 45,
            'electricity' => 1300,
            'water_source' => 'PDAM Intan Banjar',
            'room_details' => '2 Kamar Tidur, 1 Kamar Mandi, Dapur, Carport',
            'price' => 450000000,
            'status' => 'Terjual',
        ]);

        $unit2 = Unit::create([
            'block' => 'B',
            'number' => '05',
            'type' => '36',
            'land_size' => 90,
            'building_size' => 36,
            'electricity' => 900,
            'water_source' => 'Sumur Bor',
            'room_details' => '2 Kamar Tidur, 1 Kamar Mandi, Ruang Tamu',
            'price' => 300000000,
            'status' => 'Tersedia',
        ]);

        // 4. BUAT DATA CUSTOMER DETAIL (Profil Lengkap Nasabah)
        $customer = Customer::create([
            'user_id' => $userNasabah->id,
            'name' => 'Customer',
            'nik' => '6371012300000001',
            'phone' => '081234567890',
            'address' => 'Jl. Sekumpul Depan No. 12, Martapura',
            'domicile_address' => 'Komplek Lulut Resident Blok A No 10',
        ]);

        // 5. BUAT DATA KEPEMILIKAN (OWNERSHIP)
        // Hubungkan Customer dengan Unit A-10
        $handoverDate = Carbon::create(2023, 5, 20); // Serah terima 2023

        $ownership = Ownership::create([
            'unit_id' => $unit1->id,
            'customer_id' => $customer->id,
            'purchase_method' => 'KREDIT',
            'bank_name' => 'BTN Syariah',
            'handover_date' => $handoverDate,
            'warranty_end_date' => $handoverDate->copy()->addYears(3), // Otomatis 2026
            'status' => 'Active',
        ]);

        // 6. BUAT SAMPLE MAINTENANCE ORDER (Histori Perbaikan)
        // Kasus 1: Sudah Selesai (Done)
        MaintenanceOrder::create([
            'ownership_id' => $ownership->id,
            'reporter_id' => $userWarga->id, // Anaknya yang lapor
            'technician_id' => 1, // Mang Peter (Listrik)
            'complaint_title' => 'Saklar Kamar Depan Konslet',
            'complaint_description' => 'Pas dinyalakan ada bunyi pletek dan lampu tidak nyala.',
            'complaint_date' => Carbon::create(2025, 1, 10),
            'completion_date' => Carbon::create(2025, 1, 11),
            'status' => 'Done',
            'rating' => 5,
            'review' => 'Mantap, respon cepat. Mang Peter ramah.',
        ]);

        // Kasus 2: Masih Proses (In_Progress)
        MaintenanceOrder::create([
            'ownership_id' => $ownership->id,
            'reporter_id' => $userNasabah->id, // Customer sendiri yang lapor
            'technician_id' => 2, // Pak Slamet (Air)
            'complaint_title' => 'Pipa Wastafel Bocor',
            'complaint_description' => 'Air merembes ke lantai dapur.',
            'complaint_date' => Carbon::now()->subDays(1),
            'status' => 'In_Progress',
        ]);
    }
}
