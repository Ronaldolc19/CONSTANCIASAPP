@extends('layouts.admin')

@section('title', 'Nuevo Periodo')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Registrar Periodo</h3>
            <p class="text-muted small mb-0">Define las fechas para el nuevo ciclo académico</p>
        </div>
        <a href="{{ route('periodos.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0"><i class="bi bi-calendar-plus me-2 text-success"></i> Datos del Periodo</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('periodos.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="fecha_inicio" class="form-label fw-semibold">Fecha de Inicio</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                           class="form-control border-start-0 ps-0 @error('fecha_inicio') is-invalid @enderror" 
                                           value="{{ old('fecha_inicio') }}" required>
                                </div>
                                @error('fecha_inicio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="fecha_fin" class="form-label fw-semibold">Fecha de Término</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" name="fecha_fin" id="fecha_fin" 
                                           class="form-control border-start-0 ps-0 @error('fecha_fin') is-invalid @enderror" 
                                           value="{{ old('fecha_fin') }}" required>
                                </div>
                                @error('fecha_fin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('periodos.index') }}" class="btn btn-light px-4 me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-tesvb px-5 shadow">
                                <i class="fas fa-save me-2"></i> Guardar Periodo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para inputs */
    .form-control:focus {
        border-color: var(--tesvb-green);
        box-shadow: 0 0 0 0.25rem rgba(0, 127, 63, 0.1);
    }
    .input-group-text {
        color: #64748b;
        background-color: #f8f9fa;
    }
    .bg-light-info {
        background-color: #e0f7fa;
    }
</style>

@endsection