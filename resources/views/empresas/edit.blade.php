@extends('layouts.app')
@section('title', 'Editar Empresa')
@section('content')
<h2>Editar Empresa</h2>
<form action="{{ route('empresas.update', $empresa->id_empresa) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $empresa->nombre }}" required>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
