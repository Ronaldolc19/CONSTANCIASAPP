@extends('layouts.admin')

@section('title', 'Gestión de Estudiantes')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Estudiantes</h3>
        <p class="text-muted small mb-0">Expedientes maestros y control de servicio social</p>
    </div>
    <a href="{{ route('estudiantes.create') }}" class="btn btn-tesvb shadow-sm">
        <i class="fas fa-user-plus me-2"></i> Nuevo Estudiante
    </a>
</div>

{{-- Alertas de éxito/error --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- SECCIÓN DE FILTROS AGREGADA --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
    <div class="card-body">
        <form action="{{ route('estudiantes.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted text-uppercase">Búsqueda</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                        placeholder="Nombre o No. Cuenta..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
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
            
            <div class="col-md-3">
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

            <div class="col-md-2 d-flex align-items-end gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Filtrar</button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-light btn-sm border w-50" title="Limpiar">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">No. Cuenta / Folio</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Estudiante</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Carrera / Empresa</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Estatus</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiantes as $est)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $est->no_cuenta }}</div>
                            <small class="text-primary fw-semibold">Folio: {{ $est->no_folio ?? '---' }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 bg-success bg-opacity-10 text-success fw-bold">
                                    {{ substr($est->nombre, 0, 1) }}{{ substr($est->ap, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold mb-0 text-dark">{{ $est->nombre }} {{ $est->ap }} {{ $est->am }}</div>
                                    <small class="text-muted">Reg: {{ $est->no_registro ?? 'Sin registro' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <i class="bi bi-mortarboard me-1 text-muted"></i> {{ optional($est->carrera)->nombre ?? 'Sin carrera' }}
                            </div>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-building me-1"></i> {{ optional($est->empresa)->nombre ?? 'Sin empresa' }}
                            </div>
                        </td>
                        <td class="text-center">
                            @php $constancia = $est->constancias->last(); @endphp
                            @if($constancia)
                                <span class="badge rounded-pill {{ $constancia->estado == 'emitida' ? 'bg-success' : 'bg-warning text-dark' }} p-2 px-3">
                                    <i class="bi {{ $constancia->estado == 'emitida' ? 'bi-check-all' : 'bi-clock-history' }} me-1"></i>
                                    {{ ucfirst($constancia->estado) }}
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill p-2 px-3">Sin Trámite</span>
                            @endif
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('estudiantes.show', $est->id_estudiante) }}" class="btn btn-white btn-sm border" title="Ver Expediente">
                                    <i class="bi bi-person-lines-fill text-info"></i>
                                </a>
                                <a href="{{ route('estudiantes.edit', $est->id_estudiante) }}" class="btn btn-white btn-sm border" title="Editar">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </a>
                                
                                <form action="{{ route('estudiantes.destroy', $est->id_estudiante) }}" method="POST" class="d-inline form-eliminar">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn btn-white btn-sm border btn-confirmar-borrado" 
                                            data-nombre="{{ $est->nombre }} {{ $est->ap }}">
                                        <i class="bi bi-trash3 text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-3"></i>
                            No se encontraron estudiantes con los filtros aplicados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Paginación manteniendo filtros --}}
<div class="d-flex justify-content-center mt-4">
    {{ $estudiantes->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<style>
    .avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 127, 63, 0.02) !important;
    }
    .badge {
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }
    .btn-white { background: #fff; }
    .btn-white:hover { background: #f8f9fa; }
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Tu script original de confirmación se mantiene igual
</script>
@endpush