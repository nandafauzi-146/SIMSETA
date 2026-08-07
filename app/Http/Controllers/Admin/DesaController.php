<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Desa::class);

        $query = Desa::query();

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where('nama', 'like', "%$search%")
                ->orWhere('dusun', 'like', "%$search%");
        }

        $desas = $query->paginate(15);

        return view('admin.desa.index', compact('desas'));
    }

    public function create()
    {
        $this->authorize('create', Desa::class);

        return view('admin.desa.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Desa::class);

        $validated = $request->validate([
            'dusun' => 'required|string|max:255',
        ]);

        Desa::create([
            'nama' => 'Tegalmulyo',
            'dusun' => $validated['dusun'],
        ]);

        return redirect()->route('admin.desa.index')
            ->with('success', 'Dukuh berhasil ditambahkan.');
    }

    public function edit(Desa $desa)
    {
        $this->authorize('update', $desa);

        return view('admin.desa.edit', compact('desa'));
    }

    public function update(Request $request, Desa $desa)
    {
        $this->authorize('update', $desa);

        $validated = $request->validate([
            'dusun' => 'required|string|max:255',
        ]);

        $desa->update([
            'nama' => 'Tegalmulyo',
            'dusun' => $validated['dusun'],
        ]);

        return redirect()->route('admin.desa.index')
            ->with('success', 'Dukuh berhasil diperbarui.');
    }

    public function destroy(Desa $desa)
    {
        $this->authorize('delete', $desa);

        if ($desa->sertifikats()->exists()) {
            return redirect()->route('admin.desa.index')
                ->with('error', 'Dukuh tidak dapat dihapus karena masih memiliki data aset tanah. Pindahkan atau hapus asetnya terlebih dahulu.');
        }

        $desa->delete();

        return redirect()->route('admin.desa.index')
            ->with('success', 'Dukuh berhasil dihapus.');
    }
}
