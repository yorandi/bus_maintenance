<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp' => 'required|string|max:20',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'role' => $request->role,
            'password' => $request->password, // Otomatis ter-hash oleh Model
            'status' => 1,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }
}
