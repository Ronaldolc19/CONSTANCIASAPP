@extends('layouts.admin')

@section('title', 'Detalles de Constancia')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Detalles de la Constancia</h3>
            <p class="text-muted small mb-0">Información general del registro en sistema</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('constancias.index') }}" class="btn btn-light border shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Volver al listado
            </a>
            {{-- Botón adicional para generar documento si lo necesitas --}}
            <a href="#" class="btn btn-danger shadow-sm px-3">
                <i class="fas fa-file-pdf me-2"></i> Exportar PDF
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-file-earmark-text me-2 text-info"></i> Resumen del Registro
                    </h6>
                    <span class="badge {{ $constancia->estado == 'emitida' ? 'bg-success' : 'bg-warning text-dark' }} px-3">
                        Estado: {{ strtoupper($constancia->estado) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase" style="width: 35%;">Estudiante</th>
                                <td class="ps-4 fw-bold text-dark">
                                    {{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}
                                    <div class="small text-muted fw-normal">Matrícula: {{ $constancia->estudiante->no_cuenta }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Carrera</th>
                                <td class="ps-4 text-dark">{{ optional($constancia->estudiante->carrera)->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Empresa / Sede</th>
                                <td class="ps-4 text-dark">{{ optional($constancia->estudiante->empresa)->nombre ?? 'Sin asignar' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Periodo</th>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border">
                                        {{ optional($constancia->estudiante->periodo)->periodo_formateado ?? 'No registrado' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Calificación</th>
                                <td class="ps-4 fw-bold text-success fs-5">{{ $constancia->estudiante->calificacion ?? '0' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Núm. Registro</th>
                                <td class="ps-4 text-dark" style="font-family: monospace; font-size: 1rem;">
                                    {{ $constancia->estudiante->no_registro }}
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Núm. Folio</th>
                                <td class="ps-4 text-danger fw-bold" style="font-family: monospace; font-size: 1.1rem;">
                                    {{ $constancia->estudiante->no_folio }}
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Fecha de Emisión</th>
                                <td class="ps-4 text-muted">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    {{ $constancia->estudiante->fecha_emision ? \Carbon\Carbon::parse($constancia->estudiante->fecha_emision)->format('d/m/Y') : 'Pendiente' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-end">
                    <a href="{{ route('constancias.edit', $constancia->id_constancia) }}" class="btn btn-warning btn-sm px-4 shadow-sm">
                        <i class="bi bi-pencil-square me-1"></i> Editar datos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-custom { border-radius: 15px; }
    th { vertical-align: middle !important; border-right: 1px solid #f0f0f0; }
    td { vertical-align: middle !important; padding-top: 1.2rem !important; padding-bottom: 1.2rem !important; }
    .badge { font-weight: 600; }
</style>

@endsection