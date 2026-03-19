@extends('layouts.admin')

@section('title', 'Gestión de Empresas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Empresas Colaboradoras</h3>
        <p class="text-muted small mb-0">Directorio de instituciones para servicio social</p>
    </div>
    <a href="{{ route('empresas.create') }}" class="btn btn-tesvb shadow-sm">
        <i class="fas fa-building-user me-2"></i> Nueva Empresa
    </a>
</div>

{{-- Alerta de éxito --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-custom border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 100px;">ID</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Nombre de la Empresa</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empresas as $empresa)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-dark border">#{{ $empresa->id_empresa }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light-secondary rounded-circle p-2 me-3 text-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">{{ $empresa->nombre }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('empresas.show', $empresa->id_empresa) }}" class="btn btn-white btn-sm border" title="Ver detalles">
                                    <i class="bi bi-eye text-info"></i>
                                </a>
                                <a href="{{ route('empresas.edit', $empresa->id_empresa) }}" class="btn btn-white btn-sm border" title="Editar">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </a>
                                <button type="button" class="btn btn-white btn-sm border" 
                                        onclick="confirmDelete('{{ $empresa->id_empresa }}', '{{ $empresa->nombre }}')">
                                    <i class="bi bi-trash3 text-danger"></i>
                                </button>
                            </div>

                            {{-- Formulario de eliminación --}}
                            <form id="delete-form-{{ $empresa->id_empresa }}" 
                                  action="{{ route('empresas.destroy', $empresa->id_empresa) }}" 
                                  method="POST" class="d-none">
                                @csrf 
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="bi bi-building-exclamation display-4 d-block mb-3"></i>
                            No hay empresas registradas actualmente.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-light-secondary { background-color: #f1f5f9; }
    .table tbody tr:hover { background-color: rgba(0, 127, 63, 0.02) !important; }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Eliminar empresa?',
            text: `¿Estás seguro de que deseas eliminar a "${nombre}"? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#800020', // Rojo TESVB
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar empresa',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush

@endsection