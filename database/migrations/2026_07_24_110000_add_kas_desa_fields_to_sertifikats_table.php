<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add fields to differentiate Tanah Masyarakat from Tanah Kas Desa.
     */
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('kategori')->default('masyarakat')->after('longitude');
            $table->string('status_pemanfaatan')->nullable()->after('kategori');
            $table->string('nama_penyewa')->nullable()->after('status_pemanfaatan');
            $table->decimal('biaya_sewa', 15, 2)->nullable()->after('nama_penyewa');
            $table->date('sewa_mulai')->nullable()->after('biaya_sewa');
            $table->date('sewa_selesai')->nullable()->after('sewa_mulai');

            $table->index('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropIndex(['kategori']);
            $table->dropColumn([
                'kategori',
                'status_pemanfaatan',
                'nama_penyewa',
                'biaya_sewa',
                'sewa_mulai',
                'sewa_selesai',
            ]);
        });
    }
};
