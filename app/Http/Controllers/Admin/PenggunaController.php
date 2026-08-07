<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenggunaRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;

class PenggunaController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $query->paginate(15);

        return view('admin.pengguna.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $roles = Cache::remember('roles_all', 3600, function () {
            return Role::all()->toArray();
        });
        $roles = collect($roles)->map(fn($r) => (object) $r);
        return view('admin.pengguna.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StorePenggunaRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $pengguna)
    {
        $this->authorize('view', $pengguna);

        $user = $pengguna;
        return view('admin.pengguna.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $pengguna)
    {
        $this->authorize('update', $pengguna);

        $user = $pengguna;
        $roles = Cache::remember('roles_all', 3600, function () {
            return Role::all()->toArray();
        });
        $roles = collect($roles)->map(fn($r) => (object) $r);
        return view('admin.pengguna.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $pengguna)
    {
        $this->authorize('update', $pengguna);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pengguna->id . '|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
        ]);

        $pengguna->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if ($validated['password']) {
            $pengguna->update(['password' => Hash::make($validated['password'])]);
        }

        $pengguna->syncRoles([$validated['role']]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $pengguna)
    {
        $this->authorize('delete', $pengguna);

        if (auth()->id() === $pengguna->id) {
            return redirect()->route('admin.pengguna.index')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
