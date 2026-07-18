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

        // Create initial Admin account (change password after first login)
        $admin = User::firstOrCreate([
            'email' => 'admin@simseta.local',
        ], [
            'name' => 'Administrator',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // Master Data
        \App\Models\Desa::firstOrCreate(['nama' => 'Desa Utama', 'dusun' => 'Dusun Utama']);

        $jenisHak = ['Hak Milik', 'Hak Guna Bangunan (HGB)', 'Hak Pakai', 'Hak Guna Usaha'];
        foreach ($jenisHak as $jenis) {
            \App\Models\JenisHakTanah::firstOrCreate(['nama' => $jenis]);
        }

        $statusSertifikat = ['Aktif', 'Sengketa', 'Dijaminkan', 'Dalam Proses', 'Kadaluarsa'];
        foreach ($statusSertifikat as $status) {
            \App\Models\StatusSertifikat::firstOrCreate(['nama' => $status]);
        }
    }
}
