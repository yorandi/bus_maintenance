@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-car"></i> Data Kendaraan</h2>
    </div>
    <div class="col-md-4 text-end">
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kendaraan
        </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Kendaraan
    </div>
    <div class="card-body">
        @if($vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Polisi</th>
                            <th>No. Rangka</th>
                            <th>Merk/Model</th>
                            <th>Tahun</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                            <tr>
                                <td><strong>{{ $vehicle->registration_number }}</strong></td>
                                <td><small>{{ $vehicle->nomor_rangka }}</small></td>
                                <td>{{ $vehicle->merk }} {{ $vehicle->model }}</td>
                                <td>{{ $vehicle->tahun_pembuatan }}</td>
                                <td>{{ $vehicle->kapasitas_penumpang }} Penumpang</td>
                                <td>
                                    @if($vehicle->status == 'good')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif($vehicle->status == 'maintenance')
                                        <span class="badge bg-warning text-dark">Servis</span>
                                    @else
                                        <span class="badge bg-danger">Rusak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" style="display: inline;">
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
                {{ $vehicles->links() }}
            </div>
        @else
            <p class="text-muted text-center py-5">Belum ada data kendaraan</p>
        @endif
    </div>
</div>
@endsection
