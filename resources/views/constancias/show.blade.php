@extends('layouts.admin')

@section('title','Detalles de Constancia')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Detalles</h5>
    </div>

    <div class="card-body">

        <p><strong>Estudiante:</strong> {{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }}</p>
        <p><strong>Empresa:</strong> {{ $constancia->empresa->nombre }}</p>
        <p><strong>Periodo:</strong> {{ $constancia->periodo->periodo_formateado }}</p>
        <p><strong>Calificación:</strong> {{ $constancia->calificacion }}</p>
        <p><strong>Número de Registro:</strong> {{ $constancia->no_registro }}</p>
        <p><strong>Número de Folio:</strong> {{ $constancia->no_folio }}</p>
        <p><strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::parse($constancia->fecha_emision)->format('d/m/Y') }}</p>

        <a href="{{ route('constancias.index') }}" class="btn btn-secondary">Regresar</a>

    </div>
</div>

@endsection
