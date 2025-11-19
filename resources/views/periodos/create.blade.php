@extends('layouts.admin')
@section('title', 'Nuevo Periodo')
@section('content')
<h2>Nuevo Periodo</h2>
<form action="{{ route('periodos.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('periodos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
