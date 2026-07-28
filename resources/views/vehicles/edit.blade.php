@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-car"></i> Edit Data Kendaraan</h2>
            <p class="text-muted">{{ $vehicle->registration_number }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Edit Kendaraan
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="registration_number" class="form-label">Nomor Polisi <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                name="registration_number" id="registration_number"
                                value="{{ old('registration_number', $vehicle->registration_number) }}" required>
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_rangka" class="form-label">Nomor Rangka (Chassis) <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_rangka') is-invalid @enderror"
                                name="nomor_rangka" id="nomor_rangka"
                                value="{{ old('nomor_rangka', $vehicle->nomor_rangka) }}" required>
                            @error('nomor_rangka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror"
                                    name="merk" id="merk" value="{{ old('merk', $vehicle->merk) }}" required>
                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror"
                                    name="model" id="model" value="{{ old('model', $vehicle->model) }}" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                                    name="tahun_pembuatan" id="tahun_pembuatan"
                                    value="{{ old('tahun_pembuatan', $vehicle->tahun_pembuatan) }}" required>
                                @error('tahun_pembuatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kapasitas_penumpang" class="form-label">Kapasitas Penumpang <span
                                        class="text-danger">*</span></label>
                                <input type="number"
                                    class="form-control @error('kapasitas_penumpang') is-invalid @enderror"
                                    name="kapasitas_penumpang" id="kapasitas_penumpang"
                                    value="{{ old('kapasitas_penumpang', $vehicle->kapasitas_penumpang) }}" required>
                                @error('kapasitas_penumpang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="date_operation_started" class="form-label">Tanggal Mulai Operasi <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_operation_started') is-invalid @enderror"
                                name="date_operation_started" id="date_operation_started"
                                value="{{ old('date_operation_started', optional($vehicle->date_operation_started)->format('Y-m-d')) }}"
                                required>
                            @error('date_operation_started')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status"
                                required>
                                <option value="">-- Pilih Status --</option>
                                <option value="good" {{ old('status', $vehicle->status) == 'good' ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="maintenance"
                                    {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>Dalam Servis
                                </option>
                                <option value="damaged"
                                    {{ old('status', $vehicle->status) == 'damaged' ? 'selected' : '' }}>Rusak</option>
                                <option value="inactive"
                                    {{ old('status', $vehicle->status) == 'inactive' ? 'selected' : '' }}>Tidak Beroperasi
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="3">{{ old('notes', $vehicle->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui Kendaraan
                            </button>
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-secondary">
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
                <div class="card-body small">
                    <p><strong>* Wajib Diisi</strong></p>
                    <p>Anda sedang mengedit data kendaraan <strong>{{ $vehicle->registration_number }}</strong>.</p>
                    <p>Pastikan semua perubahan data sudah benar sebelum menyimpan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
