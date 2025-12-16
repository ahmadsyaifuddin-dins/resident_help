<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke User (Akun login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu nasabah bisa punya banyak rumah (investor)
    public function ownerships()
    {
        return $this->hasMany(Ownership::class);
    }
}
