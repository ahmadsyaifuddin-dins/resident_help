<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function collection()
    {
        return Customer::with('user')->get();
    }

    // Judul Kolom di Excel
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'No HP',
            'Email Akun',
            'Alamat KTP',
            'Alamat Domisili',
            'Tanggal Terdaftar',
        ];
    }

    // Data per baris
    public function map($customer): array
    {
        return [
            $customer->name,
            "'".$customer->nik, // Tambah kutip biar excel ngebaca sbg teks (bukan angka ilmiah)
            $customer->phone,
            $customer->user->email ?? '-',
            $customer->address,
            $customer->domicile_address ?? 'Sama dengan KTP',
            $customer->created_at->format('d-m-Y'),
        ];
    }
}
