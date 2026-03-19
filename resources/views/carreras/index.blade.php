@extends('layouts.admin')

@section('title', 'Gestión de Carreras')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Carreras</h3>
        <p class="text-muted small mb-0">Oferta educativa del plantel</p>
    </div>
    <a href="{{ route('carreras.create') }}" class="btn btn-tesvb shadow-sm">
        <i class="fas fa-graduation-cap me-2"></i> Nueva Carrera
    </a>
</div>

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
                        <th class="py-3 text-uppercase small fw-bold text-muted">Nombre de la Carrera</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($carreras as $carrera)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-dark border">#{{ $carrera->id_carrera }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light-info rounded-circle p-2 me-3 text-info d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e3f2fd;">
                                    <i class="bi bi-book"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $carrera->nombre }}</span>
                            </div>
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('carreras.show', $carrera->id_carrera) }}" class="btn btn-white btn-sm border" title="Ver">
                                    <i class="bi bi-eye text-info"></i>
                                </a>
                                <a href="{{ route('carreras.edit', $carrera->id_carrera) }}" class="btn btn-white btn-sm border" title="Editar">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </a>
                                
                                {{-- Formulario de eliminación integrado --}}
                                <form action="{{ route('carreras.destroy', $carrera->id_carrera) }}" method="POST" class="d-inline form-eliminar">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn btn-white btn-sm border btn-confirmar-borrado" data-nombre="{{ $carrera->nombre }}">
                                        <i class="bi bi-trash3 text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">No hay carreras registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-confirmar-borrado')) {
            const boton = e.target.closest('.btn-confirmar-borrado');
            const formulario = boton.closest('.form-eliminar');
            const nombre = boton.getAttribute('data-nombre');

            Swal.fire({
                title: '¿Eliminar carrera?',
                text: `¿Estás seguro de borrar "${nombre}"? Esta acción podría afectar a los alumnos inscritos.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#800020',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit();
                }
            });
        }
    });
</script>
@endpush

@endsection