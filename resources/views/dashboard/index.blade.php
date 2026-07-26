@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-chart-line"></i> Dashboard</h2>
        <p class="text-muted">Selamat datang di Sistem Manajemen Pemeliharaan Armada Bus</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-number">{{ $vehicleStats['total'] }}</div>
            <div class="stat-label">Total Kendaraan</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card good">
            <div class="stat-number">{{ $vehicleStats['good'] }}</div>
            <div class="stat-label">Kendaraan Baik</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card maintenance">
            <div class="stat-number">{{ $vehicleStats['maintenance'] }}</div>
            <div class="stat-label">Dalam Servis</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card damaged">
            <div class="stat-number">{{ $vehicleStats['damaged'] }}</div>
            <div class="stat-label">Rusak</div>
        </div>
    </div>
</div>

<!-- Report Statistics Cards -->
<div class="row">
    @foreach([
        ['Total Armada', $vehicleStats['total'], 'primary', 'fa-bus'],
        ['Armada Aktif', $reportStats['aktif'], 'success', 'fa-check-circle'],
        ['Armada Servis', $reportStats['servis'], 'warning', 'fa-tools'],
        ['Tidak Beroperasi', $reportStats['tidak_beroperasi'], 'danger', 'fa-ban'],
        // ['Total Pemeliharaan', $reportStats['total_pemeliharaan'], 'info', 'fa-history'],
        // ['Servis Bulan Ini', $reportStats['servis_bulan_ini'], 'secondary', 'fa-calendar-check'],
        // ['Terlambat Servis', $reportStats['kendaraan_terlambat_servis'], 'danger', 'fa-exclamation-triangle'],
        // ['Kendaraan Rusak', $reportStats['kendaraan_rusak'], 'dark', 'fa-wrench'],
    ] as $item)
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-{{ $item[2] }} text-white rounded p-3">
                        <i class="fas {{ $item[3] }} fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ $item[0] }}</div>
                        <div class="h3 mb-0">{{ $item[1] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <!-- Financial Statistics -->
    {{-- <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-dollar-sign"></i> Statistik Biaya Pemeliharaan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Bulan Ini</h5>
                        <p class="display-6 text-success">Rp. {{ number_format($thisMonthCost, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Total (All Time)</h5>
                        <p class="display-6 text-info">Rp. {{ number_format($totalCost, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Maintenance by Type -->
    {{-- <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-tools"></i> Pemeliharaan Bulan Ini (Berdasarkan Tipe)
            </div>
            <div class="card-body">
                @if($maintenanceByType->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($maintenanceByType as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->service_type }}</span>
                                <span class="badge bg-info">{{ $item->count }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center py-4">Belum ada data pemeliharaan bulan ini</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Overdue Schedules -->
    <div class="col-md-6 mb-4">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-exclamation-triangle"></i> Jadwal Servis Terlambat
            </div>
            <div class="card-body">
                @if($overdueSchedules->count() > 0)
                    <div class="list-group">
                        @foreach($overdueSchedules as $schedule)
                            <a href="{{ route('schedules.show', $schedule) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $schedule->vehicle->registration_number }}</h6>
                                    <small class="text-danger">{{ $schedule->scheduled_date->format('d M Y') }}</small>
                                </div>
                                <p class="mb-1 small">{{ $schedule->service_type }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">Tidak ada jadwal yang terlambat</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Pending Schedules -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock"></i> Jadwal Servis Mendatang
            </div>
            <div class="card-body">
                @if($pendingSchedules->count() > 0)
                    <div class="list-group">
                        @foreach($pendingSchedules as $schedule)
                            <a href="{{ route('schedules.show', $schedule) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $schedule->vehicle->registration_number }}</h6>
                                    <small class="text-primary">{{ $schedule->scheduled_date->format('d M Y') }}</small>
                                </div>
                                <p class="mb-1 small">{{ $schedule->service_type }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">Tidak ada jadwal mendatang</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Maintenance Records -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> Riwayat Pemeliharaan Terbaru
            </div>
            <div class="card-body">
                @if($recentRecords->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kendaraan</th>
                                    <th>Tipe Servis</th>
                                    <th>Mekanik</th>
                                    <th>Biaya</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRecords as $record)
                                    <tr>
                                        <td>{{ $record->maintenance_date->format('d M Y') }}</td>
                                        <td>
                                            <strong>{{ $record->vehicle->registration_number }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $record->vehicle->model }}</small>
                                        </td>
                                        <td>{{ $record->service_type }}</td>
                                        <td>{{ $record->mechanic->name }}</td>
                                        <td><strong>Rp. {{ number_format($record->cost, 0, ',', '.') }}</strong></td>
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
                    <p class="text-muted text-center py-4">Belum ada riwayat pemeliharaan</p>
                @endif
            </div>
        </div>
    </div>
</div> --}}
@endsection
