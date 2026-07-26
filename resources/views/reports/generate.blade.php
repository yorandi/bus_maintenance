@extends('layouts.app')

@section('title', 'Laporan Pemeliharaan - Generate')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-file-alt"></i> Laporan Pemeliharaan</h2>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-bar"></i> Ringkasan Laporan
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="alert alert-info">
                    <h6>Total Pemeliharaan</h6>
                    <p class="display-6">{{ $totalRecords }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-success">
                    <h6>Total Biaya</h6>
                    <p class="display-6" style="font-size: 1.5rem;">Rp. {{ number_format($totalCost, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-warning">
                    <h6>Rata-rata Biaya</h6>
                    <p class="display-6" style="font-size: 1.5rem;">Rp. {{ number_format($averageCost, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <form action="{{ route('reports.export') }}" method="GET">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    <input type="hidden" name="vehicle_id" value="{{ request('vehicle_id') }}">
                    <input type="hidden" name="service_type" value="{{ request('service_type') }}">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Detail Laporan
    </div>
    <div class="card-body">
        @if($records->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>No. Polisi</th>
                            <th>Tipe Servis</th>
                            <th>Mekanik</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{ $record->maintenance_date->format('d M Y') }}</td>
                                <td>{{ $record->vehicle->model }}</td>
                                <td><strong>{{ $record->vehicle->registration_number }}</strong></td>
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
            <p class="text-muted text-center py-5">Tidak ada data pemeliharaan sesuai filter</p>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Filter
        </a>
    </div>
</div>
@endsection
