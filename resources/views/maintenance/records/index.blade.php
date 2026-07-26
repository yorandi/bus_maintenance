@extends('layouts.app')

@section('title', 'Riwayat Pemeliharaan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-history"></i> Riwayat Pemeliharaan</h2>
    </div>
    <div class="col-md-4 text-end">
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <a href="{{ route('records.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Catat Pemeliharaan
        </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Riwayat Pemeliharaan
    </div>
    <div class="card-body">
        @if($records->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>Tipe Servis</th>
                            <th>Mekanik</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{ $record->maintenance_date->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $record->vehicle->registration_number }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $record->vehicle->model }}</small>
                                </td>
                                <td>{{ $record->service_type }}</td>
                                <td>{{ $record->mechanic->name }}</td>
                                <td><strong>Rp. {{ number_format($record->cost, 0, ',', '.') }}</strong></td>
                                <td>
                                    <a href="{{ route('records.show', $record) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                    <a href="{{ route('records.edit', $record) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('records.destroy', $record) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $records->links() }}
            </div>
        @else
            <p class="text-muted text-center py-5">Belum ada riwayat pemeliharaan</p>
        @endif
    </div>
</div>
@endsection
