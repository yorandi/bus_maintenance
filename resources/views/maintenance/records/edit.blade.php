@extends('layouts.app')

@section('title', 'Edit Pemeliharaan')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-edit"></i> Edit Catatan Pemeliharaan</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Edit Pemeliharaan
                </div>
                <div class="card-body">
                    <form action="{{ route('records.update', $record) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select @error('vehicle_id') is-invalid @enderror" name="vehicle_id"
                                id="vehicle_id" required>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                        {{ old('vehicle_id', $record->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->registration_number }} - {{ $vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mechanic_id" class="form-label">Mekanik <span class="text-danger">*</span></label>
                            <select class="form-select @error('mechanic_id') is-invalid @enderror" name="mechanic_id"
                                id="mechanic_id" required>
                                @foreach ($mechanics as $mechanic)
                                    <option value="{{ $mechanic->id }}"
                                        {{ old('mechanic_id', $record->mechanic_id) == $mechanic->id ? 'selected' : '' }}>
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
                                value="{{ old('maintenance_date', optional($record->maintenance_date)->format('Y-m-d')) }}"
                                required>
                            @error('maintenance_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="service_type" class="form-label">Tipe Servis <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('service_type') is-invalid @enderror"
                                name="service_type" id="service_type"
                                value="{{ old('service_type', $record->service_type) }}" required>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                rows="3" required>{{ old('description', $record->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cost" class="form-label">Biaya Servis (Rp) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" name="cost"
                                id="cost" value="{{ old('cost', $record->cost) }}" step="0.01" min="0"
                                required>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parts_used" class="form-label">Suku Cadang/Parts (Opsional)</label>
                            <input type="text" class="form-control @error('parts_used') is-invalid @enderror"
                                name="parts_used" id="parts_used" value="{{ old('parts_used', $record->parts_used) }}">
                            @error('parts_used')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="odometer_reading" class="form-label">Pembacaan Odometer (Opsional)</label>
                            <input type="number" class="form-control @error('odometer_reading') is-invalid @enderror"
                                name="odometer_reading" id="odometer_reading"
                                value="{{ old('odometer_reading', $record->odometer_reading) }}" min="0">
                            @error('odometer_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="2">{{ old('notes', $record->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui Catatan
                            </button>
                            <a href="{{ route('records.show', $record) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
