<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('desas', 'dusun')) {
            Schema::table('desas', function (Blueprint $table) {
                $table->string('dusun')->nullable()->after('nama');
            });
        }
    }

    public function down(): void
    {
        //
    }
};
