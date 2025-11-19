@extends('layouts.app')
@section('title', 'Editar Carrera')
@section('content')
<h2>Editar Carrera</h2>
<form action="{{ route('carreras.update', $carrera->id_carrera) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $carrera->nombre }}" required>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
