<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;

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

        $sertifikat = Sertifikat::with(['status', 'jenis_hak', 'desa'])
            ->where('nomor_sertifikat', 'like', "%{$q}%")
            ->orWhere('nib', $q)
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

        if (!$token || !$secret) {
            return true;
        }

        $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
        ]);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (!($result['success'] ?? false)) {
            return 'Verifikasi keamanan gagal. Silakan refresh halaman dan coba lagi.';
        }

        return true;
    }
}
