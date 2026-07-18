<?php

namespace App\Models;

use App\Models\Sertifikat;
use Illuminate\Database\Eloquent\Model;

class StatusSertifikat extends Model
{
    protected $fillable = ['nama'];

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class, 'status_id');
    }
}
