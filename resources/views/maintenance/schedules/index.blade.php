@extends('layouts.app')

@section('title', 'Jadwal Servis')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-calendar-alt"></i> Jadwal Servis</h2>
        </div>
        <div class="col-md-4 text-end">
            @if (auth()->user()->isAdmin() || auth()->user()->isManager())
                <a href="{{ route('schedules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Jadwal
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-list"></i> Daftar Jadwal Servis
        </div>
        <div class="card-body">
            @if ($schedules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kendaraan</th>
                                <th>Tipe Servis</th>
                                <th>Status</th>
                                <th>Mekanik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->scheduled_date->format('d M Y') }}</td>
                                    <td>
                                        <strong>{{ $schedule->vehicle->registration_number }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $schedule->vehicle->model }}</small>
                                    </td>
                                    <td>{{ $schedule->service_type }}</td>
                                    <td>
                                        @if ($schedule->status == 'pending')
                                            <span class="badge bg-secondary">Pending</span>
                                        @elseif($schedule->status == 'in_progress')
                                            <span class="badge bg-warning text-dark">Proses</span>
                                        @elseif($schedule->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>{{ $schedule->assigned_mechanic ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (auth()->user()->isAdmin() || auth()->user()->isManager())
                                            <a href="{{ route('schedules.edit', $schedule) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
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

                @include('partials.pagination', ['paginator' => $schedules])
            @else
                <p class="text-muted text-center py-5">Belum ada jadwal servis</p>
            @endif
        </div>
    </div>
@endsection
