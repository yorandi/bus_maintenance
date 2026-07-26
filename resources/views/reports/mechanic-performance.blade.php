@extends('layouts.app')

@section('title', 'Laporan - Performa Mekanik')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-user-wrench"></i> Laporan Performa Mekanik</h2>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Performa Mekanik
    </div>
    <div class="card-body">
        @if($mechanics->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Mekanik</th>
                            <th>Total Pemeliharaan</th>
                            <th>Total Biaya</th>
                            <th>Rata-rata Biaya per Servis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mechanics as $mechanic)
                            <tr>
                                <td><strong>{{ $mechanic['name'] }}</strong></td>
                                <td><span class="badge bg-info">{{ $mechanic['total_maintenance'] }}</span></td>
                                <td><strong>Rp. {{ number_format($mechanic['total_cost'], 0, ',', '.') }}</strong></td>
                                <td>Rp. {{ number_format($mechanic['average_cost'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center py-5">Belum ada data mekanik</p>
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
