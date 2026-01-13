<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Tabel Master Harga (List Biaya Perbaikan)
        Schema::create('repair_prices', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); // Nama Jasa
            $table->decimal('price', 10, 2); // Harga Standar
            $table->timestamps();
        });

        // 2. Tambah Kolom Biaya di Transaksi Keluhan
        Schema::table('maintenance_orders', function (Blueprint $table) {
            $table->decimal('cost', 10, 2)->default(0)->after('status'); // Total Biaya
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Free'])->default('Free')->after('cost'); // Status Bayar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
