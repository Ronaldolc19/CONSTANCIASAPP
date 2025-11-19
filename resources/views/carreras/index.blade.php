@extends('layouts.admin')
@section('title', 'Carreras')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Carreras</h1>
    <a href="{{ route('carreras.create') }}" class="btn btn-primary">Nueva Carrera</a>
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
        @foreach($carreras as $carrera)
        <tr>
            <td>{{ $carrera->id_carrera }}</td>
            <td>{{ $carrera->nombre }}</td>
            <td>
                <a href="{{ route('carreras.show', $carrera->id_carrera) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('carreras.edit', $carrera->id_carrera) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('carreras.destroy', $carrera->id_carrera) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
