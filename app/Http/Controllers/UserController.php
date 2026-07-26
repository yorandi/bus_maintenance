<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => ['required', Rule::in(['admin', 'manager', 'mechanic', 'sopir'])],
            'whatsapp_number' => 'nullable|string|max:50',
        ]);

        $validated['nama'] = $validated['name'];
        $validated['username'] = Str::slug($validated['name']) . '-' . Str::random(4);
        $validated['no_hp'] = $validated['whatsapp_number'] ?? null;
        $validated['status'] = $request->boolean('is_active');
        $validated['role_id'] = Role::query()->where('nama_role', match ($validated['role']) {
            'admin' => 'Admin',
            'manager' => 'Manager Teknik',
            'mechanic' => 'Mekanik',
            'sopir' => 'Sopir',
        })->value('id');

        unset($validated['name'], $validated['role'], $validated['whatsapp_number'], $validated['is_active']);

        User::create($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|confirmed|min:6',
            'role' => ['required', Rule::in(['admin', 'manager', 'mechanic', 'sopir'])],
            'whatsapp_number' => 'nullable|string|max:50',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        } else {
            unset($validated['password']);
        }

        $validated['nama'] = $validated['name'];
        $validated['no_hp'] = $validated['whatsapp_number'] ?? null;
        $validated['status'] = $request->boolean('is_active');
        $validated['role_id'] = Role::query()->where('nama_role', match ($validated['role']) {
            'admin' => 'Admin',
            'manager' => 'Manager Teknik',
            'mechanic' => 'Mekanik',
            'sopir' => 'Sopir',
        })->value('id');

        unset($validated['name'], $validated['role'], $validated['whatsapp_number'], $validated['is_active']);

        $user->update($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->getKey() === Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun yang sedang aktif.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus!');
    }
}
