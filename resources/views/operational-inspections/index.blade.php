@extends('layouts.app')

@section('title', 'AT/3 dan AT/4 Digital')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-clipboard-list"></i> AT/3 dan AT/4 Digital</h2>
            <p class="text-muted mb-0">Pemeriksaan kendaraan sebelum dan setelah operasional</p>
        </div>
        @if (auth()->user()->isSopir())
            <div class="d-flex gap-2">
                <a href="{{ route('inspections.at3.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-play-circle"></i> Isi AT/3
                </a>
                <a href="{{ route('inspections.at4.create') }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-stop-circle"></i> Isi AT/4
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Jenis Form</label>
                    <select name="type" class="form-select">
                        <option value="">Semua</option>
                        <option value="at3" @selected(request('type') === 'at3')>AT/3 Sebelum Operasional</option>
                        <option value="at4" @selected(request('type') === 'at4')>AT/4 Setelah Operasional</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hasil Kondisi</label>
                    <select name="condition_result" class="form-select">
                        <option value="">Semua</option>
                        <option value="siap_operasi" @selected(request('condition_result') === 'siap_operasi')>Siap Operasi</option>
                        <option value="perlu_perbaikan" @selected(request('condition_result') === 'perlu_perbaikan')>Perlu Perbaikan</option>
                        <option value="tidak_layak" @selected(request('condition_result') === 'tidak_layak')>Tidak Layak</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('inspections.index') }}" class="btn btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Form</th>
                        <th>Kendaraan</th>
                        <th>Sopir</th>
                        <th>Odometer</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inspections as $inspection)
                        <tr>
                            <td>{{ optional($inspection->inspected_at)->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ $inspection->type_label }}</td>
                            <td>
                                <strong>{{ optional($inspection->vehicle)->registration_number ?? '-' }}</strong><br>
                                <small class="text-muted">{{ optional($inspection->vehicle)->merk }}
                                    {{ optional($inspection->vehicle)->model }}</small>
                            </td>
                            <td>{{ optional($inspection->driver)->name ?? '-' }}</td>
                            <td>{{ number_format((int) ($inspection->odometer ?? 0), 0, ',', '.') }} km</td>
                            <td>
                                @php
                                    $badge =
                                        [
                                            'siap_operasi' => 'success',
                                            'perlu_perbaikan' => 'warning',
                                            'tidak_layak' => 'danger',
                                        ][$inspection->condition_result] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $inspection->condition_label }}</span>
                            </td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('inspections.show', $inspection) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('inspections.edit', $inspection) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data pemeriksaan operasional
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @include('partials.pagination', ['paginator' => $inspections])
        </div>
    </div>
@endsection
