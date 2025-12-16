<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Semua kolom boleh diisi kecuali ID

    // Relasi: Unit punya satu kepemilikan (Ownership)
    public function ownership()
    {
        return $this->hasOne(Ownership::class);
    }
}
