<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceOrder extends Model
{
    use HasFactory;

    protected $casts = [
        'complaint_date' => 'date',
        'completion_date' => 'date',
        'cost' => 'integer',
    ];

    protected $fillable = [
        'ownership_id',
        'reporter_id',
        'technician_id',
        'complaint_date',
        'complaint_title',
        'complaint_description',
        'complaint_photo',
        'status',
        'completion_date',
        'rating',
        'review',
        'cost',
        'payment_status',
    ];

    // Rumah mana yang rusak
    public function ownership()
    {
        return $this->belongsTo(Ownership::class);
    }

    // Siapa tukang yang ngerjain
    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    // Siapa yang lapor (User: Nasabah/Warga)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
