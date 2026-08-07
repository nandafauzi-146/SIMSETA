<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan index composite dan individual untuk meningkatkan
 * performa query pada kolom yang sering digunakan di filter/search.
 *
 * Gunakan Schema::hasIndex() (bukan SHOW INDEX) agar kompatibel
 * dengan MySQL, MariaDB, dan SQLite (lingkungan pengujian).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            if (!Schema::hasIndex('sertifikats', 'sertifikats_created_at_index')) {
                $table->index('created_at', 'sertifikats_created_at_index');
            }
            if (!Schema::hasIndex('sertifikats', 'sertifikats_kategori_status_index')) {
                $table->index(['kategori', 'status_id'], 'sertifikats_kategori_status_index');
            }
            if (!Schema::hasIndex('sertifikats', 'sertifikats_penggunaan_tanah_index')) {
                $table->index('penggunaan_tanah', 'sertifikats_penggunaan_tanah_index');
            }
            if (!Schema::hasIndex('sertifikats', 'sertifikats_deleted_at_created_at_index')) {
                $table->index(['deleted_at', 'created_at'], 'sertifikats_deleted_at_created_at_index');
            }
        });

        Schema::table('pemiliks', function (Blueprint $table) {
            if (!Schema::hasIndex('pemiliks', 'pemiliks_nama_index')) {
                $table->index('nama', 'pemiliks_nama_index');
            }
        });
    }

    public function down(): void
    {
        $sertifikatIndexes = [
            'sertifikats_created_at_index',
            'sertifikats_kategori_status_index',
            'sertifikats_penggunaan_tanah_index',
            'sertifikats_deleted_at_created_at_index',
        ];

        Schema::table('sertifikats', function (Blueprint $table) use ($sertifikatIndexes) {
            foreach ($sertifikatIndexes as $name) {
                if (Schema::hasIndex('sertifikats', $name)) {
                    $table->dropIndex($name);
                }
            }
        });

        Schema::table('pemiliks', function (Blueprint $table) {
            if (Schema::hasIndex('pemiliks', 'pemiliks_nama_index')) {
                $table->dropIndex('pemiliks_nama_index');
            }
        });
    }
};