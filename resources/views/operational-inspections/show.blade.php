@extends('layouts.app')

@section('title', 'Detail Pemeriksaan Operasional')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-clipboard-list"></i> Detail {{ $inspection->type_label }}</h2>
        <p class="text-muted">{{ $inspection->inspected_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('inspections.edit', $inspection) }}" class="btn btn-primary btn-sm me-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<div class="row g-4">
        <div class="col-lg-5 col-md-6">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-info-circle"></i> Ringkasan</div>
                <div class="card-body p-4">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 mb-2">Kendaraan</dt>
                        <dd class="col-sm-7 mb-2">{{ $inspection->vehicle->registration_number }} - {{ $inspection->vehicle->model }}</dd>
                        <dt class="col-sm-5 mb-2">Sopir</dt>
                        <dd class="col-sm-7 mb-2">{{ $inspection->driver->name }}</dd>
                        <dt class="col-sm-5 mb-2">Odometer</dt>
                        <dd class="col-sm-7 mb-2">{{ number_format($inspection->odometer, 0, ',', '.') }} km</dd>
                        <dt class="col-sm-5 mb-2">Hasil</dt>
                        <dd class="col-sm-7 mb-2">{{ $inspection->condition_label }}</dd>
                        <dt class="col-sm-5 mb-2">Catatan</dt>
                        <dd class="col-sm-7 mb-2">{{ $inspection->complaint ?: '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-list-check"></i> Checklist</div>
                <div class="card-body p-4 table-responsive">
                    <table class="table table-sm table-striped table-borderless align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Komponen</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspection->checklist as $component => $status)
                                <tr>
                                    <td>{{ $inspection->getChecklistLabel($component) }}</td>
                                    <td>{{ $inspection->getChecklistStatusLabel($status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($inspection->histories->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header"><i class="fas fa-history"></i> Riwayat Perubahan</div>
        <div class="card-body table-responsive p-3">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Editor</th>
                        <th>Odometer</th>
                        <th>Hasil</th>
                        <th>Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspection->histories as $history)
                        <tr>
                            <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $history->editedBy->name }}</td>
                            <td>{{ number_format($history->odometer, 0, ',', '.') }} km</td>
                            <td>{{ match ($history->condition_result) {
                                'siap_operasi' => 'Siap Operasi',
                                'perlu_perbaikan' => 'Perlu Perbaikan',
                                'tidak_layak' => 'Tidak Layak',
                                default => $history->condition_result,
                            } }}</td>
                            <td>{{ $history->complaint ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
