@extends('layouts.app')

@section('title', 'Catat Pemeliharaan')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-plus"></i> Catat Pemeliharaan Kendaraan</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Pencatatan Pemeliharaan
                </div>
                <div class="card-body">
                    <form action="{{ route('records.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select @error('vehicle_id') is-invalid @enderror" name="vehicle_id"
                                id="vehicle_id" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach ($vehicles as $vehicle)
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
                            <label for="schedule_id" class="form-label">Jadwal Servis Terkait (Opsional)</label>
                            <select class="form-select @error('schedule_id') is-invalid @enderror" name="schedule_id"
                                id="schedule_id">
                                <option value="">-- Tidak Ada --</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id }}"
                                        {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->vehicle->registration_number }} -
                                        {{ $schedule->scheduled_date->format('d M Y') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('schedule_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mechanic_id" class="form-label">Mekanik <span class="text-danger">*</span></label>
                            <select class="form-select @error('mechanic_id') is-invalid @enderror" name="mechanic_id"
                                id="mechanic_id" required>
                                <option value="">-- Pilih Mekanik --</option>
                                @foreach ($mechanics as $mechanic)
                                    <option value="{{ $mechanic->id }}"
                                        {{ old('mechanic_id') == $mechanic->id ? 'selected' : '' }}>
                                        {{ $mechanic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mechanic_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="maintenance_date" class="form-label">Tanggal Pemeliharaan <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('maintenance_date') is-invalid @enderror"
                                name="maintenance_date" id="maintenance_date"
                                value="{{ old('maintenance_date', today()->format('Y-m-d')) }}" required>
                            @error('maintenance_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="service_type" class="form-label">Tipe Servis <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('service_type') is-invalid @enderror"
                                name="service_type" id="service_type" value="{{ old('service_type') }}"
                                placeholder="Contoh: Ganti Oli, Servis Ringan, Perbaikan Rem" required>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                rows="3" placeholder="Jelaskan detail pekerjaan yang dilakukan..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cost" class="form-label">Biaya Servis (Rp) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" name="cost"
                                id="cost" value="{{ old('cost') }}" step="0.01" min="0" placeholder="0"
                                required>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parts_used" class="form-label">Suku Cadang/Parts yang Digunakan (Opsional)</label>
                            <input type="text" class="form-control @error('parts_used') is-invalid @enderror"
                                name="parts_used" id="parts_used" value="{{ old('parts_used') }}"
                                placeholder="Contoh: Kampas Rem, Bearing Depan">
                            @error('parts_used')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="odometer_reading" class="form-label">Pembacaan Odometer (Opsional)</label>
                            <input type="number" class="form-control @error('odometer_reading') is-invalid @enderror"
                                name="odometer_reading" id="odometer_reading" value="{{ old('odometer_reading') }}"
                                min="0" placeholder="Dalam km">
                            @error('odometer_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="2"
                                placeholder="Informasi tambahan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pencatatan
                            </button>
                            <a href="{{ route('records.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-info-circle"></i> Panduan Pengisian
                </div>
                <div class="card-body small">
                    <p><strong>* Wajib Diisi</strong></p>
                    <p>Form ini digunakan untuk mencatat setiap pemeliharaan/servis yang dilakukan pada kendaraan.</p>
                    <p>Data ini penting untuk tracking riwayat perawatan dan biaya operasional kendaraan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
