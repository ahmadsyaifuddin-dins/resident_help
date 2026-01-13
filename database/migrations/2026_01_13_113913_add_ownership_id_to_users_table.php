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
        Schema::table('users', function (Blueprint $table) {
            // Kolom ini nullable, karena Admin/Nasabah tidak butuh ini
            // Hanya user role 'warga' yang butuh.
            $table->foreignId('ownership_id')->nullable()->constrained('ownerships')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ownership_id']);
            $table->dropColumn('ownership_id');
        });
    }
};
