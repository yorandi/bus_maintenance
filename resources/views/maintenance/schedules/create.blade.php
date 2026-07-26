@extends('layouts.app')

@section('title', 'Buat Jadwal Servis')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-calendar-alt"></i> Buat Jadwal Servis Baru</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-form"></i> Form Input Jadwal Servis
            </div>
            <div class="card-body">
                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select @error('vehicle_id') is-invalid @enderror"
                                name="vehicle_id" id="vehicle_id" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                        {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->registration_number }} - {{ $vehicle->model }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="service_type" class="form-label">Tipe Servis <span class="text-danger">*</span></label>
                        <select class="form-select @error('service_type') is-invalid @enderror"
                                name="service_type" id="service_type" required>
                            <option value="">-- Pilih Tipe Servis --</option>
                            <option value="Rutin" {{ old('service_type') == 'Rutin' ? 'selected' : '' }}>Servis Rutin</option>
                            <option value="Berkala" {{ old('service_type') == 'Berkala' ? 'selected' : '' }}>Servis Berkala</option>
                            <option value="Perbaikan" {{ old('service_type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan/Penyesuaian</option>
                        </select>
                        @error('service_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="scheduled_date" class="form-label">Tanggal Jadwal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('scheduled_date') is-invalid @enderror"
                               name="scheduled_date" id="scheduled_date"
                               value="{{ old('scheduled_date') }}" required>
                        @error('scheduled_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" id="description" rows="3"
                                  placeholder="Jelaskan alasan atau detail servis...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="assigned_mechanic" class="form-label">Mekanik yang Ditugaskan (Opsional)</label>
                        <input type="text" class="form-control @error('assigned_mechanic') is-invalid @enderror"
                               name="assigned_mechanic" id="assigned_mechanic"
                               value="{{ old('assigned_mechanic') }}"
                               placeholder="Nama mekanik yang ditugaskan">
                        @error('assigned_mechanic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
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
                <i class="fas fa-info-circle"></i> Panduan
            </div>
            <div class="card-body small">
                <p><strong>* Wajib Diisi</strong></p>
                <p><strong>Tipe Servis:</strong></p>
                <ul>
                    <li><strong>Rutin:</strong> Servis Regular harian/mingguan</li>
                    <li><strong>Berkala:</strong> Servis berkala terencana</li>
                    <li><strong>Perbaikan:</strong> Perbaikan kerusakan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
