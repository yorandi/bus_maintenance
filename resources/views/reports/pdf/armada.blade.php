@extends('reports.pdf.layout')

@section('table')
<p>Total: {{ $summary['total'] }} | Aktif: {{ $summary['aktif'] }} | Servis: {{ $summary['servis'] }} | Rusak: {{ $summary['rusak'] }} | Tidak Beroperasi: {{ $summary['tidak_beroperasi'] }}</p>
@include('reports.exports.armada', ['armadas' => $armadas])
@endsection
