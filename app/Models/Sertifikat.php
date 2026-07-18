<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sertifikat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_sertifikat', 'nib', 'pemilik_id', 'jenis_hak_id',
        'status_id', 'desa_id', 'luas', 'alamat', 'latitude', 'longitude',
    ];

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
}
