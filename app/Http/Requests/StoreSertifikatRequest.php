<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSertifikatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pemilik_id' => 'nullable|exists:pemiliks,id',
            'jenis_hak_id' => 'nullable|exists:jenis_hak_tanahs,id',
            'status_id' => 'nullable|exists:status_sertifikats,id',
            'desa_id' => 'nullable|exists:desas,id',
            'items' => 'required|array|min:1',
            'items.*.nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat|string|max:255',
            'items.*.luas_tanah' => 'required|numeric|min:0',
            'items.*.tahun_perolehan' => 'nullable|digits:4|integer|min:1900|max:2099',
            'items.*.deskripsi' => 'nullable|string',
        ];
    }
}
