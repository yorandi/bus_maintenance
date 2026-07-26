@extends('reports.pdf.layout')

@section('table')
@include('reports.exports.keterlambatan-servis', ['keterlambatan' => $keterlambatan])
@endsection
