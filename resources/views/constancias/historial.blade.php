@extends('layouts.admin')

@section('title', 'Historial de Constancia')

@section('content')
<div class="card shadow-sm">

    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <h5 class="mb-0">
            Historial – {{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }}
        </h5>

        <a href="{{ route('constancias.general') }}" class="btn btn-light btn-sm">Regresar</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($historial as $h)
                <tr>
                    <td class="text-capitalize">{{ $h->accion }}</td>
                    <td>{{ $h->usuario->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection
