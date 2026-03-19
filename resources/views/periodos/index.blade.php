@extends('layouts.admin')

@section('title', 'Gestión de Periodos')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Periodos </h3>
        <p class="text-muted small mb-0">Administración de ciclos para servicio social</p>
    </div>
    <a href="{{ route('periodos.create') }}" class="btn btn-tesvb shadow-sm">
        <i class="fas fa-plus-circle me-2"></i> Nuevo Periodo
    </a>
</div>

<div class="card card-custom border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 100px;">ID</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Fecha de Inicio</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Fecha de Término</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periodos as $periodo)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-dark border">#{{ $periodo->id_periodo }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-check text-success me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d M, Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-x text-danger me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d M, Y') }}</span>
                            </div>
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group shadow-sm" role="group">
                                <a href="{{ route('periodos.show', $periodo->id_periodo) }}" class="btn btn-white btn-sm border" title="Ver detalles">
                                    <i class="bi bi-eye text-info"></i>
                                </a>
                                <a href="{{ route('periodos.edit', $periodo->id_periodo) }}" class="btn btn-white btn-sm border" title="Editar">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </a>
                                <button type="button" class="btn btn-white btn-sm border" title="Eliminar" 
                                        onclick="confirmDelete('{{ $periodo->id_periodo }}')">
                                    <i class="bi bi-trash3 text-danger"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $periodo->id_periodo }}" action="{{ route('periodos.destroy', $periodo->id_periodo) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x display-4 d-block mb-3"></i>
                            No se encontraron periodos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Estilos específicos para la tabla */
    .table thead th {
        font-size: 0.75rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .table tbody tr {
        transition: all 0.2s;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 127, 63, 0.02) !important;
    }
    .btn-group .btn:hover {
        background-color: #f8f9fa;
        z-index: 2;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#007F3F',
            cancelButtonColor: '#800020',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush

@endsection