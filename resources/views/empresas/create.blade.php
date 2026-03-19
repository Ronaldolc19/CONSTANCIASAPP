@extends('layouts.admin')

@section('title', 'Nueva Empresa')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Registrar Nueva Empresa</h3>
            <p class="text-muted small mb-0">Agrega una institución para convenios de servicio social</p>
        </div>
        <a href="{{ route('empresas.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-building-add me-2 text-success"></i> Información Institucional
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('empresas.store') }}" method="POST">
                        @csrf
                        
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
                                           
                                           value="{{ old('nombre') }}" 
                                           required>
                                </div>
                                @error('nombre')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                                <div class="form-text mt-2">
                                    Escriba el nombre completo de la institución o empresa.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('empresas.index') }}" class="btn btn-light px-4 me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-tesvb px-5 shadow">
                                <i class="fas fa-save me-2"></i> Guardar Empresa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="alert alert-light border shadow-sm mt-4 p-3 d-flex align-items-center">
                <i class="bi bi-info-circle-fill text-info me-3 fs-4"></i>
                <small class="text-muted">
                    Una vez registrada, la empresa podrá ser asignada a los estudiantes para la generación de sus constancias de servicio social.
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    /* Efecto de foco personalizado */
    .form-control:focus {
        border-color: var(--tesvb-green);
        box-shadow: 0 0 0 0.25rem rgba(0, 127, 63, 0.1);
    }
    .input-group-text {
        color: #64748b;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
</style>

@endsection