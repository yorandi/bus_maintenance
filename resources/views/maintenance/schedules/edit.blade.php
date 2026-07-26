@extends('layouts.app')

@section('title', 'Edit Jadwal Servis')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-calendar-alt"></i> Edit Jadwal Servis</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-form"></i> Form Edit Jadwal Servis
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select @error('vehicle_id') is-invalid @enderror" name="vehicle_id"
                                id="vehicle_id" required>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                        {{ old('vehicle_id', $schedule->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->registration_number }} - {{ $vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="service_type" class="form-label">Tipe Servis <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('service_type') is-invalid @enderror" name="service_type"
                                id="service_type" required>
                                <option value="Rutin"
                                    {{ old('service_type', $schedule->service_type) == 'Rutin' ? 'selected' : '' }}>Servis
                                    Rutin</option>
                                <option value="Berkala"
                                    {{ old('service_type', $schedule->service_type) == 'Berkala' ? 'selected' : '' }}>Servis
                                    Berkala</option>
                                <option value="Perbaikan"
                                    {{ old('service_type', $schedule->service_type) == 'Perbaikan' ? 'selected' : '' }}>
                                    Perbaikan/Penyesuaian</option>
                            </select>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="scheduled_date" class="form-label">Tanggal Jadwal <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('scheduled_date') is-invalid @enderror"
                                name="scheduled_date" id="scheduled_date"
                                value="{{ old('scheduled_date', optional($schedule->scheduled_date)->format('Y-m-d')) }}"
                                required>
                            @error('scheduled_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status"
                                required>
                                <option value="pending"
                                    {{ old('status', $schedule->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress"
                                    {{ old('status', $schedule->status) == 'in_progress' ? 'selected' : '' }}>Proses
                                </option>
                                <option value="completed"
                                    {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="cancelled"
                                    {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                rows="3">{{ old('description', $schedule->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_mechanic" class="form-label">Mekanik yang Ditugaskan (Opsional)</label>
                            <input type="text" class="form-control @error('assigned_mechanic') is-invalid @enderror"
                                name="assigned_mechanic" id="assigned_mechanic"
                                value="{{ old('assigned_mechanic', $schedule->assigned_mechanic) }}">
                            @error('assigned_mechanic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui Jadwal
                            </button>
                            <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
