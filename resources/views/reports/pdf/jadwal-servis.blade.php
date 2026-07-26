@extends('reports.pdf.layout')

@section('table')
@include('reports.exports.jadwal-servis', ['jadwalServis' => $jadwalServis])
@endsection
