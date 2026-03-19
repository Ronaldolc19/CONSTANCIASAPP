@extends('layouts.admin')

@section('title', 'Editar Constancia')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #1a5c37;">Editar Registro de Constancia</h3>
            <p class="text-muted small mb-0">Modificación de folios y datos de residencia del estudiante</p>
        </div>
        <a href="{{ route('constancias.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Cancelar y Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-custom border-0 shadow-lg" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> 
                        Editando Folio: {{ $constancia->estudiante->no_folio ?? 'Sin Folio' }}
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('constancias.update', $constancia->id_constancia) }}" method="POST" id="edit-constancia-form">
                        @csrf 
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            {{-- Estudiante (Solo lectura o selección limitada) --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Estudiante</label>
                                <select name="id_estudiante" class="form-select bg-light" required>
                                    @foreach($estudiantes as $e)
                                        <option value="{{ $e->id_estudiante }}" 
                                            {{ $e->id_estudiante == $constancia->id_estudiante ? 'selected' : '' }}>
                                            {{ $e->nombre }} {{ $e->ap }} — {{ $e->no_cuenta }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Empresa --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Empresa / Sede</label>
                                <select name="id_empresa" class="form-select" required>
                                    @foreach($empresas as $em)
                                        <option value="{{ $em->id_empresa }}" 
                                            {{ $em->id_empresa == $constancia->estudiante->id_empresa ? 'selected' : '' }}>
                                            {{ $em->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Periodo --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Periodo Académico</label>
                                <select name="id_periodo" class="form-select" required>
                                    @foreach($periodos as $p)
                                        <option value="{{ $p->id_periodo }}" 
                                            {{ $p->id_periodo == $constancia->estudiante->id_periodo ? 'selected' : '' }}>
                                            {{ $p->periodo_formateado ?? $p->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="opacity-25 mb-4">

                        <div class="row g-3 mb-4">
                            {{-- Calificación --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Calificación</label>
                                <select name="calificacion" class="form-select" required>
                                    @php
                                        $opciones = ["EXCELENTE – 97", "MUY BIEN – 90", "BIEN – 80"];
                                        $calActual = $constancia->estudiante->calificacion;
                                    @endphp
                                    @foreach($opciones as $opcion)
                                        <option value="{{ $opcion }}" {{ $calActual == $opcion ? 'selected' : '' }}>
                                            {{ $opcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- No. Registro --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Número de Registro</label>
                                <input type="text" name="no_registro" class="form-control fw-bold" 
                                       value="{{ old('no_registro', $constancia->estudiante->no_registro) }}" required>
                            </div>

                            {{-- No. Folio --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Número de Folio</label>
                                <input type="text" name="no_folio" class="form-control fw-bold text-danger" 
                                       value="{{ old('no_folio', $constancia->estudiante->no_folio) }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            {{-- Fecha Emisión --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Fecha de Emisión</label>
                                <input type="date" name="fecha_emision" class="form-control" 
                                       value="{{ old('fecha_emision', $constancia->estudiante->fecha_emision) }}">
                            </div>

                            {{-- Estado de la Constancia (Dato propio de la tabla constancias) --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Estado del Documento</label>
                                <select name="estado" class="form-select fw-bold {{ $constancia->estado == 'emitida' ? 'text-success' : 'text-warning' }}" required>
                                    <option value="pendiente" {{ $constancia->estado == 'pendiente' ? 'selected' : '' }}>PENDIENTE</option>
                                    <option value="emitida" {{ $constancia->estado == 'emitida' ? 'selected' : '' }}>EMITIDA</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 bg-warning bg-opacity-10 mt-4 d-flex align-items-center">
                            <i class="bi bi-exclamation-octagon-fill text-warning me-3 fs-4"></i>
                            <small class="text-dark">
                                <strong>Nota:</strong> Al guardar, se actualizará el expediente del estudiante y el estatus de su constancia. 
                                Asegúrese de que los folios coincidan con el documento físico.
                            </small>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('constancias.index') }}" class="btn btn-light px-4 border">Descartar</a>
                            <button type="button" class="btn btn-success px-5 shadow" onclick="confirmUpdate()">
                                <i class="fas fa-save me-2"></i> Actualizar Todo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
            text: "Se actualizará la información del alumno y el estado de su constancia.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a5c37',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-constancia-form').submit();
            }
        });
    }
</script>
@endpush