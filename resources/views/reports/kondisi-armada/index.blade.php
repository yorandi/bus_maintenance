@extends('layouts.app')
@include('reports.partials.datatables')

@section('title', 'Laporan Kondisi Armada')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-clipboard-check"></i> Laporan Kondisi Armada</h2>
            <p class="text-muted mb-0">Hasil pemeriksaan kondisi kendaraan</p>
        </div>
        @include('reports.partials.actions', [
            'excelUrl' => route('report.kondisi-armada.excel', request()->query()),
            'pdfUrl' => route('report.kondisi-armada.pdf', request()->query()),
        ])
    </div>

    <div class="card no-print">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4"><label class="form-label">Nomor Armada</label><input type="text" name="search"
                        value="{{ request('search') }}" class="form-control" placeholder="Cari nomor armada"></div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="">Semua Kondisi</option>
                        @foreach (['baik' => 'Baik', 'perlu_perbaikan' => 'Perlu Perbaikan', 'rusak' => 'Rusak'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('kondisi') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2"><button class="btn btn-primary"><i
                            class="fas fa-search"></i> Filter</button><a href="{{ route('report.kondisi-armada') }}"
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
                        <th>Kondisi Kendaraan</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Catatan Kerusakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kondisiArmadas as $item)
                        <tr>
                            <td><strong>{{ $item->armada->kode_armada }}</strong></td>
                            <td>@include('reports.partials.badges', ['value' => $item->kondisi])</td>
                            <td>{{ $item->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                            <td>{{ $item->catatan_kerusakan ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="no-print">{{ $kondisiArmadas->links() }}</div>
        </div>
    </div>
@endsection
