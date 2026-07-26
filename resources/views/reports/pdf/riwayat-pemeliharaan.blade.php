@extends('reports.pdf.layout')

@section('table')
@include('reports.exports.riwayat-pemeliharaan', ['riwayat' => $riwayat])
@endsection
