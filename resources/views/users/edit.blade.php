@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Pengguna</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Ulangi password baru jika ada">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" {{ old('role', $user->role_label) === 'Admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="manager"
                                {{ old('role', $user->role_label) === 'Manager Teknik' ? 'selected' : '' }}>Manager</option>
                            <option value="mechanic" {{ old('role', $user->role_label) === 'Mekanik' ? 'selected' : '' }}>
                                Mechanic</option>
                            <option value="sopir" {{ old('role', $user->role_label) === 'Sopir' ? 'selected' : '' }}>Sopir
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp_number" class="form-control"
                            value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                            placeholder="Contoh: +6281234567890">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktifkan pengguna</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Perbarui</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
