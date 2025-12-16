<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ownership extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Ubah string tanggal jadi format Date otomatis
    protected $casts = [
        'handover_date' => 'date',
        'warranty_end_date' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Laporan Kerusakan
    public function maintenanceOrders()
    {
        return $this->hasMany(MaintenanceOrder::class);
    }
}
