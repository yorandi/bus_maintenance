@extends('layouts.app')
@include('reports.partials.datatables')

@section('title', 'Laporan Data Armada')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-bus"></i> Laporan Data Armada</h2>
            <p class="text-muted mb-0">Data utama armada bus DAMRI</p>
        </div>
        @include('reports.partials.actions', [
            'excelUrl' => route('report.armada.excel', request()->query()),
            'pdfUrl' => route('report.armada.pdf', request()->query()),
        ])
    </div>

    <div class="row">
        @foreach ([['Total Armada', $summary['total'], 'primary'], ['Armada Aktif', $summary['aktif'], 'success'], ['Armada Servis', $summary['servis'], 'warning'], ['Tidak Beroperasi', $summary['tidak_beroperasi'], 'danger']] as $item)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">{{ $item[0] }}</div>
                        <div class="h3 text-{{ $item[2] }}">{{ $item[1] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card no-print">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Nomor Armada</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari nomor armada">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status Armada</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach (['aktif' => 'Aktif', 'servis' => 'Servis', 'tidak_beroperasi' => 'Tidak Beroperasi'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('report.armada') }}" class="btn btn-light">Reset</a>
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
                        <th>Merk</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Kapasitas</th>
                        <th>Status Armada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($armadas as $armada)
                        <tr>
                            <td><strong>{{ $armada->kode_armada }}</strong></td>
                            <td>{{ $armada->nomor_polisi }}</td>
                            <td>{{ $armada->merk }}</td>
                            <td>{{ $armada->tipe }}</td>
                            <td>{{ $armada->tahun }}</td>
                            <td>{{ $armada->kapasitas }}</td>
                            <td>@include('reports.partials.badges', ['value' => $armada->status_armada])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="no-print">{{ $armadas->links() }}</div>
        </div>
    </div>
@endsection
