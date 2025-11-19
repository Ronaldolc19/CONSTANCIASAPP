@extends('layouts.admin')
@section('title', 'Nueva Empresa')
@section('content')
<h2>Nueva Empresa</h2>
<form action="{{ route('empresas.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la Empresa</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
