@extends('layouts.admin')

@section('title', 'Nuevo Estudiante')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #007F3F;">Registrar Estudiante</h3>
            
        </div>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-light border shadow-sm px-4 rounded-3">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    {{-- Alertas de Validación --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-4">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li><i class="bi bi-exclamation-circle me-2"></i> {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('estudiantes.store') }}" method="POST" id="create-estudiante-form">
        @csrf

        <div class="row g-4">
            {{-- SECCIÓN 1: DATOS PERSONALES Y ACADÉMICOS --}}
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-person-check-fill me-2"></i>Información del Alumno</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">No. de Cuenta</label>
                                <input type="text" name="no_cuenta" class="form-control rounded-3 border-light-subtle @error('no_cuenta') is-invalid @enderror" value="{{ old('no_cuenta') }}" required placeholder="Ej. 20241010">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control rounded-3 border-light-subtle" value="{{ old('nombre') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Apellido Paterno</label>
                                <input type="text" name="ap" class="form-control rounded-3 border-light-subtle" value="{{ old('ap') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Apellido Materno</label>
                                <input type="text" name="am" class="form-control rounded-3 border-light-subtle" value="{{ old('am') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted text-uppercase">Carrera</label>
                                <select name="id_carrera" class="form-select rounded-3 shadow-sm border-light-subtle" required>
                                    <option value="">-- Seleccionar carrera --</option>
                                    @foreach($carreras as $c)
                                        <option value="{{ $c->id_carrera }}" {{ old('id_carrera') == $c->id_carrera ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Género</label>
                                <select name="genero" class="form-select rounded-3 border-light-subtle" required>
                                    <option value="">-- Seleccionar --</option>
                                    <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 2: VINCULACIÓN Y EVALUACIÓN --}}
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-briefcase-fill me-2"></i>Vinculación y Certificación</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            {{-- Empresa con Buscador Intuitivo --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Empresa / Institución Receptora</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-success"></i></span>
                                    <input list="datalist-empresas" id="input-empresa" class="form-control border-start-0 ps-0 rounded-end-3" placeholder="Buscar empresa..." autocomplete="off">
                                </div>
                                <input type="hidden" name="id_empresa" id="hidden-id-empresa" value="{{ old('id_empresa') }}">
                                <datalist id="datalist-empresas">
                                    @foreach($empresas as $emp)
                                        <option data-id="{{ $emp->id_empresa }}" value="{{ $emp->nombre }}">
                                    @endforeach
                                </datalist>
                                <small class="text-muted italic d-block mt-1">Si no aparece, verifique que la empresa esté registrada.</small>
                            </div>

                            {{-- Periodo --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Periodo de Servicio</label>
                                <select name="id_periodo" class="form-select rounded-3 shadow-sm border-light-subtle" required id="selectPeriodo">
                                    <option value="">-- Seleccionar periodo vigente --</option>
                                    @foreach($periodos as $p)
                                        <option value="{{ $p->id_periodo }}"
                                            data-inicio="{{ $p->fecha_inicio }}"
                                            data-fin="{{ $p->fecha_fin }}"
                                            {{ old('id_periodo') == $p->id_periodo ? 'selected' : '' }}>
                                            Cargando fechas...
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Calificación con Guía Visual --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Calificación Obtenida</label>
                                <div class="d-flex align-items-start gap-3">
                                    <select name="calificacion" class="form-select rounded-3 border-success fw-bold shadow-sm" style="width: 200px;">
                                        <option value="">-- Seleccione --</option>
                                        <option value="97" {{ old('calificacion') == '97' ? 'selected' : '' }}>97</option>
                                        <option value="90" {{ old('calificacion') == '90' ? 'selected' : '' }}>90</option>
                                        <option value="80" {{ old('calificacion') == '80' ? 'selected' : '' }}>80</option>
                                    </select>
                                    <div class="alert alert-success border-0 py-2 px-3 small rounded-3 mb-0 shadow-sm flex-grow-1">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <strong>Escala:</strong><br>
                                        97 - EXCELENTE | 90 - MUY BIEN | 80 - BIEN
                                    </div>
                                </div>
                            </div>

                            {{-- Folios --}}
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">No. Registro</label>
                                <input type="text" id="no_registro" name="no_registro" 
                                    class="form-control fw-bold bg-light rounded-3 border-success-subtle shadow-sm" 
                                    value="{{ old('no_registro') }}" readonly placeholder="Automático">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">No. Folio</label>
                                <div class="input-group">
                                    <input type="text" id="no_folio" name="no_folio" 
                                        class="form-control fw-bold bg-light rounded-start-3 border-danger-subtle text-danger shadow-sm" 
                                        value="{{ old('no_folio') }}" readonly placeholder="Automático">
                                    <button type="button" class="btn btn-outline-danger border-danger-subtle" onclick="generarNumeros()" title="Refrescar folios">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-12 text-end mt-3">
                                <div class="p-3 bg-light rounded-4 d-inline-block shadow-sm">
                                    <label class="small fw-bold text-uppercase text-muted me-2">Fecha de Emisión:</label>
                                    <input type="date" name="fecha_emision" class="form-control d-inline-block border-0 bg-transparent fw-bold text-success w-auto" value="{{ old('fecha_emision', date('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 mb-5 d-flex justify-content-end gap-3">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Cancelar</a>
            <button type="submit" class="btn btn-success px-5 py-2 shadow-sm rounded-pill">
                <i class="fas fa-save me-2"></i> Guardar y Finalizar Registro
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Formateador de fechas para el select de periodos
    function formatFecha(fecha) {
        if(!fecha) return '';
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        const d = new Date(fecha + "T00:00:00");
        return d.getDate() + " de " + meses[d.getMonth()] + " de " + d.getFullYear();
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Lógica del Datalist para Empresa (más intuitivo)
        const inputEmpresa = document.getElementById('input-empresa');
        const dlEmpresa = document.getElementById('datalist-empresas');
        const hiddenEmpresa = document.getElementById('hidden-id-empresa');

        inputEmpresa.addEventListener('input', function() {
            const opt = Array.from(dlEmpresa.options).find(o => o.value === this.value);
            hiddenEmpresa.value = opt ? opt.getAttribute('data-id') : "";
        });

        // Formatear opciones del select de periodos
        const select = document.getElementById('selectPeriodo');
        [...select.options].forEach(opt => {
            const inicio = opt.getAttribute('data-inicio');
            const fin = opt.getAttribute('data-fin');
            if (inicio && fin) opt.textContent = `Periodo: ${formatFecha(inicio)} - ${formatFecha(fin)}`;
        });

        // Generar folios automáticamente al cargar si no hay datos de sesión (old)
        if (!document.getElementById('no_registro').value) {
            generarNumeros();
        }
    });

    function generarNumeros() {
        const btnIcon = document.querySelector('button[onclick="generarNumeros()"] i');
        if(btnIcon) btnIcon.classList.add('fa-spin');

        // IMPORTANTE: Asegúrate que esta ruta exista en tu web.php
        fetch("{{ route('estudiantes.generarNumeros') }}", { 
            method: 'GET',
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            } 
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Asignación de valores recibidos del controlador
            if (data.no_registro) document.getElementById('no_registro').value = data.no_registro;
            if (data.no_folio) document.getElementById('no_folio').value = data.no_folio;
            
            // Notificación pequeña (Toast)
            Swal.fire({
                toast: true, position: 'top-end', icon: 'success',
                title: 'Folios generados', showConfirmButton: false, timer: 1500
            });
        })
        .catch(err => {
            console.error('Error:', err);
            Swal.fire('Atención', 'No se pudo conectar con el servidor para generar folios. Ingrese manualmente si es necesario.', 'warning');
            // Si falla el fetch, removemos el readonly para permitir entrada manual de emergencia
            document.getElementById('no_registro').readOnly = false;
            document.getElementById('no_folio').readOnly = false;
        })
        .finally(() => {
            if(btnIcon) btnIcon.classList.remove('fa-spin');
        });
    }
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #007F3F;
        box-shadow: 0 0 0 0.25rem rgba(0, 127, 63, 0.1);
    }
    .input-group-text { border-radius: 12px 0 0 12px; }
    .card { border-radius: 20px; transition: all 0.3s ease; }
    .btn-success { background-color: #007F3F; border: none; }
    .btn-success:hover { background-color: #006633; transform: translateY(-1px); }
</style>
@endpush
@endsection