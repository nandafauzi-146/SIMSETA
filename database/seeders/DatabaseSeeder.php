<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Setup Roles (Admin & Staff)
        $roles = ['Admin', 'Staff'];
        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
        }

        // Create initial Admin account
        $admin = User::firstOrCreate([
            'email' => 'admin@simseta.local',
        ], [
            'name' => 'Administrator',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // Master Data
        $dusun1 = \App\Models\Desa::firstOrCreate(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh I']);
        $dusun2 = \App\Models\Desa::firstOrCreate(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh II']);

        $jenisHak = ['Hak Milik', 'Hak Guna Bangunan (HGB)', 'Hak Pakai', 'Hak Guna Usaha'];
        foreach ($jenisHak as $jenis) {
            \App\Models\JenisHakTanah::firstOrCreate(['nama' => $jenis]);
        }

        $statusSertifikat = ['Aktif', 'Sengketa', 'Dijaminkan', 'Dalam Proses', 'Kadaluarsa'];
        foreach ($statusSertifikat as $status) {
            \App\Models\StatusSertifikat::firstOrCreate(['nama' => $status]);
        }

        // Create Pemiliks
        $pemilik1 = \App\Models\Pemilik::firstOrCreate(['nik' => '3301010101010001'], ['nama' => 'Ahmad Yusuf', 'alamat' => 'RT 01 / RW 02']);
        $pemilik2 = \App\Models\Pemilik::firstOrCreate(['nik' => '3301010101010002'], ['nama' => 'Budi Santoso', 'alamat' => 'RT 03 / RW 02']);
        $pemilikDesa = \App\Models\Pemilik::firstOrCreate(['nik' => '3301010101010000'], ['nama' => 'Pemerintah Desa Tegalmulyo', 'alamat' => 'Jl. Raya Tegalmulyo No. 1']);

        // Create Sertifikats (Masyarakat & Kas Desa)
        \App\Models\Sertifikat::firstOrCreate([
            'nomor_sertifikat' => 'M.4567',
        ], [
            'nib' => '12.01.02.03.04567',
            'pemilik_id' => $pemilik1->id,
            'jenis_hak_id' => 1, // Hak Milik
            'status_id' => 1, // Aktif
            'desa_id' => $dusun1->id,
            'luas' => 450,
            'kategori' => 'masyarakat',
            'created_at' => now()->subMonths(2),
        ]);

        \App\Models\Sertifikat::firstOrCreate([
            'nomor_sertifikat' => 'M.7890',
        ], [
            'nib' => '12.01.02.03.07890',
            'pemilik_id' => $pemilik2->id,
            'jenis_hak_id' => 1, // Hak Milik
            'status_id' => 1, // Aktif
            'desa_id' => $dusun2->id,
            'luas' => 850,
            'kategori' => 'masyarakat',
            'created_at' => now()->subMonths(1),
        ]);

        \App\Models\Sertifikat::firstOrCreate([
            'nomor_sertifikat' => 'HP.0022',
        ], [
            'nib' => '12.01.02.03.00022',
            'pemilik_id' => $pemilikDesa->id,
            'jenis_hak_id' => 3, // Hak Pakai
            'status_id' => 1, // Aktif
            'desa_id' => $dusun1->id,
            'luas' => 2500,
            'kategori' => 'kas_desa',
            'status_pemanfaatan' => 'Dipakai Pemerintah Desa',
            'created_at' => now()->subMonths(3),
        ]);

        \App\Models\Sertifikat::firstOrCreate([
            'nomor_sertifikat' => 'HP.0089',
        ], [
            'nib' => '12.01.02.03.00089',
            'pemilik_id' => $pemilikDesa->id,
            'jenis_hak_id' => 3, // Hak Pakai
            'status_id' => 1, // Aktif
            'desa_id' => $dusun2->id,
            'luas' => 1200,
            'kategori' => 'kas_desa',
            'status_pemanfaatan' => 'Disewakan',
            'created_at' => now(),
        ]);
    }
}
