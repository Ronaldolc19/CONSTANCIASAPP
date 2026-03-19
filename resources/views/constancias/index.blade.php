@extends('layouts.admin')

@section('title', 'Listado de Constancias')

@section('content')
<div class="container-fluid">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #1a5c37;">Control de Constancias</h3>
            <p class="text-muted small mb-0">Gestión de folios y estados de emisión por estudiante</p>
        </div>
        <a href="{{ route('constancias.create') }}" class="btn btn-success shadow-sm px-4">
            <i class="fas fa-plus me-2"></i> Nueva Constancia
        </a>
    </div>

    {{-- Tarjetas de Resumen Rápido (Opcional pero recomendado para buena vista) --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-primary">
                <small class="text-muted fw-bold">TOTAL</small>
                <h4 class="fw-bold mb-0">{{ $constancias->count() }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-success">
                <small class="text-muted fw-bold">EMITIDAS</small>
                <h4 class="fw-bold mb-0 text-success">{{ $constancias->where('estado', 'emitida')->count() }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-4 border-warning">
                <small class="text-muted fw-bold">PENDIENTES</small>
                <h4 class="fw-bold mb-0 text-warning">{{ $constancias->where('estado', 'pendiente')->count() }}</h4>
            </div>
        </div>
    </div>

    {{-- Tabla Principal --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Estudiante / Matrícula</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Folio / Registro</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Empresa / Sede</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Calificación</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Estado</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($constancias as $constancia)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }}</div>
                                <small class="text-muted">{{ $constancia->estudiante->no_cuenta }}</small>
                            </td>
                            <td>
                                <div class="small fw-bold text-danger">{{ $constancia->estudiante->no_folio }}</div>
                                <div class="small text-muted" style="font-family: monospace;">{{ $constancia->estudiante->no_registro }}</div>
                            </td>
                            <td>
                                <div class="small text-truncate" style="max-width: 200px;">
                                    {{ optional($constancia->estudiante->empresa)->nombre ?? 'Sin empresa' }}
                                </div>
                                <small class="text-muted small" style="font-size: 0.7rem;">
                                    {{ optional($constancia->estudiante->periodo)->periodo_formateado ?? 'Sin periodo' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border fw-bold">
                                    {{ $constancia->estudiante->calificacion ?? '0' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($constancia->estado == 'emitida')
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3">Emitida</span>
                                @else
                                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning px-3">Pendiente</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('constancias.show', $constancia->id_constancia) }}" class="btn btn-white btn-sm" title="Ver Detalle">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                    <a href="{{ route('constancias.edit', $constancia->id_constancia) }}" class="btn btn-white btn-sm" title="Editar">
                                        <i class="bi bi-pencil-square text-warning"></i>
                                    </a>
                                    <form action="{{ route('constancias.destroy', $constancia->id_constancia) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-white btn-sm text-danger btn-delete" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="{{ asset('img/no-data.svg') }}" alt="" style="width: 100px; opacity: 0.5;">
                                <p class="text-muted mt-3">No hay registros de constancias en el sistema.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script para confirmación de eliminación (SweetAlert2 recomendado) --}}
@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            if(confirm('¿Estás seguro de eliminar este registro? Esta acción no se puede deshacer.')) {
                this.closest('form').submit();
            }
        });
    });
</script>
@endpush

<style>
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .btn-white { background: white; border: 1px solid #dee2e6; }
    .btn-white:hover { background: #f8f9fa; }
    .table thead th { font-size: 0.75rem; letter-spacing: 0.5px; }
    .card { border-radius: 15px; }
</style>
@endsection