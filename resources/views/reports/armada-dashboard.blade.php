@extends('layouts.app')

@section('title', 'Dashboard Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-chart-pie"></i> Dashboard Laporan</h2>
        <p class="text-muted mb-0">Ringkasan pemeliharaan armada bus DAMRI</p>
    </div>
</div>

<div class="row">
    @foreach([
        ['Total Armada', $stats['total_armada'], 'primary', 'fa-bus'],
        ['Armada Aktif', $stats['armada_aktif'], 'success', 'fa-check-circle'],
        ['Armada Servis', $stats['armada_servis'], 'warning', 'fa-tools'],
        ['Tidak Beroperasi', $stats['armada_tidak_beroperasi'], 'danger', 'fa-ban'],
        ['Total Pemeliharaan', $stats['total_pemeliharaan'], 'info', 'fa-history'],
        ['Servis Bulan Ini', $stats['servis_bulan_ini'], 'secondary', 'fa-calendar-check'],
        ['Terlambat Servis', $stats['kendaraan_terlambat_servis'], 'danger', 'fa-exclamation-triangle'],
        ['Kendaraan Rusak', $stats['kendaraan_rusak'], 'dark', 'fa-wrench'],
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

<div class="card">
    <div class="card-header"><i class="fas fa-file-alt"></i> Menu Laporan</div>
    <div class="card-body">
        <div class="row g-3">
            @foreach([
                ['Data Armada', route('report.armada'), 'fa-bus'],
                ['Jadwal Servis', route('report.jadwal-servis'), 'fa-calendar-alt'],
                ['Riwayat Pemeliharaan', route('report.riwayat-pemeliharaan'), 'fa-history'],
                ['Keterlambatan Servis', route('report.keterlambatan-servis'), 'fa-exclamation-triangle'],
                ['Kondisi Armada', route('report.kondisi-armada'), 'fa-clipboard-check'],
            ] as $menu)
                <div class="col-md-4">
                    <a href="{{ $menu[1] }}" class="btn btn-outline-primary w-100 text-start p-3">
                        <i class="fas {{ $menu[2] }} me-2"></i> {{ $menu[0] }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
