<?php

namespace Tests\Feature;

use App\Models\Desa;
use App\Models\JenisHakTanah;
use App\Models\Pemilik;
use App\Models\Sertifikat;
use App\Models\StatusSertifikat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        Role::firstOrCreate(['name' => 'Admin']);
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('Admin');
        return $user;
    }

    private function sertifikat(Desa $desa): Sertifikat
    {
        $pemilik = Pemilik::create(['nik' => '0000000000000001', 'nama' => 'Pemilik Uji']);
        $jenis = JenisHakTanah::create(['nama' => 'Hak Milik']);
        $status = StatusSertifikat::create(['nama' => 'Aktif']);

return Sertifikat::create([
            'nomor_sertifikat' => 'TEST-' . mt_rand(1000, 9999) . '-' . Str::random(4),
            'nib' => '12.01.02.03.04567',
            'pemilik_id' => $pemilik->id,
            'jenis_hak_id' => $jenis->id,
            'status_id' => $status->id,
            'desa_id' => $desa->id,
            'luas' => 100,
            'kategori' => 'masyarakat',
        ]);
    }

    public function test_dashboard_loads_on_sqlite(): void
    {
        $desa = Desa::create(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh I']);
        $this->sertifikat($desa);

        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_desa_with_sertifikats_cannot_be_deleted(): void
    {
        $desa = Desa::create(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh I']);
        $this->sertifikat($desa);

        $this->actingAs($this->admin())
            ->delete(route('admin.desa.destroy', $desa))
            ->assertRedirect();

        $this->assertDatabaseHas('desas', ['id' => $desa->id]);
        $this->assertDatabaseCount('sertifikats', 1);
    }

    public function test_desa_without_sertifikats_can_be_deleted(): void
    {
        $desa = Desa::create(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh II']);

        $this->actingAs($this->admin())
            ->delete(route('admin.desa.destroy', $desa))
            ->assertRedirect();

        $this->assertDatabaseMissing('desas', ['id' => $desa->id]);
    }

    public function test_staff_cannot_delete_desa(): void
    {
        Role::firstOrCreate(['name' => 'Staff']);
        $staff = User::factory()->create(['is_active' => true]);
        $staff->assignRole('Staff');

        $desa = Desa::create(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh III']);

        $this->actingAs($staff)
            ->delete(route('admin.desa.destroy', $desa))
            ->assertForbidden();

        $this->assertDatabaseHas('desas', ['id' => $desa->id]);
    }

    public function test_public_search_matches_nib_typed_without_dots(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true], 200),
        ]);

        $desa = Desa::create(['nama' => 'Tegalmulyo', 'dusun' => 'Dukuh I']);
        $this->sertifikat($desa);

        $response = $this->post(route('public.search'), [
            'keyword' => '1201020304567',
            'cf-turnstile-response' => 'dummy',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
    }
}