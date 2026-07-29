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
            $table->string('penanggung_jawab')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('unit_pengelola')->nullable();
            $table->string('rt_rw', 50)->nullable();
            $table->string('blok')->nullable();
            $table->string('persil')->nullable();
            $table->string('penggunaan_tanah')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn([
                'penanggung_jawab',
                'jabatan',
                'unit_pengelola',
                'rt_rw',
                'blok',
                'persil',
                'penggunaan_tanah',
            ]);
        });
    }
};
