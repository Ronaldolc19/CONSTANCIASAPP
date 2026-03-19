@extends('layouts.admin')

@section('title', 'Nueva Constancia')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--tesvb-green);">Generar Nueva Constancia</h3>
            <p class="text-muted small mb-0">Emisión oficial de liberación de servicio social</p>
        </div>
        <a href="{{ route('constancias.index') }}" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Cancelar
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li><i class="bi bi-exclamation-triangle me-2"></i> {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('constancias.store') }}" method="POST" id="create-constancia-form">
        @csrf

        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card card-custom border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-link-45deg me-2"></i>Datos de Vinculación</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- ESTUDIANTE: Un solo campo para escribir y seleccionar --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase">Estudiante</label>
                                <input list="datalist-estudiantes" id="input-estudiante" class="form-control" placeholder="Escriba nombre o cuenta..." autocomplete="off">
                                <input type="hidden" name="id_estudiante" id="hidden-id-estudiante" value="{{ old('id_estudiante') }}">
                                <datalist id="datalist-estudiantes">
                                    @foreach($estudiantes as $e)
                                        <option data-id="{{ $e->id_estudiante }}" value="{{ $e->no_cuenta }} — {{ $e->nombre }} {{ $e->ap }} {{ $e->am }}">
                                    @endforeach
                                </datalist>
                            </div>

                            {{-- EMPRESA: Un solo campo para escribir y seleccionar --}}
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase">Empresa / Institución</label>
                                <input list="datalist-empresas" id="input-empresa" class="form-control" placeholder="Escriba nombre de la empresa..." autocomplete="off">
                                <input type="hidden" name="id_empresa" id="hidden-id-empresa" value="{{ old('id_empresa') }}">
                                <datalist id="datalist-empresas">
                                    @foreach($empresas as $emp)
                                        <option data-id="{{ $emp->id_empresa }}" value="{{ $emp->nombre }}">
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="col-md-4">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-custom border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0 text-success"><i class="bi bi-file-earmark-check me-2"></i>Folios y Evaluación</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Calificación</label>
                                <select name="calificacion" class="form-select" required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="EXCELENTE – 97" {{ old('calificacion') == 'EXCELENTE – 97' ? 'selected' : '' }}>EXCELENTE – 97</option>
                                    <option value="MUY BIEN – 90" {{ old('calificacion') == 'MUY BIEN – 90' ? 'selected' : '' }}>MUY BIEN – 90</option>
                                    <option value="BIEN – 80" {{ old('calificacion') == 'BIEN – 80' ? 'selected' : '' }}>BIEN – 80</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase">Número de Registro</label>
                                <input type="text" id="no_registro" name="no_registro" 
                                    class="form-control fw-bold border-success-subtle" 
                                    value="{{ old('no_registro') }}" 
                                    placeholder="Escriba o genere registro">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Número de Folio</label>
                                <div class="input-group">
                                    <input type="text" id="no_folio" name="no_folio" 
                                        class="form-control fw-bold border-success-subtle" 
                                        value="{{ old('no_folio') }}" 
                                        placeholder="Escriba o genere folio">
                                    <button type="button" class="btn btn-outline-success" onclick="generarNumeros()" title="Recargar Folio">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-bold text-uppercase">Fecha Emisión</label>
                                <input type="date" name="fecha_emision" class="form-control"
                                       value="{{ old('fecha_emision', date('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-3">
            <a href="{{ route('constancias.index') }}" class="btn btn-light px-4 border">Descartar</a>
            <button type="submit" class="btn btn-tesvb px-5 shadow-sm">
                <i class="fas fa-save me-2"></i> Finalizar y Guardar
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Formateador de fechas para el selector de periodos
    function formatFecha(fecha) {
        if(!fecha) return '';
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        const d = new Date(fecha + "T00:00:00");
        return d.getDate() + " de " + meses[d.getMonth()] + " de " + d.getFullYear();
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Lógica para vincular el Input de texto con el ID real para el envío del formulario
        const vincularDatalist = (idInput, idDatalist, idHidden) => {
            const elInput = document.getElementById(idInput);
            const elDatalist = document.getElementById(idDatalist);
            const elHidden = document.getElementById(idHidden);

            elInput.addEventListener('input', function() {
                const valor = this.value;
                const opcionSeleccionada = Array.from(elDatalist.options).find(opt => opt.value === valor);
                
                if (opcionSeleccionada) {
                    elHidden.value = opcionSeleccionada.getAttribute('data-id');
                } else {
                    elHidden.value = ""; // Limpiar si lo que escribió no coincide con la lista
                }
            });
        };

        // Activamos la vinculación
        vincularDatalist('input-estudiante', 'datalist-estudiantes', 'hidden-id-estudiante');
        vincularDatalist('input-empresa', 'datalist-empresas', 'hidden-id-empresa');

        // Formatear opciones del select de periodos
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

        // Auto-generación inicial de folios
        if (!document.getElementById('no_registro').value || !document.getElementById('no_folio').value) {
            generarNumeros();
        }
    });

    function generarNumeros() {
        const btn = document.querySelector('button[onclick="generarNumeros()"] i');
        if(btn) btn.classList.add('fa-spin');

        fetch("{{ route('constancias.generar.numeros') }}", { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' } 
        })
        .then(response => response.json())
        .then(data => {
            if (data.no_registro) document.getElementById('no_registro').value = data.no_registro;
            if (data.no_folio) document.getElementById('no_folio').value = data.no_folio;
            if(btn) btn.classList.remove('fa-spin');
        })
        .catch(err => {
            console.error('Error:', err);
            if(btn) btn.classList.remove('fa-spin');
        });
    }
</script>
@endpush

@endsection