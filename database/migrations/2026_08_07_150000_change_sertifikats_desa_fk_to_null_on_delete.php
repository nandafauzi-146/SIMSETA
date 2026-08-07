<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cegah kehilangan data massal: menghapus Dukuh tidak lagi ikut
 * menghapus seluruh sertifikat/dokumen milik dukuh tersebut.
 * Sebagai gantinya, sertifikat dengan desa_id yang dihapus di-set NULL
 * (dan tampil sebagai "belum terkait dukuh" sampai admin menetapkannya ulang).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropForeign(['desa_id']);
            $table->unsignedBigInteger('desa_id')->nullable()->change();
            $table->foreign('desa_id')->references('id')->on('desas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropForeign(['desa_id']);
            $table->unsignedBigInteger('desa_id')->nullable(false)->change();
            $table->foreign('desa_id')->references('id')->on('desas')->cascadeOnDelete();
        });
    }
};