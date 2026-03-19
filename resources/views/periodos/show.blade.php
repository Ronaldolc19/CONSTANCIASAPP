@extends('layouts.admin')

@section('title', 'Consultar Periodo')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Detalles del Periodo</h3>
            <p class="text-muted small mb-0">Visualización de la configuración del ciclo seleccionado</p>
        </div>
        <a href="{{ route('periodos.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-info-square-fill text-success fs-5"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Información del Registro</h6>
                </div>
                
                <div class="card-body p-0">
                    <div class="d-flex align-items-center p-4 border-bottom">
                        <div class="text-muted small fw-bold text-uppercase" style="width: 150px;">ID Registro</div>
                        <div class="fw-bold text-dark">#{{ $periodo->id_periodo }}</div>
                    </div>

                    <div class="d-flex align-items-center p-4 border-bottom">
                        <div class="text-muted small fw-bold text-uppercase" style="width: 150px;">Fecha de Inicio</div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check text-success me-2 fs-5"></i>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($periodo->fecha_inicio)->isoFormat('LL') }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center p-4 border-bottom">
                        <div class="text-muted small fw-bold text-uppercase" style="width: 150px;">Fecha de Fin</div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-x text-danger me-2 fs-5"></i>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($periodo->fecha_fin)->isoFormat('LL') }}</span>
                        </div>
                    </div>

                    
                </div>

                
            </div>
        </div>
    </div>
</div>

@endsection