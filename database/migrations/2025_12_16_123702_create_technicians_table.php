<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            // Spesialisasi sesuai chat dospem
            $table->enum('specialty', ['Listrik', 'Air/Pipa', 'Bangunan/Semen', 'Atap', 'Kayu', 'Keramik', 'Lainnya']);
            $table->enum('status', ['Available', 'Busy'])->default('Available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
