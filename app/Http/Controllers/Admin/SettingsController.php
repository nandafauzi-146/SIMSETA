<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $desa = Desa::first();
        return view('admin.settings.index', compact('desa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'dusun' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $desa = Desa::first();
        if ($desa) {
            $desa->update(['nama' => $request->nama_desa, 'dusun' => $request->dusun]);
        }

        $settings = $request->except(['nama_desa', 'dusun', '_token', '_method']);
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
