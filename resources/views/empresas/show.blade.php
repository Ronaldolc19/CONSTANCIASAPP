@extends('layouts.admin')

@section('title', 'Detalles de Empresa')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Consultar Empresa</h3>
            <p class="text-muted small mb-0">Información detallada de la institución colaboradora</p>
        </div>
        <a href="{{ route('empresas.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-sm overflow-hidden">
                <div style="height: 5px; background: linear-gradient(90deg, var(--tesvb-green), var(--tesvb-red));"></div>
                
                <div class="card-body p-0">
                    <div class="text-center py-5 bg-light bg-opacity-50 border-bottom">
                        <div class="bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <i class="bi bi-building-fill text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">{{ $empresa->nombre }}</h4>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small">
                            ID de Registro: #{{ $empresa->id_empresa }}
                        </span>
                    </div>

                    
                </div>

               
            </div>
        </div>
    </div>
</div>

<style>
    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .hover-light:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }
</style>

@endsection