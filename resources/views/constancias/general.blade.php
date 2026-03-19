@extends('layouts.admin')

@section('title', 'Vista General de Constancias')

@section('content')

<div class="container-fluid py-3">
    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0" style="color: #007F3F;">Control de Constancias</h3>
            <p class="text-muted small mb-0">El estado cambia a <b class="text-success">Emitida</b> al generar el documento.</p>
        </div>
        {{-- Redirección al flujo de nuevo estudiante --}}
        <a href="{{ route('estudiantes.create') }}" class="btn btn-success shadow-sm fw-bold">
            <i class="bi bi-plus-circle me-2"></i> Nueva Constancia
        </a>
    </div>

    {{-- CARDS INFORMATIVAS COMPACTAS --}}
    <div class="row g-2 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #007F3F !important;">
                <div class="card-body py-2 px-3">
                    <span class="text-muted small fw-bold text-uppercase">Total</span>
                    <h4 class="fw-bold mb-0">{{ $constancias->total() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #198754 !important;">
                <div class="card-body py-2 px-3">
                    <span class="text-muted small fw-bold text-uppercase">Emitidas</span>
                    <h4 class="fw-bold mb-0 text-success">
                        {{ $constancias->where('estado', 'emitida')->count() }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #ffc107 !important;">
                <div class="card-body py-2 px-3">
                    <span class="text-muted small fw-bold text-uppercase">Pendientes</span>
                    <h4 class="fw-bold mb-0 text-warning">
                        {{ $constancias->where('estado', 'pendiente')->count() }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE FILTROS COMPLETOS --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body">
            <form action="{{ route('constancias.general') }}" method="GET" class="row g-2">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Estudiante</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" 
                            placeholder="Nombre o cuenta..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Carrera</label>
                    <select name="id_carrera" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id_carrera }}" {{ request('id_carrera') == $carrera->id_carrera ? 'selected' : '' }}>
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Empresa</label>
                    <select name="id_empresa" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach($empresas as $emp)
                            <option value="{{ $emp->id_empresa }}" {{ request('id_empresa') == $emp->id_empresa ? 'selected' : '' }}>
                                {{ $emp->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Estado</label>
                    <select name="estado" class="form-select form-select-sm">
                        <option value="">Cualquiera</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="emitida" {{ request('estado') == 'emitida' ? 'selected' : '' }}>Emitida</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Filtrar</button>
                    <a href="{{ route('constancias.general') }}" class="btn btn-light btn-sm border w-50" title="Limpiar">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr class="text-center small text-uppercase">
                        <th class="py-3 ps-3">No. Cuenta</th>
                        <th class="py-3 text-start">Estudiante</th>
                        <th class="py-3">Reg. / Folio</th>
                        <th class="py-3">Estado</th>
                        <th class="py-3 text-start">Detalles Académicos</th>
                        <th class="py-3 pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($constancias as $c)
                    <tr>
                        <td class="text-center fw-bold small ps-3">{{ $c->estudiante->no_cuenta }}</td>
                        <td class="text-start">
                            <div class="fw-bold text-dark">{{ $c->estudiante->nombre }} {{ $c->estudiante->ap }}</div>
                            <small class="text-muted"><i class="bi bi-building me-1"></i>{{ optional($c->estudiante->empresa)->nombre ?? 'Sin empresa' }}</small>
                        </td>
                        <td class="text-center small">
                            <span class="d-block text-muted">R: {{ $c->estudiante->no_registro }}</span>
                            <span class="d-block fw-bold text-danger">F: {{ $c->estudiante->no_folio }}</span>
                        </td>
                        
                        <td class="text-center">
                            @if($c->estado == 'emitida')
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-check-all me-1"></i> Emitida
                                </span>
                            @else
                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning-subtle px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> Pendiente
                                </span>
                            @endif
                        </td>

                        <td class="text-start small">
                            <div class="fw-bold text-truncate" style="max-width: 180px; color: #007F3F;">
                                {{ optional($c->estudiante->carrera)->nombre ?? 'N/A' }}
                            </div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                {{ optional($c->estudiante->periodo)->periodo_formateado ?? 'Sin periodo' }}
                            </div>
                        </td>

                        <td class="text-center pe-3">
                            <div class="btn-group shadow-sm border rounded bg-white">
                                {{-- Generar Documento (Icono PDF Rojo Restaurado) --}}
                                @if($c->estado !== 'emitida')
                                    <a href="{{ route('constancias.docx', $c->id_constancia) }}" 
                                    class="btn btn-white btn-sm py-2 px-2 border-end" title="Generar Documento">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                    </a>
                                @else
                                    <div class="btn btn-white btn-sm py-2 px-2 border-end text-success pe-none">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                @endif

                                <a href="{{ route('constancias.show', $c->id_constancia) }}" class="btn btn-white btn-sm py-2 px-2 border-end" title="Detalles">
                                    <i class="bi bi-eye-fill text-info"></i>
                                </a>

                                <a href="{{ route('constancias.edit', $c->id_constancia) }}" class="btn btn-white btn-sm py-2 px-2 border-end" title="Editar">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </a>

                                <a href="{{ route('constancias.historial', $c->id_constancia) }}" class="btn btn-white btn-sm py-2 px-2 border-end" title="Historial">
                                    <i class="bi bi-clock-history text-primary"></i>
                                </a>

                                <form action="{{ route('constancias.destroy', $c->id_constancia) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm py-2 px-2" title="Eliminar">
                                        <i class="bi bi-trash3-fill text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-search d-block mb-2 fs-2"></i>
                            No se encontraron registros.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINACIÓN CON ESTILO AZUL BOOTSTRAP --}}
    <div class="mt-4 d-flex justify-content-center custom-pagination">
        @if ($constancias instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $constancias->appends(request()->query())->links('pagination::bootstrap-5') }}
        @endif
    </div>
</div>

<style>
    .btn-white { background: #fff; border: none; transition: 0.2s; }
    .btn-white:hover { background: #f8f9fa; color: inherit; }
    .badge { font-weight: 600; font-size: 0.75rem; }
    .table-hover tbody tr:hover { background-color: rgba(0, 127, 63, 0.02); }
    .card h4 { font-size: 1.4rem; }

    /* Ajuste para que la paginación sea pequeña y azul */
    .custom-pagination .pagination {
        margin-bottom: 0;
    }
    .custom-pagination .page-link {
        padding: 0.4rem 0.75rem;
        font-size: 0.85rem;
        color: #0d6efd; /* Color azul Bootstrap */
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
</style>

@endsection