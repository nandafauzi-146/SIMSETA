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
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penyewa',
                'biaya_sewa',
                'sewa_mulai',
                'sewa_selesai',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('nama_penyewa')->nullable()->after('status_pemanfaatan');
            $table->decimal('biaya_sewa', 15, 2)->nullable()->after('nama_penyewa');
            $table->date('sewa_mulai')->nullable()->after('biaya_sewa');
            $table->date('sewa_selesai')->nullable()->after('sewa_mulai');
        });
    }
};
