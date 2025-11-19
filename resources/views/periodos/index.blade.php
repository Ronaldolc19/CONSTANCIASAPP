@extends('layouts.admin')
@section('title', 'Periodos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Periodos</h1>
    <a href="{{ route('periodos.create') }}" class="btn btn-primary">Nuevo Periodo</a>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($periodos as $periodo)
        <tr>
            <td>{{ $periodo->id_periodo }}</td>
            <td>{{ $periodo->fecha_inicio }}</td>
            <td>{{ $periodo->fecha_fin }}</td>
            <td>
                <a href="{{ route('periodos.show', $periodo->id_periodo) }}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{ route('periodos.edit', $periodo->id_periodo) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('periodos.destroy', $periodo->id_periodo) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
