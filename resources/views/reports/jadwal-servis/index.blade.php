@extends('layouts.app')
@include('reports.partials.datatables')

@section('title', 'Laporan Jadwal Servis')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-calendar-alt"></i> Laporan Jadwal Servis</h2>
            <p class="text-muted mb-0">Monitoring jadwal servis berkala armada</p>
        </div>
        @include('reports.partials.actions', [
            'excelUrl' => route('report.jadwal-servis.excel', request()->query()),
            'pdfUrl' => route('report.jadwal-servis.pdf', request()->query()),
        ])
    </div>

    <div class="card no-print">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach (['tepat_waktu' => 'Tepat Waktu', 'mendekati_jatuh_tempo' => 'Mendekati Jatuh Tempo', 'terlambat' => 'Terlambat'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Servis Berikutnya</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('report.jadwal-servis') }}" class="btn btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover datatable align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Armada</th>
                        <th>Nomor Polisi</th>
                        <th>Servis Terakhir</th>
                        <th>Jadwal Servis Berikutnya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwalServis as $jadwal)
                        <tr>
                            <td><strong>{{ $jadwal->armada->kode_armada }}</strong></td>
                            <td>{{ $jadwal->armada->nomor_polisi }}</td>
                            <td>{{ $jadwal->tanggal_servis_terakhir?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $jadwal->jadwal_servis_berikutnya->format('d/m/Y') }}</td>
                            <td>@include('reports.partials.badges', ['value' => $jadwal->status_servis])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="no-print">{{ $jadwalServis->links() }}</div>
        </div>
    </div>
@endsection
