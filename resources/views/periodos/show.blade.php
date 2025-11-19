@extends('layouts.app')
@section('title', 'Detalles del Periodo')
@section('content')
<h2>Detalles del Periodo</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>ID:</strong> {{ $periodo->id_periodo }}</li>
    <li class="list-group-item"><strong>Fecha de Inicio:</strong> {{ $periodo->fecha_inicio }}</li>
    <li class="list-group-item"><strong>Fecha de Fin:</strong> {{ $periodo->fecha_fin }}</li>
</ul>
<a href="{{ route('periodos.index') }}" class="btn btn-primary mt-3">Volver</a>
@endsection
