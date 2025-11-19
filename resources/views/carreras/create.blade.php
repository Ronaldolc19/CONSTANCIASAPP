@extends('layouts.admin')
@section('title', 'Nueva Carrera')
@section('content')
<h2>Nueva Carrera</h2>
<form action="{{ route('carreras.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la carrera</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
