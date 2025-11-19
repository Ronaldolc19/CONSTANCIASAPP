@extends('layouts.admin')
@section('title', 'Empresas')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Empresas</h1>
    <a href="{{ route('empresas.create') }}" class="btn btn-primary">Nueva Empresa</a>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($empresas as $empresa)
        <tr>
            <td>{{ $empresa->id_empresa }}</td>
            <td>{{ $empresa->nombre }}</td>
            <td>
                <a href="{{ route('empresas.show', $empresa->id_empresa) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('empresas.edit', $empresa->id_empresa) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('empresas.destroy', $empresa->id_empresa) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
