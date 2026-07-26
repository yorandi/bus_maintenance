@extends('layouts.app')
@include('reports.partials.datatables')

@section('title', 'Laporan Keterlambatan Servis')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-exclamation-triangle"></i> Laporan Kendaraan Terlambat Servis</h2>
            <p class="text-muted mb-0">Kendaraan dengan jadwal servis melewati hari ini</p>
        </div>
        @include('reports.partials.actions', [
            'excelUrl' => route('report.keterlambatan-servis.excel'),
            'pdfUrl' => route('report.keterlambatan-servis.pdf'),
        ])
    </div>

    <div class="card border-danger">
        <div class="card-body table-responsive">
            <table class="table table-hover datatable align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Armada</th>
                        <th>Nomor Polisi</th>
                        <th>Jadwal Servis</th>
                        <th>Hari Ini</th>
                        <th>Selisih Keterlambatan</th>
                        <th>Status Armada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keterlambatan as $item)
                        <tr>
                            <td><strong>{{ $item->armada->kode_armada }}</strong></td>
                            <td>{{ $item->armada->nomor_polisi }}</td>
                            <td>{{ optional($item->jadwal_servis_berikutnya)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ now()->format('d/m/Y') }}</td>
                            <td><span class="badge bg-danger">{{ $item->keterlambatan_hari ?? 0 }} hari</span></td>
                            <td>@include('reports.partials.badges', ['value' => $item->armada->status_armada])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="no-print">@include('partials.pagination', ['paginator' => $keterlambatan])</div>
        </div>
    </div>
@endsection
