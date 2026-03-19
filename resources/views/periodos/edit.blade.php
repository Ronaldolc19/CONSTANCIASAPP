@extends('layouts.admin')

@section('title', 'Editar Periodo')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Editar Periodo #{{ $periodo->id_periodo }}</h3>
            <p class="text-muted small mb-0">Modifica las fechas establecidas para este ciclo</p>
        </div>
        <a href="{{ route('periodos.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Cancelar y Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> Actualizar Información
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('periodos.update', $periodo->id_periodo) }}" method="POST" id="edit-periodo-form">
                        @csrf 
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="fecha_inicio" class="form-label fw-semibold">Fecha de Inicio Actual</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                           class="form-control border-start-0 ps-0" 
                                           value="{{ $periodo->fecha_inicio }}" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="fecha_fin" class="form-label fw-semibold">Fecha de Término Actual</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" name="fecha_fin" id="fecha_fin" 
                                           class="form-control border-start-0 ps-0" 
                                           value="{{ $periodo->fecha_fin }}" required>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-warning"></i>
                                    <small class="text-dark">Al actualizar, los cambios se verán reflejados en todas las constancias asociadas a este periodo.</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('periodos.index') }}" class="btn btn-light px-4 me-md-2">Descartar</a>
                            <button type="button" class="btn btn-success px-5 shadow" onclick="confirmUpdate()">
                                <i class="fas fa-sync-alt me-2"></i> Actualizar Periodo
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
            title: '¿Deseas actualizar el periodo?',
            text: "Se guardarán los nuevos rangos de fechas en el sistema.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007F3F', // Verde TESVB
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar de nuevo',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviamos el formulario manualmente
                document.getElementById('edit-periodo-form').submit();
            }
        });
    }
</script>
@endpush