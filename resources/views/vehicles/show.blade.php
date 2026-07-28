@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-car"></i>
            {{ $vehicle->registration_number }} - {{ $vehicle->model }}
        </h2>
        <p class="text-muted">Detail informasi kendaraan</p>
    </div>
    <div class="col-md-4 text-end">
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> Kembali
        </a>
        @endif
    </div>
</div>

<div class="row">
    <!-- Vehicle Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Kendaraan
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Nomor Polisi</h6>
                        <p class="lead">{{ $vehicle->registration_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Nomor Rangka</h6>
                        <p class="lead">{{ $vehicle->nomor_rangka }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Merk</h6>
                        <p>{{ $vehicle->merk }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Model</h6>
                        <p>{{ $vehicle->model }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Tahun Pembuatan</h6>
                        <p>{{ $vehicle->tahun_pembuatan }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Kapasitas Penumpang</h6>
                        <p>{{ $vehicle->kapasitas_penumpang }} Penumpang</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Mulai Operasi</h6>
                        <p>{{ $vehicle->date_operation_started->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Status</h6>
                        <p>
                            @if($vehicle->status == 'good')
                                <span class="badge bg-success" style="font-size: 0.95rem;">Baik</span>
                            @elseif($vehicle->status == 'maintenance')
                                <span class="badge bg-warning text-dark" style="font-size: 0.95rem;">Dalam Servis</span>
                            @elseif($vehicle->status == 'damaged')
                                <span class="badge bg-danger" style="font-size: 0.95rem;">Rusak</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.95rem;">Tidak Beroperasi</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($vehicle->notes)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted">Catatan</h6>
                        <p>{{ $vehicle->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Maintenance Schedules -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-alt"></i> Jadwal Servis
            </div>
            <div class="card-body">
                @if($vehicle->schedules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe Servis</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicle->schedules->sortByDesc('scheduled_date') as $schedule)
                                    <tr>
                                        <td>{{ $schedule->scheduled_date->format('d M Y') }}</td>
                                        <td>{{ $schedule->service_type }}</td>
                                        <td>
                                            @if($schedule->status == 'pending')
                                                <span class="badge bg-secondary">Pending</span>
                                            @elseif($schedule->status == 'in_progress')
                                                <span class="badge bg-warning text-dark">Proses</span>
                                            @elseif($schedule->status == 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">Belum ada jadwal servis</p>
                @endif
            </div>
        </div>

        <!-- Maintenance Records -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> Riwayat Pemeliharaan
            </div>
            <div class="card-body">
                @if($vehicle->records->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe Servis</th>
                                    <th>Mekanik</th>
                                    <th>Biaya</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicle->records->sortByDesc('maintenance_date') as $record)
                                    <tr>
                                        <td>{{ $record->maintenance_date->format('d M Y') }}</td>
                                        <td>{{ $record->service_type }}</td>
                                        <td>{{ $record->mechanic->name }}</td>
                                        <td>Rp. {{ number_format($record->cost, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('records.show', $record) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">Belum ada riwayat pemeliharaan</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Side Panel -->
    <div class="col-md-4">
        <!-- Statistics -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-chart-bar"></i> Statistik
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted">Jadwal Servis</h6>
                    <p class="display-6">{{ $vehicle->schedules->count() }}</p>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted">Riwayat Pemeliharaan</h6>
                    <p class="display-6">{{ $vehicle->records->count() }}</p>
                </div>
                <div>
                    <h6 class="text-muted">Total Biaya Perawatan</h6>
                    <p class="display-6" style="font-size: 1.5rem;">
                        Rp. {{ number_format($vehicle->records->sum('cost'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-link"></i> Tindakan Cepat
            </div>
            <div class="card-body">
                <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                    <i class="fas fa-calendar-plus"></i> Buat Jadwal Servis
                </a>
                <a href="{{ route('records.create') }}" class="btn btn-sm btn-outline-success w-100 mb-2">
                    <i class="fas fa-plus"></i> Catat Pemeliharaan
                </a>
                <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-outline-warning w-100">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
