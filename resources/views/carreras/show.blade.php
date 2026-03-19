@extends('layouts.admin')

@section('title', 'Detalles de la Carrera')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Consultar Carrera</h3>
            <p class="text-muted small mb-0">Información del programa académico registrado</p>
        </div>
        <a href="{{ route('carreras.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-sm overflow-hidden">
                <div style="height: 5px; background: linear-gradient(90deg, var(--tesvb-green), var(--tesvb-red));"></div>
                
                <div class="card-body p-0">
                    <div class="text-center py-5 bg-light bg-opacity-30 border-bottom">
                        <div class="bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border: 3px solid rgba(0, 127, 63, 0.1);">
                            <i class="bi bi-mortarboard-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1 px-4">{{ $carrera->nombre }}</h4>
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill small mt-2">
                            ID Carrera: #{{ $carrera->id_carrera }}
                        </span>
                    </div>

                    
                </div>

                
            </div>
        </div>
    </div>
</div>

<style>
    .icon-square {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        background-color: #f8f9fa;
    }
    .hover-effect:hover {
        background-color: rgba(0,0,0,0.02);
        transition: 0.3s ease;
    }
</style>

@endsection