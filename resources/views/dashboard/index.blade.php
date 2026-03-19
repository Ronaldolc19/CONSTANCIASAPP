@extends('layouts.admin')

@section('title', 'Dashboard Profesional')

@section('content')
<div class="container-fluid py-4">
    
    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #007F3F;">Panel de Control</h2>
            <p class="text-muted mb-0">Análisis estadístico de gestión académica</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportarInforme()" class="btn btn-danger shadow-sm d-flex align-items-center fw-bold">
                <i class="bi bi-file-earmark-pdf me-2"></i> Descargar Informe Técnico
            </button>
            <div class="bg-white border rounded px-3 py-2 shadow-sm d-flex align-items-center">
                <i class="bi bi-clock-fill text-success me-2"></i>
                <span class="small fw-bold">{{ now()->translatedFormat('d F, Y') }}</span>
            </div>
        </div>
    </div>

    {{-- INDICADORES CLAVE (KPIs) --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label' => 'Constancias', 'val' => $totalConstancias, 'icon' => 'bi-file-earmark-check', 'color' => '#007F3F'],
                ['label' => 'Estudiantes', 'val' => $totalEstudiantes, 'icon' => 'bi-people', 'color' => '#0dcaf0'],
                ['label' => 'Empresas', 'val' => $totalEmpresas, 'icon' => 'bi-building', 'color' => '#800020'],
                ['label' => 'Ciclos', 'val' => $totalPeriodos, 'icon' => 'bi-calendar-range', 'color' => '#ffc107']
            ];
        @endphp
        @foreach($cards as $c)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm card-kpi h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">{{ $c['label'] }}</span>
                            <h2 class="fw-bold mb-0">{{ $c['val'] }}</h2>
                        </div>
                        <div class="icon-circle" style="background: {{ $c['color'] }}20; color: {{ $c['color'] }};">
                            <i class="bi {{ $c['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- SECCIÓN DE GRÁFICAS --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill me-2 text-success"></i>Constancias por Período Académico</h6>
                </div>
                <div class="card-body">
                    <canvas id="periodosChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart-fill me-2 text-success"></i>Por Carrera</h6>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="distribucionCarreraChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-building-check me-2 text-danger"></i>Uso de Empresas (Top 10)</h6>
                </div>
                <div class="card-body">
                    <canvas id="empresasChart" height="280"></canvas>
                </div>
            </div>
        </div>

        {{-- ACCIONES RÁPIDAS --}}
        <div class="col-lg-5">
            <h6 class="fw-bold mb-3 text-muted small text-uppercase"><i class="bi bi-lightning-charge-fill me-1"></i> Accesos Directos</h6>
            <div class="row g-2">
                <div class="col-12">
                    <a href="{{ route('constancias.general') }}" class="btn-action shadow-sm border rounded-4 d-flex align-items-center p-3 text-decoration-none">
                        <div class="bg-danger-subtle text-danger rounded-3 p-2 me-3">
                            <i class="bi bi-file-earmark-pdf-fill fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Generación de Documentos</strong>
                            <small class="text-muted">Emitir y descargar constancias en PDF</small>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('empresas.create') }}" class="btn-action shadow-sm border rounded-4 d-flex align-items-center p-3 text-decoration-none">
                        <div class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                            <i class="bi bi-building-add fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Nueva Empresa</strong>
                            <small class="text-muted">Registrar convenios o sedes nuevas</small>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('periodos.create') }}" class="btn-action shadow-sm border rounded-4 d-flex align-items-center p-3 text-decoration-none">
                        <div class="bg-warning-subtle text-warning rounded-3 p-2 me-3">
                            <i class="bi bi-calendar-plus fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Configurar Período</strong>
                            <small class="text-muted">Apertura de nuevos ciclos escolares</small>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <a href="{{ route('estudiantes.create') }}" class="btn-action shadow-sm border rounded-4 d-flex align-items-center p-3 text-decoration-none">
                        <div class="bg-success-subtle text-success rounded-3 p-2 me-3">
                            <i class="bi bi-person-plus-fill fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Alta de Estudiante</strong>
                            <small class="text-muted">Registrar datos de alumnos nuevos</small>
                        </div>
                    </a>
                </div>
                
                {{-- BOTÓN DE REINICIO --}}
                <div class="col-12 mt-2">
                    <form action="{{ route('dashboard.reiniciar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de reiniciar el ciclo? Todas las constancias actuales se archivarán y el dashboard volverá a cero.')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-4 p-2 fw-bold border-dashed">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Reiniciar Ciclo Escolar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-kpi { border-radius: 15px; transition: transform 0.2s; }
    .card-kpi:hover { transform: translateY(-5px); }
    .icon-circle { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
    .btn-action { background: #fff; transition: all 0.2s; }
    .btn-action:hover { background: #f8fdf9; border-color: #007F3F !important; transform: scale(1.02); }
    .bg-danger-subtle { background-color: #f8d7da; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colors = ['#007F3F', '#800020', '#F5821F', '#0dcaf0', '#6610f2', '#6c757d', '#d63384'];

        // Gráficas (Almacenamos en constantes para poder exportarlas)
        const chartP = new Chart(document.getElementById('periodosChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($periodosLabels) !!},
                datasets: [{ label: 'Constancias', data: {!! json_encode($periodosData) !!}, backgroundColor: '#007F3F', borderRadius: 8 }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        const chartC = new Chart(document.getElementById('distribucionCarreraChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($carrerasLabels) !!},
                datasets: [{ data: {!! json_encode($carrerasData) !!}, backgroundColor: colors }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom' } } }
        });

        new Chart(document.getElementById('empresasChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($empresasLabels) !!},
                datasets: [{ label: 'Alumnos', data: {!! json_encode($empresasData) !!}, backgroundColor: '#800020', borderRadius: 5 }]
            },
            options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    });

    // FUNCIÓN PARA EXPORTAR PDF CON GRÁFICAS
    function exportarInforme() {
        // Captura de los 3 canvas
        const imgPeriodos = document.getElementById('periodosChart').toDataURL('image/png');
        const imgCarreras = document.getElementById('distribucionCarreraChart').toDataURL('image/png');
        const imgEmpresas = document.getElementById('empresasChart').toDataURL('image/png');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('dashboard.pdf') }}";
        form.innerHTML = `
            @csrf
            <input type="hidden" name="imgPeriodos" value="${imgPeriodos}">
            <input type="hidden" name="imgCarreras" value="${imgCarreras}">
            <input type="hidden" name="imgEmpresas" value="${imgEmpresas}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush