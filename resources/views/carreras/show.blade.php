@extends('layouts.app')
@section('title', 'Detalles de Carrera')
@section('content')
<h2>Detalles de Carrera</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>ID:</strong> {{ $carrera->id_carrera }}</li>
    <li class="list-group-item"><strong>Nombre:</strong> {{ $carrera->nombre }}</li>
</ul>
<a href="{{ route('carreras.index') }}" class="btn btn-primary mt-3">Volver</a>
@endsection
