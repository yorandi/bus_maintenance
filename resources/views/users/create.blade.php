@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tambah Pengguna Baru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">Pilih role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="mechanic" {{ old('role') === 'mechanic' ? 'selected' : '' }}>Mechanic</option>
                            <option value="sopir" {{ old('role') === 'sopir' ? 'selected' : '' }}>Sopir</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp_number" class="form-control"
                            value="{{ old('whatsapp_number') }}" placeholder="Contoh: +6281234567890">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktifkan pengguna</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
