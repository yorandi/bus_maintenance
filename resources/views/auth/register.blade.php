@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="mechanic">Mekanik</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
