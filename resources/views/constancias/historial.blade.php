@extends('layouts.admin')

@section('title', 'Gestión de Expediente')

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- CARD PRINCIPAL DE ACCIÓN --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-success bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                            <i class="bi bi-file-earmark-check fs-1 text-success"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #007F3F;">Expediente de Constancia</h3>
                        <p class="text-muted">Gestión de documentos institucionales</p>
                    </div>

                    <div class="bg-light rounded-4 p-4 mb-4 text-center">
                        <h5 class="fw-bold mb-1 text-dark">
                            {{ $constancia->estudiante->nombre }} {{ $constancia->estudiante->ap }} {{ $constancia->estudiante->am }}
                        </h5>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-hash me-1 text-danger"></i> Folio: {{ $constancia->estudiante->no_folio }}
                            </span>
                            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-card-text me-1 text-primary"></i> Registro: {{ $constancia->estudiante->no_registro }}
                            </span>
                        </div>
                    </div>

                    {{-- BOTONES DE ACCIÓN --}}
                    <div class="d-grid gap-3">
                        @if($constancia->pdf_path)
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ asset('storage/' . $constancia->pdf_path) }}" 
                                       class="btn btn-outline-dark btn-lg w-100 rounded-4 fw-bold shadow-sm" target="_blank">
                                        <i class="bi bi-eye-fill me-2"></i> Ver PDF
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ asset('storage/' . $constancia->pdf_path) }}" 
                                       class="btn btn-success btn-lg w-100 rounded-4 fw-bold shadow-sm" 
                                       download>
                                        <i class="bi bi-download me-2"></i> Descargar
                                    </a>
                                </div>
                            </div>
                        @else
                            <button class="btn btn-light btn-lg w-100 rounded-4 border text-muted" disabled>
                                <i class="bi bi-file-earmark-x me-2"></i> Documento no disponible
                            </button>
                        @endif

                        <a href="{{ route('constancias.general') }}" class="btn btn-link text-muted fw-bold text-decoration-none mt-2">
                            <i class="bi bi-arrow-left me-2"></i> Volver al listado general
                        </a>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; }
    .card { transition: transform 0.2s ease; }
    .btn-lg { padding: 1rem; font-size: 1rem; }
    .rounded-4 { border-radius: 1.25rem !important; }
</style>

@endsection