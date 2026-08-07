<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanTanah;
use Illuminate\Http\Request;

class PenggunaanTanahController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', PenggunaanTanah::class);

        $query = PenggunaanTanah::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $items = $query->orderBy('nama', 'asc')->get();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $items
            ]);
        }

        return view('admin.penggunaan-tanah.index', compact('items'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', PenggunaanTanah::class);

        $request->validate([
            'nama' => 'required|string|max:255|unique:penggunaan_tanahs,nama',
        ], [
            'nama.required' => 'Nama penggunaan tanah wajib diisi.',
            'nama.unique' => 'Jenis penggunaan tanah ini sudah ada.',
        ]);

        $item = PenggunaanTanah::create([
            'nama' => trim($request->nama),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Opsi penggunaan tanah berhasil ditambahkan.',
                'data' => $item,
                'all' => PenggunaanTanah::orderBy('nama', 'asc')->get()
            ]);
        }

        return redirect()->back()->with('success', 'Opsi penggunaan tanah berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = PenggunaanTanah::findOrFail($id);
        $this->authorize('update', $item);

        $request->validate([
            'nama' => 'required|string|max:255|unique:penggunaan_tanahs,nama,' . $id,
        ], [
            'nama.required' => 'Nama penggunaan tanah wajib diisi.',
            'nama.unique' => 'Jenis penggunaan tanah ini sudah ada.',
        ]);

        $oldName = $item->nama;
        $item->update([
            'nama' => trim($request->nama),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Opsi penggunaan tanah berhasil diperbarui.',
                'data' => $item,
                'all' => PenggunaanTanah::orderBy('nama', 'asc')->get()
            ]);
        }

        return redirect()->back()->with('success', 'Opsi penggunaan tanah berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $item = PenggunaanTanah::findOrFail($id);
        $this->authorize('delete', $item);

        $item->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Opsi penggunaan tanah berhasil dihapus.',
                'all' => PenggunaanTanah::orderBy('nama', 'asc')->get()
            ]);
        }

        return redirect()->back()->with('success', 'Opsi penggunaan tanah berhasil dihapus.');
    }
}
