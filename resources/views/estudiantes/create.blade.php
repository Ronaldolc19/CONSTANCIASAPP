@extends('layouts.admin')

@section('title', 'Nuevo Estudiante')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Registrar Estudiante</h3>
            <p class="text-muted small mb-0">Expediente maestro y liberación de servicio</p>
        </div>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Cancelar
        </a>
    </div>

    {{-- Alertas de Error --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li><i class="bi bi-exclamation-triangle me-2"></i> {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('estudiantes.store') }}" method="POST" id="create-estudiante-form">
        @csrf

        <div class="row g-4">
            {{-- SECCIÓN 1: DATOS PERSONALES --}}
            <div class="col-lg-12">
                <div class="card card-custom border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-person-badge me-2"></i>Información Académica y Personal</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">No. de Cuenta</label>
                                <input type="text" name="no_cuenta" class="form-control @error('no_cuenta') is-invalid @enderror" value="{{ old('no_cuenta') }}" required placeholder="Ej. 20241010">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Apellido Paterno</label>
                                <input type="text" name="ap" class="form-control" value="{{ old('ap') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Apellido Materno</label>
                                <input type="text" name="am" class="form-control" value="{{ old('am') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Carrera</label>
                                <select name="id_carrera" class="form-select" required>
                                    <option value="">-- Seleccionar carrera --</option>
                                    @foreach($carreras as $c)
                                        <option value="{{ $c->id_carrera }}" {{ old('id_carrera') == $c->id_carrera ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Género</label>
                                <select name="genero" class="form-select" required>
                                    <option value="">-- Seleccionar --</option>
                                    <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 2: VINCULACIÓN Y FOLIOS --}}
            <div class="col-lg-12">
                <div class="card card-custom border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-link-45deg me-2"></i>Datos de Vinculación y Folios</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- EMPRESA con Datalist --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Empresa / Institución</label>
                                <input list="datalist-empresas" id="input-empresa" class="form-control" placeholder="Escriba nombre de la empresa..." autocomplete="off">
                                <input type="hidden" name="id_empresa" id="hidden-id-empresa" value="{{ old('id_empresa') }}">
                                <datalist id="datalist-empresas">
                                    @foreach($empresas as $emp)
                                        <option data-id="{{ $emp->id_empresa }}" value="{{ $emp->nombre }}">
                                    @endforeach
                                </datalist>
                            </div>

                            {{-- PERIODO con formateo JS --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Periodo de Servicio</label>
                                <select name="id_periodo" class="form-select" required id="selectPeriodo">
                                    <option value="">-- Seleccionar periodo --</option>
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

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Calificación</label>
                                <select name="calificacion" class="form-select">
                                    <option value="">-- Seleccione --</option>
                                    <option value="EXCELENTE – 97" {{ old('calificacion') == 'EXCELENTE – 97' ? 'selected' : '' }}>EXCELENTE – 97</option>
                                    <option value="MUY BIEN – 90" {{ old('calificacion') == 'MUY BIEN – 90' ? 'selected' : '' }}>MUY BIEN – 90</option>
                                    <option value="BIEN – 80" {{ old('calificacion') == 'BIEN – 80' ? 'selected' : '' }}>BIEN – 80</option>
                                </select>
                            </div>

                            {{-- Sección de Folios en el Formulario --}}
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Número de Registro</label>
                                <input type="text" id="no_registro" name="no_registro" 
                                    class="form-control fw-bold border-success-subtle" 
                                    value="{{ old('no_registro') }}" 
                                    placeholder="Generando...">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Número de Folio</label>
                                <div class="input-group">
                                    <input type="text" id="no_folio" name="no_folio" 
                                        class="form-control fw-bold border-success-subtle" 
                                        value="{{ old('no_folio') }}" 
                                        placeholder="Generando...">
                                    <button type="button" class="btn btn-outline-success" onclick="generarNumeros()" title="Recargar Folio">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Fecha Emisión</label>
                                <input type="date" name="fecha_emision" class="form-control" value="{{ old('fecha_emision', date('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-3 mb-5">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-light px-4 border">Descartar</a>
            <button type="submit" class="btn btn-tesvb px-5 shadow-sm">
                <i class="fas fa-save me-2"></i> Guardar Registro Completo
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function formatFecha(fecha) {
        if(!fecha) return '';
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        const d = new Date(fecha + "T00:00:00");
        return d.getDate() + " de " + meses[d.getMonth()] + " de " + d.getFullYear();
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Lógica para el Datalist de Empresa
        const inputEmpresa = document.getElementById('input-empresa');
        const dlEmpresa = document.getElementById('datalist-empresas');
        const hiddenEmpresa = document.getElementById('hidden-id-empresa');

        inputEmpresa.addEventListener('input', function() {
            const opt = Array.from(dlEmpresa.options).find(o => o.value === this.value);
            hiddenEmpresa.value = opt ? opt.getAttribute('data-id') : "";
        });

        // Formatear Periodos
        const select = document.getElementById('selectPeriodo');
        [...select.options].forEach(opt => {
            const inicio = opt.getAttribute('data-inicio');
            const fin = opt.getAttribute('data-fin');
            if (inicio && fin) opt.textContent = `${formatFecha(inicio)} al ${formatFecha(fin)}`;
        });

        // Auto-generación inicial
        if (!document.getElementById('no_registro').value || !document.getElementById('no_folio').value) {
            generarNumeros();
        }
    });

    function generarNumeros() {
    const btnIcon = document.querySelector('button[onclick="generarNumeros()"] i');
    if(btnIcon) btnIcon.classList.add('fa-spin');

    // Llamamos a la ruta por su nombre definido en web.php
    fetch("{{ route('estudiantes.generarNumeros') }}", { 
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            // El Token CSRF es vital para evitar el error 403
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        } 
    })
    .then(response => {
        if (!response.ok) throw new Error('Error ' + response.status);
        return response.json();
    })
    .then(data => {
        // Los campos se llenan con lo que diga el servidor (dinámico)
        if (data.no_registro) document.getElementById('no_registro').value = data.no_registro;
        if (data.no_folio) document.getElementById('no_folio').value = data.no_folio;
    })
    .catch(err => {
        console.error('Error:', err);
        alert("Error de conexión: Asegúrate de que la ruta exista en web.php");
    })
    .finally(() => {
        if(btnIcon) btnIcon.classList.remove('fa-spin');
    });
}
</script>
@endpush

@endsection