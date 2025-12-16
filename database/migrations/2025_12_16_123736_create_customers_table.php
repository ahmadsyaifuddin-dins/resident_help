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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (opsional nullable, siapa tau admin input data dulu baru bikin akun)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('name'); // Nama lengkap sesuai KTP
            $table->string('nik', 16)->unique(); // Request Dospem Wajib KTP
            $table->string('phone');
            $table->text('address'); // Alamat KTP
            $table->text('domicile_address')->nullable(); // Alamat Domisili
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
