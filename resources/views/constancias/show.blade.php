@extends('layouts.admin')

@section('title', 'Expediente - ' . $constancia->estudiante->nombre)

@section('content')

<div class="container-fluid">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #007F3F;">Expediente de Constancia</h3>
            <p class="text-muted small mb-0">Visualización de folios y datos académicos registrados</p>
        </div>
        <div>
            <a href="{{ route('constancias.general') }}" class="btn btn-light border px-4 rounded-3 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Volver al Listado
            </a>
            <a href="{{ route('constancias.edit', $constancia->id_constancia) }}" class="btn btn-warning px-4 rounded-3 shadow-sm ms-2">
                <i class="bi bi-pencil-square me-2"></i> Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Perfil del Estudiante (Columna Izquierda) --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="avatar-circle mx-auto mb-3">
                    <span class="display-4 fw-bold text-white">{{ substr($constancia->estudiante->nombre, 0, 1) }}</span>
                </div>
                
                <h4 class="fw-bold mb-1 text-dark">
                    {{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}
                </h4>
                <p class="text-muted small mb-3">Matrícula: <span class="fw-bold text-dark">{{ $constancia->estudiante->no_cuenta }}</span></p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-light text-success border border-success-subtle px-3 py-2 rounded-pill">
                        <i class="bi bi-award me-1"></i> Calificación: {{ $constancia->estudiante->calificacion ?? 'N/A' }}
                    </span>
                    <span class="badge {{ $constancia->estado == 'emitida' ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2 rounded-pill">
                        {{ strtoupper($constancia->estado) }}
                    </span>
                </div>

                <hr class="opacity-25">

                <div class="text-start mt-3">
                    <div class="mb-3">
                        <label class="text-muted small d-block mb-1 text-uppercase fw-bold">Identificación de Constancia</label>
                        <div class="bg-light p-3 rounded-3 border-dashed">
                            <div class="mb-2">
                                <span class="text-muted d-block" style="font-size: 0.7rem;">NO. REGISTRO</span>
                                <code class="text-dark fw-bold fs-6">{{ $constancia->estudiante->no_registro ?? 'No asignado' }}</code>
                            </div>
                            <div>
                                <span class="text-muted d-block" style="font-size: 0.7rem;">NO. FOLIO</span>
                                <span class="text-danger fw-bold" style="font-family: monospace;">{{ $constancia->estudiante->no_folio ?? 'Pendiente' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detalle Técnico en Tabla (Columna Derecha) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-uppercase letter-spacing-1 text-muted">
                        <i class="bi bi-card-checklist me-2 text-success"></i> Información Detallada
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase" style="width: 35%;">Carrera Profesional</th>
                                <td class="ps-4 fw-medium text-dark">
                                    {{ $constancia->estudiante->carrera->nombre ?? 'Sin carrera vinculada' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Empresa / Institución</th>
                                <td class="ps-4">
                                    {{ $constancia->estudiante->empresa->nombre ?? 'Sin empresa asignada' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Periodo Escolar</th>
                                <td class="ps-4">
                                    <span class="text-dark">
                                        {{ $constancia->estudiante->periodo->periodo_formateado ?? 'N/A' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Resultado del Desempeño</th>
                                <td class="ps-4">
                                    @php
                                        $cal = $constancia->estudiante->calificacion;
                                        $desempeno = $cal >= 97 ? 'Excelente' : ($cal >= 90 ? 'Muy Bien' : ($cal >= 80 ? 'Bien' : 'Pendiente'));
                                    @endphp
                                    <span class="fw-bold text-success">
                                        {{ $cal ?? '0' }} - {{ $desempeno }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">Fecha de Emisión</th>
                                <td class="ps-4">
                                    <i class="bi bi-calendar3 me-2 text-muted"></i>
                                    {{ $constancia->estudiante->fecha_emision ? \Carbon\Carbon::parse($constancia->estudiante->fecha_emision)->format('d/m/Y') : 'Pendiente' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 bg-light text-muted small fw-bold text-uppercase">ID de Sistema</th>
                                <td class="ps-4">
                                    <span class="badge bg-light text-muted border">#{{ str_pad($constancia->id_constancia, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i> Este registro corresponde a una constancia oficial emitida por el sistema.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 90px; height: 90px;
        background: linear-gradient(135deg, #007F3F, #1a5c37);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 127, 63, 0.2);
    }
    .table th { border-right: 1px solid #f8f9fa; font-size: 0.75rem !important; }
    .table td { padding: 1.1rem !important; color: #444; font-size: 0.95rem; }
    .border-dashed { border: 1px dashed #dee2e6 !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .card { border-radius: 15px; }
</style>

@endsection