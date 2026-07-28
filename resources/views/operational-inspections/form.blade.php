@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-clipboard-check"></i> {{ $title }}</h2>
            <p class="text-muted mb-0">Isi pemeriksaan kendaraan sesuai kondisi aktual di lapangan</p>
        </div>
    </div>

    <form method="POST"
        action="{{ isset($inspection) ? route('inspections.update', $inspection) : ($type === 'at3' ? route('inspections.at3.store') : route('inspections.at4.store')) }}">
        @csrf
        @isset($inspection)
            @method('PUT')
        @endisset
        <div class="card">
            <div class="card-header"><i class="fas fa-bus"></i> Data Kendaraan</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Unit Kendaraan</label>
                        <select name="vehicle_id" class="form-select" required>
                            <option value="">Pilih kendaraan</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', isset($inspection) ? $inspection->vehicle_id : null) == $vehicle->id)>
                                    {{ $vehicle->registration_number }} - {{ $vehicle->merk }} {{ $vehicle->model }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ $type === 'at3' ? 'Odometer Awal' : 'Odometer Akhir' }}</label>
                        <input type="number" name="odometer"
                            value="{{ old('odometer', isset($inspection) ? $inspection->odometer : '') }}" min="0"
                            class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fas fa-list-check"></i> Checklist Pemeriksaan</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Komponen</th>
                                <th class="text-center">Baik</th>
                                <th class="text-center">Perlu Perbaikan</th>
                                <th class="text-center">Rusak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key => $label)
                                <tr>
                                    <td><strong>{{ $label }}</strong></td>
                                    @foreach (['baik' => 'Baik', 'perlu_perbaikan' => 'Perlu Perbaikan', 'rusak' => 'Rusak'] as $value => $text)
                                        <td class="text-center">
                                            <input class="form-check-input" type="radio"
                                                name="checklist[{{ $key }}]" value="{{ $value }}"
                                                @checked(old("checklist.$key", isset($inspection) ? $inspection->checklist[$key] ?? 'baik' : 'baik') === $value) required>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <label
                    class="form-label mt-3">{{ $type === 'at3' ? 'Catatan Pemeriksaan' : 'Keluhan atau Kerusakan Selama Operasional' }}</label>
                <textarea name="complaint" class="form-control" rows="4" placeholder="Isi jika ada catatan atau kerusakan">{{ old('complaint', isset($inspection) ? $inspection->complaint : '') }}</textarea>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> {{ isset($inspection) ? 'Perbarui Pemeriksaan' : 'Simpan Pemeriksaan' }}
            </button>
            <a href="{{ route('inspections.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
@endsection
