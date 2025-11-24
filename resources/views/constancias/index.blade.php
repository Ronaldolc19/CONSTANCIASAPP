@extends('layouts.admin')

@section('title','Constancias')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h5 class="mb-0">Listado de Constancias</h5>
        <a href="{{ route('constancias.create') }}" class="btn btn-light">Nueva</a>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Empresa</th>
                    <th>Periodo</th>
                    <th>Calificación</th>
                    <th>No. Registro</th>
                    <th>No. Folio</th>
                    <th>Emisión</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($constancias as $c)
                <tr>
                    <td>{{ $c->id_constancia }}</td>
                    <td>{{ $c->estudiante->nombre }} {{ $c->estudiante->ap }}</td>
                    <td>{{ $c->empresa->nombre }}</td>
                    <td>{{ $c->periodo->periodo_formateado }}</td>
                    <td>{{ $c->calificacion }}</td>
                    <td>{{ $c->no_registro }}</td>
                    <td>{{ $c->no_folio }}</td>
                    <td>{{ \Carbon\Carbon::parse($c->fecha_emision)->format('d/m/Y') }}</td>

                    <td>
                        <a href="{{ route('constancias.show',$c->id_constancia) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('constancias.edit',$c->id_constancia) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('constancias.destroy',$c->id_constancia) }}" class="d-inline" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">X</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>
@endsection
