@extends('layouts.admin')

@section('title', 'Editar Expediente - ' . $estudiante->no_cuenta)

@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Editar Expediente</h3>
            <p class="text-muted small mb-0">Gestión centralizada de datos y folios oficiales</p>
        </div>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-light border shadow-sm px-4 rounded-3">
            <i class="fas fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <form action="{{ route('estudiantes.update', $estudiante->id_estudiante) }}" method="POST" id="edit-estudiante-form">
                @csrf 
                @method('PUT')

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="bi bi-pencil-square text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Modificando Registro: {{ $estudiante->no_cuenta }}</h6>
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
                                        <input type="text" name="nombre" class="form-control rounded-3" value="{{ old('nombre', $estudiante->nombre) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Apellido Paterno</label>
                                        <input type="text" name="ap" class="form-control rounded-3" value="{{ old('ap', $estudiante->ap) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Apellido Materno</label>
                                        <input type="text" name="am" class="form-control rounded-3" value="{{ old('am', $estudiante->am) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Género</label>
                                        <select name="genero" class="form-select rounded-3">
                                            <option value="M" {{ old('genero', $estudiante->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ old('genero', $estudiante->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">No. de Cuenta</label>
                                        <input type="text" name="no_cuenta" class="form-control rounded-3 fw-bold" value="{{ old('no_cuenta', $estudiante->no_cuenta) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-25">

                        {{-- SECCIÓN 2: DATOS ACADÉMICOS Y VINCULACIÓN --}}
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
                                                <option value="{{ $c->id_carrera }}" {{ $estudiante->id_carrera == $c->id_carrera ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Empresa Asignada</label>
                                        <select name="id_empresa" class="form-select rounded-3">
                                            <option value="">-- Sin asignar --</option>
                                            @foreach($empresas as $e)
                                                <option value="{{ $e->id_empresa }}" {{ $estudiante->id_empresa == $e->id_empresa ? 'selected' : '' }}>{{ $e->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Periodo Escolar</label>
                                        <select name="id_periodo" class="form-select rounded-3">
                                            @foreach($periodos as $p)
                                                <option value="{{ $p->id_periodo }}" {{ $estudiante->id_periodo == $p->id_periodo ? 'selected' : '' }}>{{ $p->periodo_formateado }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-25">

                        {{-- SECCIÓN 3: CERTIFICACIÓN Y FOLIOS (CAMPOS QUE FALTABAN) --}}
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="fw-bold text-uppercase small text-success mb-3">3. Certificación</h6>
                                <p class="text-muted small">Folios oficiales y resultados de evaluación.</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">No. de Registro</label>
                                        <input type="text" name="no_registro" class="form-control rounded-3 shadow-sm" value="{{ old('no_registro', $estudiante->no_registro) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">No. de Folio</label>
                                        <input type="text" name="no_folio" class="form-control rounded-3 shadow-sm border-danger-subtle" value="{{ old('no_folio', $estudiante->no_folio) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Calificación</label>
                                        <input type="number" step="0.1" name="calificacion" class="form-control rounded-3" value="{{ old('calificacion', $estudiante->calificacion) }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold small">Fecha de Emisión</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                                            <input type="date" name="fecha_emision" class="form-control rounded-3" value="{{ old('fecha_emision', $estudiante->fecha_emision) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer de Acciones --}}
                    <div class="card-footer bg-light p-4 border-0">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary px-4 rounded-3">
                                Cancelar cambios
                            </a>
                            <button type="button" class="btn btn-success px-5 rounded-3 shadow" onclick="confirmUpdate()">
                                <i class="fas fa-save me-2"></i> Guardar Expediente
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
    function confirmUpdate() {
        Swal.fire({
            title: '¿Confirmar cambios?',
            text: "Los datos actualizados se reflejarán en las constancias generadas.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#007F3F',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4'
            }
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
    .form-label {
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    .card-header {
        background-color: #fff !important;
    }
</style>
@endpush