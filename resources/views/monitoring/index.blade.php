@extends('layouts.app')

@section('title', 'Monitoring Bus')

@section('extra-css')
<style>
    .monitoring-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .monitoring-header .page-title {
        margin-bottom: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .search-bar {
        width: 100%;
        max-width: 420px;
    }

    .search-bar .form-control {
        border-radius: 0.75rem;
        border: 1px solid #ced4da;
    }

    .monitoring-summary .card {
        border-radius: 0.75rem;
        box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.08);
    }

    .vehicle-card {
        min-height: 230px;
        border-radius: 1rem;
        border: 1px solid #eaeaea;
    }

    .vehicle-card .card-body {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .vehicle-status {
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        text-transform: uppercase;
    }

    .vehicle-status.ready {
        background: #e9f7ef;
        color: #2f7a4f;
    }

    .vehicle-status.service {
        background: #fff4e5;
        color: #b56b00;
    }

    .vehicle-status.repair {
        background: #ffe7e7;
        color: #a62f2f;
    }

    .vehicle-status.damaged {
        background: #fbe6f0;
        color: #8f2c55;
    }

    @media (max-width: 768px) {
        .monitoring-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-bar {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="monitoring-header">
            <div>
                <h2 class="page-title">Monitoring Kondisi Bus</h2>
                <p class="text-muted mb-0">Pantau kondisi armada bus dengan cepat.</p>
            </div>
            <form action="{{ route('monitoring.index') }}" method="GET" class="search-bar">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari nomor polisi atau jenis bus..." value="{{ $search }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row monitoring-summary mb-4">
    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center">
            <h5 class="mb-1">Siap Operasi</h5>
            <p class="h3 mb-0">{{ $stats['ready'] }}</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center">
            <h5 class="mb-1">Jadwal Servis</h5>
            <p class="h3 mb-0">{{ $stats['service'] }}</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center">
            <h5 class="mb-1">Dalam Perbaikan</h5>
            <p class="h3 mb-0">{{ $stats['repair'] }}</p>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
    @forelse($vehicles as $vehicle)
        @php
            $statusLabel = 'Siap Operasi';
            $statusClass = 'ready';

            if ($vehicle->status === 'maintenance') {
                $statusLabel = 'Dalam Perbaikan';
                $statusClass = 'repair';
            } elseif ($vehicle->status === 'damaged') {
                $statusLabel = 'Rusak';
                $statusClass = 'damaged';
            } elseif ($vehicle->active_schedules_count > 0) {
                $statusLabel = 'Jadwal Servis';
                $statusClass = 'service';
            }
        @endphp

        <div class="col">
            <div class="card vehicle-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">{{ $vehicle->registration_number }}</h5>
                            <p class="text-muted mb-0">{{ $vehicle->merk }} {{ $vehicle->model }}</p>
                        </div>
                        <span class="vehicle-status {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1"><strong>Tahun:</strong> {{ $vehicle->tahun_pembuatan }}</p>
                        <p class="mb-1"><strong>Kapasitas:</strong> {{ $vehicle->kapasitas_penumpang }} orang</p>
                    </div>

                    <div class="mt-auto">
                        <p class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($vehicle->notes, 80) }}</p>
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-outline-primary btn-sm">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card p-4 text-center">
                <h5>Tidak ada kendaraan yang sesuai pencarian</h5>
                <p class="text-muted mb-0">Silakan gunakan kata kunci lain atau kosongkan field pencarian.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection
