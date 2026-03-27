@extends('layouts.admin')

@section('title', 'Editar Expediente - ' . $constancia->estudiante->no_cuenta)

@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #007F3F;">Editar Expediente</h3>
            <p class="text-muted small mb-0">Gestión centralizada de datos y folios oficiales</p>
        </div>
        {{-- REDIRECCIÓN: Volver a la tabla general de constancias --}}
        <a href="{{ route('constancias.general') }}" class="btn btn-light border shadow-sm px-4 rounded-3">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            {{-- ACTION: Apunta al update de Constancias --}}
            <form action="{{ route('constancias.update', $constancia->id_constancia) }}" method="POST" id="edit-estudiante-form">
                @csrf 
                @method('PUT')

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="bi bi-pencil-square text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Modificando Registro: {{ $constancia->estudiante->no_cuenta }}</h6>
                                <small class="text-muted">Asegúrese de validar los folios antes de guardar</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        {{-- SECCIÓN 1: DATOS PERSONALES --}}
                        <div class="row mb-5">
                            <div class="col-md-3">
                                <h6 class="fw-bold text-uppercase small text-success mb-3">1. Datos Personales</h6>
                                <p class="text-muted small">Información básica de identidad del alumno.</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Nombre(s)</label>
                                        <input type="text" name="nombre" class="form-control rounded-3" value="{{ old('nombre', $constancia->estudiante->nombre) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Apellido Paterno</label>
                                        <input type="text" name="ap" class="form-control rounded-3" value="{{ old('ap', $constancia->estudiante->ap) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Apellido Materno</label>
                                        <input type="text" name="am" class="form-control rounded-3" value="{{ old('am', $constancia->estudiante->am) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Género</label>
                                        <select name="genero" class="form-select rounded-3">
                                            <option value="M" {{ old('genero', $constancia->estudiante->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('genero', $constancia->estudiante->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">No. de Cuenta</label>
                                        <input type="text" name="no_cuenta" class="form-control rounded-3 fw-bold" value="{{ old('no_cuenta', $constancia->estudiante->no_cuenta) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-25">

                        {{-- SECCIÓN 2: ACADÉMICOS Y EMPRESA --}}
                        <div class="row mb-5">
                            <div class="col-md-3">
                                <h6 class="fw-bold text-uppercase small text-success mb-3">2. Académicos</h6>
                                <p class="text-muted small">Relación con carrera, periodo y empresa asignada.</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold small">Carrera</label>
                                        <select name="id_carrera" class="form-select rounded-3 shadow-sm" required>
                                            @foreach($carreras as $c)
                                                <option value="{{ $c->id_carrera }}" {{ $constancia->estudiante->id_carrera == $c->id_carrera ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Empresa Asignada</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-success"></i></span>
                                            <input list="datalist-empresas" id="input-empresa" class="form-control border-start-0 ps-0 rounded-end-3" 
                                                placeholder="Buscar empresa..." 
                                                value="{{ $constancia->estudiante->empresa ? $constancia->estudiante->empresa->nombre : '' }}"
                                                autocomplete="off">
                                        </div>
                                        <input type="hidden" name="id_empresa" id="hidden-id-empresa" value="{{ $constancia->estudiante->id_empresa }}">
                                        <datalist id="datalist-empresas">
                                            @foreach($empresas as $e)
                                                <option data-id="{{ $e->id_empresa }}" value="{{ $e->nombre }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Periodo Escolar</label>
                                        <select name="id_periodo" class="form-select rounded-3 shadow-sm" required>
                                            @foreach($periodos as $p)
                                                <option value="{{ $p->id_periodo }}" {{ $constancia->estudiante->id_periodo == $p->id_periodo ? 'selected' : '' }}>
                                                    {{ $p->fecha_inicio }} - {{ $p->fecha_fin }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-25">

                        {{-- SECCIÓN 3: CERTIFICACIÓN (EDITABLE) --}}
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="fw-bold text-uppercase small text-success mb-3">3. Certificación</h6>
                                <p class="text-muted small">Folios oficiales y resultados de evaluación.</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Calificación Obtenida</label>
                                        <div class="d-flex align-items-start gap-3">
                                            <select name="calificacion" class="form-select rounded-3 border-success fw-bold shadow-sm" style="width: 180px;">
                                                <option value="97" {{ old('calificacion', $constancia->estudiante->calificacion) == '97' ? 'selected' : '' }}>97</option>
                                                <option value="90" {{ old('calificacion', $constancia->estudiante->calificacion) == '90' ? 'selected' : '' }}>90</option>
                                                <option value="80" {{ old('calificacion', $constancia->estudiante->calificacion) == '80' ? 'selected' : '' }}>80</option>
                                            </select>
                                            <div class="alert alert-success border-0 py-2 px-3 small rounded-3 mb-0 shadow-sm flex-grow-1">
                                                <i class="bi bi-info-circle-fill me-2"></i>
                                                97: <strong>Exc.</strong> | 90: <strong>M.B.</strong> | 80: <strong>B.</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold small">No. de Registro</label>
                                        <input type="text" name="no_registro" class="form-control rounded-3 shadow-sm fw-bold" value="{{ old('no_registro', $constancia->estudiante->no_registro) }}">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold small">No. de Folio</label>
                                        <input type="text" name="no_folio" class="form-control rounded-3 shadow-sm fw-bold text-danger" value="{{ old('no_folio', $constancia->estudiante->no_folio) }}">
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fw-semibold small">Fecha de Emisión</label>
                                        <div class="input-group" style="max-width: 300px;">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar-event text-success"></i></span>
                                            <input type="date" name="fecha_emision" class="form-control rounded-3" value="{{ old('fecha_emision', $constancia->estudiante->fecha_emision) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer bg-light p-4 border-0">
                        <div class="d-flex justify-content-end gap-3">
                            {{-- CANCELAR: Regresa a la vista general --}}
                            <a href="{{ route('constancias.general') }}" class="btn btn-outline-secondary px-4 rounded-pill">
                                Cancelar cambios
                            </a>
                            <button type="button" class="btn btn-success px-5 rounded-pill shadow" onclick="confirmUpdate()">
                                <i class="fas fa-save me-2"></i> Actualizar Expediente
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputEmpresa = document.getElementById('input-empresa');
        const dlEmpresa = document.getElementById('datalist-empresas');
        const hiddenEmpresa = document.getElementById('hidden-id-empresa');

        inputEmpresa.addEventListener('input', function() {
            const opt = Array.from(dlEmpresa.options).find(o => o.value === this.value);
            hiddenEmpresa.value = opt ? opt.getAttribute('data-id') : "";
        });
    });

    function confirmUpdate() {
        Swal.fire({
            title: '¿Confirmar cambios?',
            text: "Se actualizará la información del estudiante y sus folios.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007F3F',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-estudiante-form').submit();
            }
        });
    }
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #007F3F;
        box-shadow: 0 0 0 0.25rem rgba(0, 127, 63, 0.1);
    }
    .card { border-radius: 20px; }
    .btn-success { background-color: #007F3F; border: none; }
    .btn-success:hover { background-color: #006633; transform: translateY(-1px); }
</style>
@endpush