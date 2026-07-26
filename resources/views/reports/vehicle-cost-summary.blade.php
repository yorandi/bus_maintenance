@extends('layouts.app')

@section('title', 'Laporan - Biaya Kendaraan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-dollar-sign"></i> Ringkasan Biaya Pemeliharaan per Kendaraan</h2>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Biaya Pemeliharaan per Kendaraan
    </div>
    <div class="card-body">
        @if($vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Polisi</th>
                            <th>Model</th>
                            <th>Jumlah Pemeliharaan</th>
                            <th>Total Biaya</th>
                            <th>Rata-rata Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                            <tr>
                                <td><strong>{{ $vehicle['registration_number'] }}</strong></td>
                                <td>{{ $vehicle['model'] }}</td>
                                <td><span class="badge bg-info">{{ $vehicle['maintenance_count'] }}</span></td>
                                <td><strong>Rp. {{ number_format($vehicle['total_cost'], 0, ',', '.') }}</strong></td>
                                <td>Rp. {{ number_format($vehicle['total_cost'] / max($vehicle['maintenance_count'], 1), 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('vehicles.show', $vehicle['id']) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center py-5">Belum ada data pemeliharaan</p>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
