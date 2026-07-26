@extends('layouts.app')

@section('title', 'Laporan Pemeliharaan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-file-alt"></i> Laporan Pemeliharaan</h2>
        <p class="text-muted">Filter dan lihat laporan pemeliharaan kendaraan</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-filter"></i> Filter Laporan
            </div>
            <div class="card-body">
                <form action="{{ route('reports.generate') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="vehicle_id" class="form-label">Kendaraan</label>
                            <select class="form-select" name="vehicle_id" id="vehicle_id">
                                <option value="">-- Semua Kendaraan --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                            {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->registration_number }} - {{ $vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="service_type" class="form-label">Tipe Servis</label>
                            <input type="text" class="form-control" name="service_type" id="service_type"
                                   placeholder="Contoh: Ganti Oli" value="{{ request('service_type') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Generate Laporan
                            </button>
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset Filter
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Laporan Lengkap
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="alert alert-info">
                            <h6>Total Pemeliharaan</h6>
                            <p class="display-6">0</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="alert alert-success">
                            <h6>Total Biaya</h6>
                            <p class="display-6">Rp 0</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="alert alert-warning">
                            <h6>Rata-rata Biaya</h6>
                            <p class="display-6">Rp 0</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="exportReport()">
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                    </div>
                </div>

                <p class="text-muted text-center py-5">
                    <i class="fas fa-info-circle"></i>
                    Gunakan filter di atas untuk membuat laporan
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Reports -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-dollar-sign"></i> Ringkasan Biaya Kendaraan
            </div>
            <div class="card-body">
                <a href="{{ route('reports.vehicle-cost') }}" class="btn btn-outline-primary">
                    <i class="fas fa-chart-pie"></i> Lihat Laporan Biaya per Kendaraan
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-wrench"></i> Performa Mekanik
            </div>
            <div class="card-body">
                <a href="{{ route('reports.mechanic-performance') }}" class="btn btn-outline-primary">
                    <i class="fas fa-chart-bar"></i> Lihat Performa Mekanik
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function exportReport() {
    const params = new URLSearchParams(new FormData(document.querySelector('form'))).toString();
    window.location.href = '{{ route("reports.export") }}?' + params;
}
</script>
@endsection
