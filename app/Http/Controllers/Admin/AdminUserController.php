<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->withCount('events')->latest()->paginate(20);

        return view('admin.admin-users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $validated['role'] = 'admin';

        User::create($validated);

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function edit(User $adminUser)
    {
        abort_unless($adminUser->role === 'admin', 404);

        return view('admin.admin-users.edit', compact('adminUser'));
    }

    public function update(Request $request, User $adminUser)
    {
        abort_unless($adminUser->role === 'admin', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($adminUser->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $adminUser->update($validated);

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $adminUser)
    {
        abort_unless($adminUser->role === 'admin', 404);

        $adminUser->delete();

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
