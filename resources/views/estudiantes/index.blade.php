@extends('layouts.admin')
@section('title','Estudiantes')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Estudiantes</h1>
    <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">Nuevo Estudiante</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>No. Cuenta</th>
            <th>Carrera</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($estudiantes as $est)
        <tr>
            <td>{{ $est->id_estudiante }}</td>
            <td>{{ $est->nombre }} {{ $est->ap }} {{ $est->am }}</td>
            <td>{{ $est->no_cuenta }}</td>
            <td>{{ optional($est->carrera)->nombre }}</td>
            <td>
                <a href="{{ route('estudiantes.show', $est->id_estudiante) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('estudiantes.edit', $est->id_estudiante) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('estudiantes.destroy', $est->id_estudiante) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este estudiante?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No hay estudiantes registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $estudiantes->links() }}
</div>
@endsection
