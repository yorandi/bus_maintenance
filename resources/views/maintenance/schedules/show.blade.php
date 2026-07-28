@extends('layouts.app')

@section('title', 'Detail Jadwal Servis')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <i class="fas fa-calendar-alt"></i>
                Jadwal Servis - {{ $schedule->vehicle->registration_number }}
            </h2>
        </div>
        <div class="col-md-4 text-end">
            @if (auth()->user()->isAdmin() || auth()->user()->isManager())
                <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Kembali
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi Jadwal Servis
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Kendaraan</h6>
                            <p class="lead">{{ $schedule->vehicle->registration_number }}</p>
                            <small class="text-muted">{{ $schedule->vehicle->model }}</small>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Tanggal Jadwal</h6>
                            <p class="lead">{{ $schedule->scheduled_date->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Tipe Servis</h6>
                            <p>{{ $schedule->service_type }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <p>
                                @if ($schedule->status == 'pending')
                                    <span class="badge bg-secondary" style="font-size: 0.95rem;">Pending</span>
                                @elseif($schedule->status == 'in_progress')
                                    <span class="badge bg-warning text-dark" style="font-size: 0.95rem;">Proses</span>
                                @elseif($schedule->status == 'completed')
                                    <span class="badge bg-success" style="font-size: 0.95rem;">Selesai</span>
                                @else
                                    <span class="badge bg-danger" style="font-size: 0.95rem;">Dibatalkan</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($schedule->description)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="text-muted">Deskripsi</h6>
                                <p>{{ $schedule->description }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($schedule->assigned_mechanic)
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Mekanik yang Ditugaskan</h6>
                                <p>{{ $schedule->assigned_mechanic }}</p>
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
                            <p>{{ $schedule->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Terakhir Diperbarui</h6>
                            <p>{{ $schedule->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if (auth()->user()->isAdmin() || auth()->user()->isManager())
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-link"></i> Tindakan Cepat
                    </div>
                    <div class="card-body">
                        <a href="{{ route('records.create') }}" class="btn btn-sm btn-outline-success w-100 mb-2">
                            <i class="fas fa-plus"></i> Catat Pemeliharaan
                        </a>
                        <a href="{{ route('vehicles.show', $schedule->vehicle) }}"
                            class="btn btn-sm btn-outline-info w-100">
                            <i class="fas fa-car"></i> Lihat Kendaraan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
