<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $fillable = ['nik', 'nama', 'alamat', 'telepon'];

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class);
    }
}
