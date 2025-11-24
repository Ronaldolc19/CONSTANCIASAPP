@extends('layouts.admin')

@section('title', 'Dashboard de Gestión')

@section('content')

<h3 class="mb-4 text-tesvb-red fw-bold">Dashboard </h3>

<hr class="mb-5">

<div class="row g-4 mb-5">

    <div class="col-xl-3 col-md-6">
        <div class="card bg-tesvb-green text-white shadow h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold small">Constancias Emitidas</div>
                        <div class="h2 mb-0 mt-1">{{ $totalConstancias }}</div>
                    </div>
                    <i class="bi bi-file-earmark-check-fill display-5 opacity-50"></i>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('constancias.index') ?? '#' }}">
                <span class="float-start">Ver Detalles</span>
                <span class="float-end"><i class="bi bi-arrow-right-circle-fill"></i></span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white shadow h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold small">Estudiantes Registrados</div>
                        <div class="h2 mb-0 mt-1">{{ $totalEstudiantes }}</div>
                    </div>
                    <i class="bi bi-person-fill display-5 opacity-50"></i>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('estudiantes.index') ?? '#' }}">
                <span class="float-start">Ver Listado</span>
                <span class="float-end"><i class="bi bi-arrow-right-circle-fill"></i></span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-dark shadow h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold small">Carreras Activas</div>
                        <div class="h2 mb-0 mt-1">{{ $totalCarreras }}</div>
                    </div>
                    <i class="bi bi-journals display-5 opacity-50"></i>
                </div>
            </div>
            <a class="card-footer text-dark clearfix small z-1" href="{{ route('carreras.index') ?? '#' }}">
                <span class="float-start">Gestionar Carreras</span>
                <span class="float-end"><i class="bi bi-arrow-right-circle-fill"></i></span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white shadow h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold small">Empresas Colaboradoras</div>
                        <div class="h2 mb-0 mt-1">{{ $totalEmpresas }}</div>
                    </div>
                    <i class="bi bi-building display-5 opacity-50"></i>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('empresas.index') ?? '#' }}">
                <span class="float-start">Ver Empresas</span>
                <span class="float-end"><i class="bi bi-arrow-right-circle-fill"></i></span>
            </a>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark text-white shadow h-100 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold small">Periodos Activos</div>
                        <div class="h2 mb-0 mt-1">{{ $totalPeriodos }}</div>
                    </div>
                    <i class="bi bi-calendar-range display-5 opacity-50"></i>
                </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('periodos.index') ?? '#' }}">
                <span class="float-start">Gestionar Periodos</span>
                <span class="float-end"><i class="bi bi-arrow-right-circle-fill"></i></span>
            </a>
        </div>
    </div>

</div>

<hr class="mb-5">

<div class="row g-4 mb-5">
    
    <div class="col-lg-7">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-bar-chart-fill me-2"></i> Constancias Solicitadas por Mes (Últimos 6)
            </div>
            <div class="card-body">
                {{-- Aquí va el canvas de la Gráfica de Líneas o Barras --}}
                <canvas id="constanciasPorMesChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-pie-chart-fill me-2"></i> Distribución por Carrera
            </div>
            <div class="card-body">
                {{-- Aquí va el canvas de la Gráfica de Pastel --}}
                <canvas id="distribucionCarreraChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
</div>

<hr class="mb-5">

<h4 class="mb-4 text-tesvb-red">Acceso Rápido a Tareas</h4>
<div class="row g-4">
    
    <div class="col-md-4">
        <a href="{{ route('constancias.create') ?? '#' }}" class="card bg-light-green text-dark shadow-sm lift-up text-decoration-none h-100">
            <div class="card-body text-center p-4">
                <i class="bi bi-file-earmark-plus-fill display-4 mb-2 text-tesvb-green"></i>
                <h5 class="card-title fw-bold">Generar Nueva Constancia</h5>
                <p class="card-text small text-muted">Registra una nueva solicitud de servicio social.</p>
            </div>
        </a>
    </div>
    
    <div class="col-md-4">
        <a href="{{ route('estudiantes.create') ?? '#' }}" class="card bg-light-blue text-dark shadow-sm lift-up text-decoration-none h-100">
            <div class="card-body text-center p-4">
                <i class="bi bi-person-plus-fill display-4 mb-2 text-info"></i>
                <h5 class="card-title fw-bold">Añadir Nuevo Estudiante</h5>
                <p class="card-text small text-muted">Registra un nuevo estudiante al sistema.</p>
            </div>
        </a>
    </div>
    
    <div class="col-md-4">
        <a href="{{ route('periodos.create') ?? '#' }}" class="card bg-light-yellow text-dark shadow-sm lift-up text-decoration-none h-100">
            <div class="card-body text-center p-4">
                <i class="bi bi-calendar-event-fill display-4 mb-2 text-warning"></i>
                <h5 class="card-title fw-bold">Crear Nuevo Periodo</h5>
                <p class="card-text small text-muted">Configura las fechas para el siguiente ciclo de servicio.</p>
            </div>
        </a>
    </div>
    
</div>

@endsection

{{-- Bloque para Script (Requiere Chart.js instalado en app.js o vía CDN) --}}
@push('scripts')
<script>
    // Configuración de Gráficos (Esto es un esqueleto, debes llenarlo con datos reales)
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Gráfica de Constancias por Mes
        const ctx1 = document.getElementById('constanciasPorMesChart');
        if (ctx1) {
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Constancias Generadas',
                        data: [12, 19, 3, 5, 2, 3], // Reemplazar con datos de Laravel
                        backgroundColor: 'rgba(0, 127, 63, 0.8)', // Verde TESVB
                        borderColor: 'rgba(0, 127, 63, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        }
        
        // 2. Gráfica de Distribución por Carrera (Ejemplo de Pastel)
        const ctx2 = document.getElementById('distribucionCarreraChart');
        if (ctx2) {
             new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Ing. Sistemas', 'Ing. Industrial', 'Lic. Administración', 'Otras'],
                    datasets: [{
                        label: 'Constancias',
                        data: [30, 20, 15, 35], // Reemplazar con datos de Laravel
                        backgroundColor: [
                            '#007F3F', // Verde TESVB
                            '#F5821F', // Naranja
                            '#800020', // Guinda TESVB
                            '#596677'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }
        
    });
</script>
@endpush