@extends('reports.pdf.layout')

@section('table')
    <table>
        <thead>
        <tr>
            <th>Tanggal</th>
            <th>Form</th>
            <th>Kendaraan</th>
            <th>Sopir</th>
            <th>Odometer</th>
            <th>Hasil</th>
            <th>Catatan</th>
        </tr>
        </thead>
        <tbody>
        @foreach($inspections as $inspection)
            <tr>
                <td>{{ $inspection->inspected_at->format('d/m/Y H:i') }}</td>
                <td>{{ $inspection->type_label }}</td>
                <td>{{ $inspection->vehicle->registration_number }} - {{ $inspection->vehicle->merk }} {{ $inspection->vehicle->model }}</td>
                <td>{{ $inspection->driver->name }}</td>
                <td>{{ number_format($inspection->odometer, 0, ',', '.') }} km</td>
                <td>{{ $inspection->condition_label }}</td>
                <td>{{ $inspection->complaint ?: '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
