@extends('layouts.app')

@section('title', $title ?? 'Laporan')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-file-alt"></i> {{ $title ?? 'Laporan ?>' }}</h2>
            <p class="text-muted">Lihat dan ekspor hasil pemeriksaan operasional sopir.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                @if (!isset($fixedType))
                    <div class="col-md-3">
                        <label class="form-label">Jenis Form</label>
                        <select class="form-select" name="type">
                            <option value="">Semua</option>
                            <option value="at3" @selected(request('type') === 'at3')>AT/3 Sebelum Operasional</option>
                            <option value="at4" @selected(request('type') === 'at4')>AT/4 Setelah Operasional</option>
                        </select>
                    </div>
                @else
                    <input type="hidden" name="type" value="{{ $fixedType }}">
                @endif
                <div class="col-md-3">
                    <label class="form-label">Hasil</label>
                    <select class="form-select" name="condition_result">
                        <option value="">Semua</option>
                        <option value="siap_operasi" @selected(request('condition_result') === 'siap_operasi')>Siap Operasi</option>
                        <option value="perlu_perbaikan" @selected(request('condition_result') === 'perlu_perbaikan')>Perlu Perbaikan</option>
                        <option value="tidak_layak" @selected(request('condition_result') === 'tidak_layak')>Tidak Layak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit Kendaraan</label>
                    <input type="text" name="vehicle_id" value="{{ request('vehicle_id') }}" class="form-control"
                        placeholder="ID kendaraan">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route($routeBase) }}" class="btn btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5>Hasil Laporan</h5>
                    <p class="text-muted mb-0">Tabel menunjukkan hasil pemeriksaan {{ $title ?? 'AT/3 & AT/4' }}.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route($routeBase . '.excel', request()->query()) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route($routeBase . '.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Form</th>
                            <th>Kendaraan</th>
                            <th>Sopir</th>
                            <th>Odometer</th>
                            <th>Hasil</th>
                            <th>Catatan</th>
                            @if (auth()->user()->isAdmin() || auth()->user()->isSopir())
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inspections as $inspection)
                            <tr>
                                <td>{{ optional($inspection->inspected_at)->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>{{ $inspection->type_label }}</td>
                                <td>{{ optional($inspection->vehicle)->registration_number ?? '-' }} -
                                    {{ optional($inspection->vehicle)->merk }}
                                    {{ optional($inspection->vehicle)->model }}</td>
                                <td>{{ optional($inspection->driver)->name ?? '-' }}</td>
                                <td>{{ number_format((int) ($inspection->odometer ?? 0), 0, ',', '.') }} km</td>
                                <td>{{ $inspection->condition_label }}</td>
                                <td>{{ $inspection->complaint ?: '-' }}</td>
                                @if (auth()->user()->isAdmin() || auth()->user()->isSopir())
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('inspections.show', $inspection) }}"
                                                class="btn btn-sm btn-info" title="Lihat detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('inspections.edit', $inspection) }}"
                                                class="btn btn-sm btn-secondary" title="Edit laporan">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isSopir() ? 8 : 7 }}"
                                    class="text-center text-muted py-4">Belum ada data pemeriksaan operasional.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('partials.pagination', ['paginator' => $inspections])
        </div>
    </div>
@endsection
