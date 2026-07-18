<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $fillable = ['nama', 'dusun'];

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class);
    }
}
