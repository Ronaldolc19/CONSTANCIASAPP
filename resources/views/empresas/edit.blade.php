@extends('layouts.admin')

@section('title', 'Editar Empresa')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Editar Empresa</h3>
            <p class="text-muted small mb-0">Modifica la información de la institución registrada</p>
        </div>
        <a href="{{ route('empresas.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Cancelar y Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> Actualizar Empresa #{{ $empresa->id_empresa }}
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('empresas.update', $empresa->id_empresa) }}" method="POST" id="edit-empresa-form">
                        @csrf 
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="nombre" class="form-label fw-semibold text-dark">Nombre de la Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-building text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="nombre" 
                                           id="nombre" 
                                           class="form-control border-start-0 ps-0 @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $empresa->nombre) }}" 
                                           placeholder="Ej: Secretaría de Educación Pública"
                                           required>
                                </div>
                                @error('nombre')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="alert alert-info border-0 bg-light-info d-flex align-items-center" role="alert" style="background-color: #e0f7fa;">
                                    <i class="bi bi-info-circle-fill me-2 fs-5 text-info"></i>
                                    <small class="text-muted">Verifique que el nombre coincida exactamente con la razón social oficial de la empresa.</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('empresas.index') }}" class="btn btn-light px-4 me-md-2">Descartar</a>
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
            title: '¿Confirmar cambios?',
            text: "Se actualizará el nombre de la empresa en toda la base de datos.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007F3F', // Verde TESVB
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-empresa-form').submit();
            }
        });
    }
</script>
@endpush