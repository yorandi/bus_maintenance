@extends('reports.pdf.layout')

@section('table')
@include('reports.exports.kondisi-armada', ['kondisiArmadas' => $kondisiArmadas])
@endsection
