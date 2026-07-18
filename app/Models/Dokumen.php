<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = ['sertifikat_id', 'nama_file', 'jenis_file', 'path'];

    public function sertifikat()
    {
        return $this->belongsTo(Sertifikat::class);
    }
}
