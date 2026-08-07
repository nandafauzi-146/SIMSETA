<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSertifikatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('status_nama')) {
            $this->merge([
                'status_nama' => ucfirst(strtolower(trim($this->input('status_nama')))),
            ]);
        }
    }

    public function rules(): array
    {
        $sertifikat = $this->route('sertifikat');

        return [
            // A. Informasi Tanah
            'kategori' => 'required|in:masyarakat,kas_desa',
            'nomor_sertifikat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sertifikats', 'nomor_sertifikat')
                    ->ignore($sertifikat)
                    ->whereNull('deleted_at'),
            ],
            'nib' => 'nullable|string|max:255',
            'jenis_hak_nama' => 'required|string|max:255',
            'luas' => 'required|numeric|min:0',
            'status_nama' => 'required|string|max:255',

            // B. Data Pemilik (Masyarakat)
            'nik' => 'nullable|string|max:16',
            'pemilik_nama' => 'required_if:kategori,masyarakat|nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat_pemilik' => 'nullable|string',

            // B. Data Pengelola (Kas Desa)
            'penanggung_jawab' => 'required_if:kategori,kas_desa|nullable|string|max:255',
            'jabatan' => 'required_if:kategori,kas_desa|nullable|string|max:255',
            'unit_pengelola' => 'required_if:kategori,kas_desa|nullable|string|max:255',

            // C. Lokasi Tanah
            'desa_id' => 'required|exists:desas,id',
            'rt_rw' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'blok' => 'nullable|string|max:255',
            'persil' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',

            // D. Data Fisik
            'penggunaan_tanah' => 'nullable|string|max:255',
        ];
    }
}
