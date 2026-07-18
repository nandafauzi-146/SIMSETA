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
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sertifikat')->unique();
            $table->string('nib')->nullable();
            $table->foreignId('pemilik_id')->constrained('pemiliks')->cascadeOnDelete();
            $table->foreignId('jenis_hak_id')->constrained('jenis_hak_tanahs')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('status_sertifikats')->cascadeOnDelete();
            $table->foreignId('desa_id')->constrained('desas')->cascadeOnDelete();
            $table->decimal('luas', 10, 2);
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};
