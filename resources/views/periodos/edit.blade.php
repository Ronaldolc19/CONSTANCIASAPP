@extends('layouts.app')
@section('title', 'Editar Periodo')
@section('content')
<h2>Editar Periodo</h2>
<form action="{{ route('periodos.update', $periodo->id_periodo) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $periodo->fecha_inicio }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $periodo->fecha_fin }}" class="form-control" required>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('periodos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
