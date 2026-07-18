<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSertifikatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sertifikatId = $this->route('sertifikat');

        return [
            'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat,' . $sertifikatId . '|string|max:255',
            'pemilik_id' => 'required|exists:pemiliks,id',
            'jenis_hak_id' => 'required|exists:jenis_hak_tanahs,id',
            'status_id' => 'required|exists:status_sertifikats,id',
            'desa_id' => 'required|exists:desas,id',
            'luas' => 'required|numeric|min:0',
            'alamat' => 'nullable|string',
        ];
    }
}
