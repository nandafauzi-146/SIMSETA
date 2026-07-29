<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nomor_sertifikat
 * @property string|null $nib
 * @property int $pemilik_id
 * @property int $jenis_hak_id
 * @property int $status_id
 * @property int $desa_id
 * @property float $luas
 * @property string $kategori
 * @property string|null $status_pemanfaatan
 * @property string|null $alamat
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $penanggung_jawab
 * @property string|null $jabatan
 * @property string|null $unit_pengelola
 * @property string|null $rt_rw
 * @property string|null $blok
 * @property string|null $persil
 * @property string|null $penggunaan_tanah
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $kategori_label
 * @property bool $is_kas_desa
 */

class Sertifikat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_sertifikat', 'nib', 'pemilik_id', 'jenis_hak_id',
        'status_id', 'desa_id', 'luas', 'alamat', 'latitude', 'longitude',
        // Kas Desa fields
        'kategori', 'status_pemanfaatan',
        // Detailed fields
        'penanggung_jawab', 'jabatan', 'unit_pengelola',
        'rt_rw', 'blok', 'persil', 'penggunaan_tanah',
    ];

    protected $casts = [
    ];

    /* ── Relationships ─────────────────────────── */

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class);
    }

    public function jenis_hak()
    {
        return $this->belongsTo(JenisHakTanah::class, 'jenis_hak_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusSertifikat::class, 'status_id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    /* ── Scopes ─────────────────────────────────── */

    public function scopeMasyarakat($query)
    {
        return $query->where('kategori', 'masyarakat');
    }

    public function scopeKasDesa($query)
    {
        return $query->where('kategori', 'kas_desa');
    }

    /* ── Accessors ──────────────────────────────── */

    public function getKategoriLabelAttribute(): string
    {
        return $this->kategori === 'kas_desa' ? 'Tanah Kas Desa' : 'Tanah Pribadi';
    }

    public function getIsKasDesaAttribute(): bool
    {
        return $this->kategori === 'kas_desa';
    }
}
