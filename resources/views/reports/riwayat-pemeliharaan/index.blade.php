@extends('layouts.app')
@include('reports.partials.datatables')

@section('title', 'Laporan Riwayat Pemeliharaan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-history"></i> Laporan Riwayat Pemeliharaan</h2>
            <p class="text-muted mb-0">Aktivitas pemeliharaan kendaraan</p>
        </div>
        @include('reports.partials.actions', [
            'excelUrl' => route('report.riwayat-pemeliharaan.excel', request()->query()),
            'pdfUrl' => route('report.riwayat-pemeliharaan.pdf', request()->query()),
        ])
    </div>

    <div class="card no-print">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" name="tanggal"
                        value="{{ request('tanggal') }}" class="form-control"></div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Pemeliharaan</label>
                    <select name="jenis_pemeliharaan" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisPemeliharaan as $jenis)
                            <option value="{{ $jenis }}" @selected(request('jenis_pemeliharaan') === $jenis)>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach (['selesai' => 'Selesai', 'dalam_proses' => 'Dalam Proses', 'ditunda' => 'Ditunda'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2"><button class="btn btn-primary"><i
                            class="fas fa-search"></i> Filter</button><a href="{{ route('report.riwayat-pemeliharaan') }}"
                        class="btn btn-light">Reset</a></div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover datatable align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Armada</th>
                        <th>Tanggal Pemeliharaan</th>
                        <th>Jenis Pemeliharaan</th>
                        <th>Deskripsi</th>
                        <th>Mekanik</th>
                        <th>Status Pekerjaan</th>
                        <th class="no-print">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                        <tr>
                            <td><strong>{{ $item->armada->kode_armada }}</strong></td>
                            <td>{{ $item->tanggal_servis->format('d/m/Y') }}</td>
                            <td>{{ $item->jenis_pemeliharaan }}</td>
                            <td>{{ $item->deskripsi_pekerjaan }}</td>
                            <td>{{ $item->mekanik?->name ?? '-' }}</td>
                            <td>@include('reports.partials.badges', ['value' => $item->status_pemeliharaan])</td>
                            <td class="no-print"><a href="{{ route('report.riwayat-pemeliharaan.detail', $item->armada) }}"
                                    class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="no-print">{{ $riwayat->links() }}</div>
        </div>
    </div>
@endsection
