<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function index(Request $request)
    {
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
        return view('admin.desa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dusun' => 'required|string|max:255',
        ]);

        Desa::create([
            'nama' => 'Tegalmulyo',
            'dusun' => $validated['dusun'],
        ]);

        return redirect()->route('admin.desa.index')
            ->with('success', 'Desa berhasil ditambahkan.');
    }

    public function edit(Desa $desa)
    {
        return view('admin.desa.edit', compact('desa'));
    }

    public function update(Request $request, Desa $desa)
    {
        $validated = $request->validate([
            'dusun' => 'required|string|max:255',
        ]);

        $desa->update([
            'nama' => 'Tegalmulyo',
            'dusun' => $validated['dusun'],
        ]);

        return redirect()->route('admin.desa.index')
            ->with('success', 'Desa berhasil diperbarui.');
    }

    public function destroy(Desa $desa)
    {
        $desa->delete();

        return redirect()->route('admin.desa.index')
            ->with('success', 'Desa berhasil dihapus.');
    }
}
