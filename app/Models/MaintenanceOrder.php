<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'complaint_date' => 'date',
        'completion_date' => 'date',
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
