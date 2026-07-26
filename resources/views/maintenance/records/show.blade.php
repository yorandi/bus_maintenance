@extends('layouts.app')

@section('title', 'Detail Pemeliharaan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-tools"></i>
            Detail Pemeliharaan - {{ $record->vehicle->registration_number }}
        </h2>
    </div>
    <div class="col-md-4 text-end">
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <a href="{{ route('records.edit', $record) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('records.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> Kembali
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Pemeliharaan
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Kendaraan</h6>
                        <p class="lead">{{ $record->vehicle->registration_number }}</p>
                        <small class="text-muted">{{ $record->vehicle->model }}</small>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Pemeliharaan</h6>
                        <p class="lead">{{ $record->maintenance_date->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Tipe Servis</h6>
                        <p>{{ $record->service_type }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Mekanik</h6>
                        <p>{{ $record->mechanic->name }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted">Deskripsi Pekerjaan</h6>
                        <p>{{ $record->description }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Biaya</h6>
                        <p class="lead text-success">Rp. {{ number_format($record->cost, 0, ',', '.') }}</p>
                    </div>
                    @if($record->odometer_reading)
                    <div class="col-md-6">
                        <h6 class="text-muted">Odometer</h6>
                        <p>{{ number_format($record->odometer_reading, 0, ',', '.') }} km</p>
                    </div>
                    @endif
                </div>

                @if($record->parts_used)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted">Parts/Suku Cadang yang Digunakan</h6>
                        <p>{{ $record->parts_used }}</p>
                    </div>
                </div>
                @endif

                @if($record->schedule_id)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted">Jadwal Servis Terkait</h6>
                        <p>
                            <a href="{{ route('schedules.show', $record->schedule) }}">
                                {{ $record->schedule->scheduled_date->format('d M Y') }} - {{ $record->schedule->service_type }}
                            </a>
                        </p>
                    </div>
                </div>
                @endif

                @if($record->notes)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted">Catatan Tambahan</h6>
                        <p>{{ $record->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock"></i> Waktu
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Dibuat Pada</h6>
                        <p>{{ $record->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Terakhir Diperbarui</h6>
                        <p>{{ $record->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-link"></i> Tindakan Cepat
            </div>
            <div class="card-body">
                <a href="{{ route('vehicles.show', $record->vehicle) }}" class="btn btn-sm btn-outline-info w-100 mb-2">
                    <i class="fas fa-car"></i> Lihat Kendaraan
                </a>
                <a href="{{ route('records.create') }}" class="btn btn-sm btn-outline-success w-100">
                    <i class="fas fa-plus"></i> Catat Pemeliharaan Baru
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
