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
        Schema::create('maintenance_orders', function (Blueprint $table) {
            $table->id();
            // Relasi ke Ownership (Biar tau rumah mana yg rusak)
            $table->foreignId('ownership_id')->constrained('ownerships')->onDelete('cascade');

            // Relasi ke User (Siapa yang lapor? Bisa Nasabah/Warga)
            $table->foreignId('reporter_id')->constrained('users');

            // Relasi ke Tukang (Nullable karena pas lapor belum tentu langsung dapet tukang)
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('set null');

            $table->string('complaint_title'); // "Atap Bocor di Dapur"
            $table->text('complaint_description');
            $table->string('complaint_photo')->nullable(); // Path foto

            $table->date('complaint_date');
            $table->date('completion_date')->nullable(); // Diisi pas status Done

            $table->enum('status', ['Pending', 'In_Progress', 'Done', 'Cancelled'])->default('Pending');

            // Feedback
            $table->integer('rating')->nullable(); // 1-5
            $table->text('review')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_orders');
    }
};
