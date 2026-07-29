<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sertifikat_id
 * @property string $nama_file
 * @property string $jenis_file
 * @property string $path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Dokumen extends Model
{
    protected $fillable = ['sertifikat_id', 'nama_file', 'jenis_file', 'path'];

    public function sertifikat()
    {
        return $this->belongsTo(Sertifikat::class);
    }
}
