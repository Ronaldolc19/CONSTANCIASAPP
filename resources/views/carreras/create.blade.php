@extends('layouts.admin')

@section('title', 'Nueva Carrera')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Registrar Carrera</h3>
            <p class="text-muted small mb-0">Agrega un nuevo programa académico al catálogo</p>
        </div>
        <a href="{{ route('carreras.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-book-half me-2 text-success"></i> Datos de la Carrera
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('carreras.store') }}" method="POST" id="create-carrera-form">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="nombre" class="form-label fw-semibold text-dark">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-mortarboard text-muted"></i>
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
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('carreras.index') }}" class="btn btn-light px-4 me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-tesvb px-5 shadow">
                                <i class="fas fa-save me-2"></i> Guardar Carrera
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-light border shadow-sm mt-4 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill text-info me-3 fs-4"></i>
                    <small class="text-muted">
                        Asegúrese de escribir el nombre de la carrera sin abreviaturas para que aparezca correctamente en las constancias oficiales.
                    </small>
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