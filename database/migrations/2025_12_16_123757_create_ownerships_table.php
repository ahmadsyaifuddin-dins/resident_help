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
        Schema::create('ownerships', function (Blueprint $table) {
            $table->id();
            // Relasi Unit & Customer
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->enum('purchase_method', ['CASH', 'KREDIT']);
            $table->string('bank_name')->nullable(); // Isi jika KREDIT (BTN, Mandiri)

            $table->date('handover_date'); // Tanggal Serah Terima
            $table->date('warranty_end_date'); // Tanggal Garansi Habis (Logic +3 Tahun)

            $table->enum('status', ['Active', 'Sold', 'Moved Out'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownerships');
    }
};
