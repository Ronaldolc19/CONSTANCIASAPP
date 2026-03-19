@extends('layouts.admin')

@section('title', 'Editar Carrera')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Editar Carrera</h3>
            <p class="text-muted small mb-0">Modifica el nombre oficial del programa académico</p>
        </div>
        <a href="{{ route('carreras.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Cancelar y Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> Actualizar Carrera #{{ $carrera->id_carrera }}
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('carreras.update', $carrera->id_carrera) }}" method="POST" id="edit-carrera-form">
                        @csrf 
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="nombre" class="form-label fw-semibold text-dark">Nombre de la Carrera</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-mortarboard text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="nombre" 
                                           id="nombre" 
                                           class="form-control border-start-0 ps-0 @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $carrera->nombre) }}" 
                                           required>
                                </div>
                                @error('nombre')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-warning"></i>
                                    <small class="text-dark">
                                        <strong>Nota:</strong> Si cambia el nombre, se actualizará automáticamente en el perfil de todos los estudiantes asociados.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('carreras.index') }}" class="btn btn-light px-4 me-md-2">Descartar</a>
                            <button type="button" class="btn btn-success px-5 shadow" onclick="confirmUpdate()">
                                <i class="fas fa-sync-alt me-2"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: var(--tesvb-green);
        box-shadow: 0 0 0 0.25rem rgba(0, 127, 63, 0.1);
    }
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmUpdate() {
        Swal.fire({
            title: '¿Deseas actualizar la carrera?',
            text: "Este cambio será visible en todos los módulos del sistema.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007F3F', // Verde TESVB
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-carrera-form').submit();
            }
        });
    }
</script>
@endpush