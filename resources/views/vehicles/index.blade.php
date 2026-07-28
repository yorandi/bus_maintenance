@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
    <style>
        .pagination-wrapper .pagination {
            gap: 0.4rem;
            margin-bottom: 0;
        }

        .pagination-wrapper .page-item .page-link {
            min-width: 2.45rem;
            height: 2.45rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.35rem 0.7rem;
            border: 1px solid #dfe3e8;
            color: #334155;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .pagination-wrapper .page-item .page-link:hover {
            background-color: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .pagination-wrapper .page-item.active .page-link {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            border-color: #2563eb;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.2);
        }

        .pagination-wrapper .page-item.disabled .page-link {
            opacity: 0.55;
            background-color: #f8fafc;
            color: #94a3b8;
        }
    </style>
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-car"></i> Data Kendaraan</h2>
        </div>
        <div class="col-md-4 text-end">
            @if (auth()->user()->isAdmin() || auth()->user()->isManager())
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
            @if ($vehicles->count() > 0)
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
                            @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td><strong>{{ $vehicle->registration_number }}</strong></td>
                                    <td><small>{{ $vehicle->nomor_rangka }}</small></td>
                                    <td>{{ $vehicle->merk }} {{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->tahun_pembuatan }}</td>
                                    <td>{{ $vehicle->kapasitas_penumpang }} Penumpang</td>
                                    <td>
                                        @if ($vehicle->status == 'good')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($vehicle->status == 'maintenance')
                                            <span class="badge bg-warning text-dark">Servis</span>
                                        @elseif($vehicle->status == 'damaged')
                                            <span class="badge bg-danger">Rusak</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Beroperasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (auth()->user()->isAdmin() || auth()->user()->isManager())
                                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus?')">
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
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mt-4">
                    <div class="text-muted small">
                        Menampilkan {{ $vehicles->firstItem() }} - {{ $vehicles->lastItem() }} dari
                        {{ $vehicles->total() }} data
                    </div>

                    <div class="pagination-wrapper">
                        {{ $vehicles->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <p class="text-muted text-center py-5">Belum ada data kendaraan</p>
            @endif
        </div>
    </div>
@endsection
