@extends('layouts.app')
@include('reports.partials.datatables')

@section('title', 'Detail Riwayat Armada')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-bus"></i> Detail Riwayat Armada {{ $armada->kode_armada }}</h2>
            <p class="text-muted mb-0">{{ $armada->nomor_polisi }} - {{ $armada->merk }} {{ $armada->tipe }}</p>
        </div>
        <button type="button" class="btn btn-secondary btn-sm no-print" onclick="window.print()"><i class="fas fa-print"></i>
            Print</button>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover datatable">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Deskripsi</th>
                        <th>Mekanik</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                        <tr>
                            <td>{{ $item->tanggal_servis->format('d/m/Y') }}</td>
                            <td>{{ $item->jenis_pemeliharaan }}</td>
                            <td>{{ $item->deskripsi_pekerjaan }}</td>
                            <td>{{ $item->mekanik?->name ?? '-' }}</td>
                            <td>@include('reports.partials.badges', ['value' => $item->status_pemeliharaan])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="no-print">{{ $riwayat->links() }}</div>
        </div>
    </div>
@endsection
