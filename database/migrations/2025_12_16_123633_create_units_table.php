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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('block'); // Blok A
            $table->string('number'); // No 12
            $table->string('type'); // Tipe 36
            $table->integer('land_size'); // Luas Tanah (m2)
            $table->integer('building_size'); // Luas Bangunan (m2)
            $table->integer('electricity'); // 1300 VA
            $table->string('water_source'); // PDAM / Sumur
            $table->text('room_details'); // "2 KT, 1 KM" (Request Dospem)
            $table->decimal('price', 15, 2)->nullable(); // Harga jual
            $table->enum('status', ['Tersedia', 'Terjual'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
