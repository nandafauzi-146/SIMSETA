<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PublicSearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $turnstileValid = $this->validateTurnstile($request);
        if ($turnstileValid !== true) {
            return response()->json(['success' => false, 'message' => $turnstileValid], 422);
        }

        $q = $request->input('keyword');

        // Normalisasi: ekstrak digit saja agar cocok dengan NIB berformat "12.01.02.03.04567"
        // meskipun user mengetik angka tanpa titik.
        $digits = preg_replace('/[^0-9]/', '', $q);

        $sertifikat = Sertifikat::with(['status', 'jenis_hak', 'desa'])
            ->where(function ($query) use ($q, $digits) {
                $query->where('nomor_sertifikat', $q)            // Exact match
                      ->orWhere('nomor_sertifikat', 'like', "{$q}%")   // Prefix match (index-friendly)
                      ->orWhere('nomor_sertifikat', 'like', "%{$q}%")  // Fallback full wildcard
                      ->orWhere('nib', $q)
                      ->orWhere('nib', 'like', "%{$q}%");

                if (strlen($digits) >= 6) {
                    $query->orWhereRaw(
                        "REPLACE(REPLACE(REPLACE(nib, '.', ''), '-', ''), ' ', '') = ?",
                        [$digits]
                    );
                }
            })
            ->first();

        if (!$sertifikat) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Prepare minimal public response
        $data = [
            'nomor_sertifikat' => $sertifikat->nomor_sertifikat,
            'nib' => $sertifikat->nib,
            'jenis_hak' => $sertifikat->jenis_hak->nama ?? null,
            'luas' => $sertifikat->luas,
            'status' => $sertifikat->status->nama ?? null,
            'desa' => $sertifikat->desa->nama ?? null,
            'dusun' => $sertifikat->desa->dusun ?? null,
            'alamat' => $sertifikat->alamat,
        ];

        return response()->json(['success' => true, 'sertifikat' => $data]);
    }

    private function validateTurnstile(Request $request): true|string
    {
        $token = $request->input('cf-turnstile-response');
        $secret = config('services.turnstile.secret_key');

        if (!$secret) {
            return 'Verifikasi keamanan belum dikonfigurasi. Silakan hubungi administrator.';
        }

        if (!$token) {
            return 'Verifikasi keamanan belum selesai. Selesaikan verifikasi Cloudflare terlebih dahulu.';
        }

        $response = Http::timeout(5)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        if ($response->failed() || ! ($response->json('success') ?? false)) {
            return 'Verifikasi keamanan gagal. Silakan refresh halaman dan coba lagi.';
        }

        return true;
    }
}
