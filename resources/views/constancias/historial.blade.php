@extends('layouts.admin')

@section('title', 'Historial de Constancia')

@section('content')

<div class="container-fluid">
    {{-- ENCABEZADO Y ACCIONES --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #007F3F;">Historial de Movimientos</h3>
            <p class="text-muted small mb-0">
                <i class="bi bi-person-badge me-1"></i> Estudiante: 
                <strong>{{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}</strong>
            </p>
        </div>
        <div class="d-flex gap-2">
            {{-- BOTÓN VER PDF (Solo si existe path) --}}
            @if($constancia->pdf_path)
                <a href="{{ asset('storage/' . $constancia->pdf_path) }}" 
                   class="btn btn-outline-info shadow-sm" target="_blank">
                    <i class="bi bi-eye-fill me-2"></i> Ver PDF
                </a>

                {{-- BOTÓN DESCARGAR PDF --}}
                <a href="{{ asset('storage/' . $constancia->pdf_path) }}" 
                    class="btn btn-warning shadow-sm" 
                    download>
                    <i class="bi bi-download me-2"></i> Descargar
                </a>
            @else
                <button class="btn btn-light border text-muted shadow-sm" disabled title="Aún no se genera el PDF">
                    <i class="bi bi-file-earmark-lock me-2"></i> PDF no disponible
                </button>
            @endif
                        
            <a href="{{ route('constancias.general') }}" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- RESUMEN DEL DOCUMENTO --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i> Detalles Actuales</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Número de Folio</label>
                        <span class="fw-bold text-danger fs-5">{{ $constancia->estudiante->no_folio }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Número de Registro</label>
                        <span class="fw-bold text-dark">{{ $constancia->estudiante->no_registro }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Periodo</label>
                        <span class="text-dark">{{ $constancia->estudiante->periodo->periodo_formateado ?? 'Sin periodo' }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Empresa / Institución</label>
                        <span class="text-dark small">{{ $constancia->estudiante->empresa->nombre ?? 'N/A' }}</span>
                    </div>
                    <hr class="opacity-25">
                    <div class="text-center">
                        <small class="text-muted">Fecha de emisión registrada:</small>
                        <div class="fw-bold">
                            {{ $constancia->estudiante->fecha_emision ? \Carbon\Carbon::parse($constancia->estudiante->fecha_emision)->format('d/m/Y') : 'No asignada' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LÍNEA DE TIEMPO / TABLA DE MOVIMIENTOS --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-dark text-white text-center">
                            <tr class="small text-uppercase">
                                <th class="py-3 ps-4 text-start" style="width: 250px;">Fecha y Hora</th>
                                <th class="py-3 text-start">Acción Realizada</th>
                                <th class="py-3 pe-4" style="width: 120px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($constancia->historial as $h)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">
                                        <i class="bi bi-calendar3 me-2 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-clock me-2"></i>
                                        {{ \Carbon\Carbon::parse($h->fecha)->format('H:i') }} hrs
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $accion = strtolower($h->accion);
                                        $icon = 'bi-info-circle';
                                        $color = 'text-primary';
                                        $bg = 'bg-primary';

                                        if(str_contains($accion, 'crear') || str_contains($accion, 'generar')) {
                                            $icon = 'bi-plus-circle-fill';
                                            $color = 'text-success';
                                            $bg = 'bg-success';
                                        } elseif(str_contains($accion, 'editar') || str_contains($accion, 'actualizar')) {
                                            $icon = 'bi-pencil-fill';
                                            $color = 'text-warning';
                                            $bg = 'bg-warning';
                                        } elseif(str_contains($accion, 'descargar') || str_contains($accion, 'ver')) {
                                            $icon = 'bi-file-earmark-pdf-fill';
                                            $color = 'text-danger';
                                            $bg = 'bg-danger';
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="{{ $bg }} bg-opacity-10 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            <i class="bi {{ $icon }} {{ $color }}"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block">{{ ucfirst($h->accion) }}</span>
                                            <small class="text-muted">Por: {{ $h->usuario->name ?? 'Sistema' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center pe-4">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-2">
                                        Completado
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-clock-history display-4 opacity-25"></i>
                                    <p class="mt-2">No hay registros en la bitácora para esta constancia.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.01);
    }
    .badge { font-weight: 600; }
</style>

@endsection