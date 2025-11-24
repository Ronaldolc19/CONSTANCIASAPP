@extends('layouts.admin')

@section('title', 'Historial de Constancia')

@section('content')
<div class="card shadow-sm">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Historial de la Constancia</h5>
            <small>{{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}</small>
        </div>

        <div>
            <a href="{{ route('constancias.ver', $constancia->id_constancia) }}" 
               class="btn btn-light btn-sm" target="_blank">
               <i class="fas fa-eye"></i> Ver PDF
            </a>

            <a href="{{ route('constancias.descargar', $constancia->id_constancia) }}" 
               class="btn btn-warning btn-sm">
               <i class="fas fa-download"></i> Descargar PDF
            </a>
        </div>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>

                @foreach($constancia->historial as $h)
                <tr>
                    <td>{{ ucfirst($h->accion) }}</td>
                    <td>{{ $h->usuario->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        
        <a href="{{ route('constancias.general') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Volver
        </a>

    </div>

</div>
@endsection
