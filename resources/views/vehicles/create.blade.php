@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-car"></i> Tambah Kendaraan Baru</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-form"></i> Form Input Kendaraan
            </div>
            <div class="card-body">
                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="registration_number" class="form-label">Nomor Polisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                               name="registration_number" id="registration_number"
                               value="{{ old('registration_number') }}"
                               placeholder="Contoh: B 1234 CD" required>
                        @error('registration_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nomor_rangka" class="form-label">Nomor Rangka (Chassis) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nomor_rangka') is-invalid @enderror"
                               name="nomor_rangka" id="nomor_rangka"
                               value="{{ old('nomor_rangka') }}"
                               placeholder="Nomor identitas unik kendaraan" required>
                        @error('nomor_rangka')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('merk') is-invalid @enderror"
                                   name="merk" id="merk"
                                   value="{{ old('merk') }}"
                                   placeholder="Contoh: Isuzu, Hino" required>
                            @error('merk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror"
                                   name="model" id="model"
                                   value="{{ old('model') }}"
                                   placeholder="Contoh: ELF, HB-100" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                                   name="tahun_pembuatan" id="tahun_pembuatan"
                                   value="{{ old('tahun_pembuatan') }}"
                                   min="1900" max="{{ now()->year }}" required>
                            @error('tahun_pembuatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kapasitas_penumpang" class="form-label">Kapasitas Penumpang <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('kapasitas_penumpang') is-invalid @enderror"
                                   name="kapasitas_penumpang" id="kapasitas_penumpang"
                                   value="{{ old('kapasitas_penumpang') }}"
                                   min="1" required>
                            @error('kapasitas_penumpang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="date_operation_started" class="form-label">Tanggal Mulai Operasi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_operation_started') is-invalid @enderror"
                               name="date_operation_started" id="date_operation_started"
                               value="{{ old('date_operation_started') }}" required>
                        @error('date_operation_started')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  name="notes" id="notes" rows="3"
                                  placeholder="Catatan tambahan tentang kendaraan...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Kendaraan
                        </button>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header bg-info text-white">
                <i class="fas fa-info-circle"></i> Informasi
            </div>
            <div class="card-body">
                <p class="small"><strong>* Wajib Diisi</strong></p>
                <p class="small">Pastikan semua data kendaraan terisi dengan benar. Nomor polisi dan nomor rangka harus unik.</p>
                <p class="small">Data ini akan digunakan sebagai referensi untuk jadwal dan riwayat pemeliharaan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
