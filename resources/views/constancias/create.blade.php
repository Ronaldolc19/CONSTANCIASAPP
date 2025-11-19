@extends('layouts.admin')

@section('title', 'Crear Constancia')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Nueva Constancia</h5>
    </div>

    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('constancias.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                {{-- Estudiante --}}
                <div class="col-md-4">
                    <label class="form-label">Estudiante</label>
                    <select name="id_estudiante" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($estudiantes as $e)
                            <option value="{{ $e->id_estudiante }}"
                                {{ old('id_estudiante') == $e->id_estudiante ? 'selected' : '' }}>
                                {{ $e->nombre }} {{ $e->ap }} {{ $e->am }} — {{ $e->no_cuenta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Empresa --}}
                <div class="col-md-4">
                    <label class="form-label">Empresa</label>
                    <select name="id_empresa" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($empresas as $emp)
                            <option value="{{ $emp->id_empresa }}" {{ old('id_empresa') == $emp->id_empresa ? 'selected' : '' }}>
                                {{ $emp->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Periodo formateado --}}
                <div class="col-md-4">
                    <label class="form-label">Periodo</label>
                    <select name="id_periodo" class="form-select" required id="selectPeriodo">
                        <option value="">Seleccione</option>
                        @foreach($periodos as $p)
                            <option value="{{ $p->id_periodo }}"
                                data-inicio="{{ $p->fecha_inicio }}"
                                data-fin="{{ $p->fecha_fin }}"
                                {{ old('id_periodo') == $p->id_periodo ? 'selected' : '' }}>
                                {{ $p->fecha_inicio }} al {{ $p->fecha_fin }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>

            {{-- Calificación --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Calificación</label>
                    <select name="calificacion" class="form-select" required>
                        <option value="">Seleccione calificación</option>
                        <option value="EXCELENTE – 97" {{ old('calificacion') == 'EXCELENTE – 97' ? 'selected' : '' }}>EXCELENTE – 97</option>
                        <option value="MUY BIEN – 90"  {{ old('calificacion') == 'MUY BIEN – 90' ? 'selected' : '' }}>MUY BIEN – 90</option>
                        <option value="BIEN – 80"      {{ old('calificacion') == 'BIEN – 80' ? 'selected' : '' }}>BIEN – 80</option>
                    </select>
                </div>

                {{-- Número de registro (autogenerado) --}}
                <div class="col-md-5">
                    <label class="form-label">Número de Registro</label>
                    <input type="text" id="no_registro" name="no_registro" class="form-control" value="{{ old('no_registro') }}" readonly>
                </div>

                {{-- Número de folio (autogenerado) --}}
                <div class="col-md-3">
                    <label class="form-label">Número de Folio</label>
                    <div class="input-group">
                        <input type="text" id="no_folio" name="no_folio" class="form-control" value="{{ old('no_folio') }}" readonly>
                        <button type="button" class="btn btn-outline-secondary" onclick="generarNumeros()" title="Generar números">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Fecha de emisión --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Fecha de emisión</label>
                    <input type="date" name="fecha_emision" class="form-control"
                           value="{{ old('fecha_emision', date('Y-m-d')) }}">
                    <small class="text-muted">Si lo dejas vacío se usará la fecha actual.</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">Guardar Constancia</button>
                <a href="{{ route('constancias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    // Formatea fechas a "13 de marzo de 2019"
    function formatFecha(fecha) {
        if(!fecha) return '';
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        const d = new Date(fecha);
        if (Number.isNaN(d.getTime())) return fecha; // fallback si no es fecha válida
        return d.getDate() + " de " + meses[d.getMonth()] + " de " + d.getFullYear();
    }

    // Reemplaza el texto de las opciones del select por el formato bonito
    document.addEventListener("DOMContentLoaded", function () {
        const select = document.getElementById('selectPeriodo');
        if (select) {
            [...select.options].forEach(opt => {
                const inicio = opt.getAttribute('data-inicio');
                const fin = opt.getAttribute('data-fin');
                if (inicio && fin) {
                    opt.textContent = `${formatFecha(inicio)} al ${formatFecha(fin)}`;
                }
            });
        }

        // Genera números automáticamente al cargar la vista (si no vienen ya)
        if (!document.getElementById('no_registro').value || !document.getElementById('no_folio').value) {
            generarNumeros();
        }
    });

    // Llamada AJAX para obtener números (usa la ruta constancias.generar)
    function generarNumeros() {
        fetch("{{ route('constancias.generar.numeros') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.json())
            .then(data => {
                if (data.no_registro) document.getElementById('no_registro').value = data.no_registro;
                if (data.no_folio) document.getElementById('no_folio').value = data.no_folio;
            })
            .catch(err => {
                console.error('Error generando número:', err);
                // no bloquear al usuario: dejar campos vacíos si falla
            });
    }
</script>

@endsection
