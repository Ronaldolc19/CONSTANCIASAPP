@extends('layouts.app')
@section('title','Detalle Estudiante')
@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <h2>Detalle Estudiante</h2>

    <ul class="list-group mb-3">
      <li class="list-group-item"><strong>ID:</strong> {{ $estudiante->id_estudiante }}</li>
      <li class="list-group-item"><strong>Nombre:</strong> {{ $estudiante->nombre }} {{ $estudiante->ap }} {{ $estudiante->am }}</li>
      <li class="list-group-item"><strong>Género:</strong> {{ $estudiante->genero ?? '-' }}</li>
      <li class="list-group-item"><strong>No. de Cuenta:</strong> {{ $estudiante->no_cuenta }}</li>
      <li class="list-group-item"><strong>Carrera:</strong> {{ optional($estudiante->carrera)->nombre }}</li>
      <li class="list-group-item"><strong>Registrado:</strong> {{ $estudiante->created_at->format('d/m/Y') }}</li>
    </ul>

    <a href="{{ route('estudiantes.edit', $estudiante->id_estudiante) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('estudiantes.index') }}" class="btn btn-primary">Volver</a>
  </div>
</div>
@endsection
