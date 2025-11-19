@extends('layouts.admin')

@section('title','Editar Constancia')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Editar Constancia</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('constancias.update',$constancia->id_constancia) }}" method="POST">
            @csrf @method('PUT')

            <div class="row mb-3">

                <div class="col-md-4">
                    <label class="form-label">Estudiante</label>
                    <select name="id_estudiante" class="form-select" required>
                        @foreach($estudiantes as $e)
                        <option value="{{ $e->id_estudiante }}"
                            {{ $e->id_estudiante == $constancia->id_estudiante ? 'selected' : '' }}>
                            {{ $e->nombre }} {{ $e->ap }} — {{ $e->no_cuenta }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Empresa</label>
                    <select name="id_empresa" class="form-select" required>
                        @foreach($empresas as $em)
                        <option value="{{ $em->id_empresa }}"
                            {{ $em->id_empresa == $constancia->id_empresa ? 'selected' : '' }}>
                            {{ $em->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Periodo</label>
                    <select name="id_periodo" class="form-select" required>
                        @foreach($periodos as $p)
                        <option value="{{ $p->id_periodo }}"
                            {{ $p->id_periodo == $constancia->id_periodo ? 'selected' : '' }}>
                            {{ $p->periodo_formateado }}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4">
                    <label class="form-label">Calificación</label>
                    <select name="calificacion" class="form-select" required>
                        <option value="EXCELENTE – 97" {{ $constancia->calificacion == "EXCELENTE – 97" ? 'selected':'' }}>EXCELENTE – 97</option>
                        <option value="MUY BIEN – 90" {{ $constancia->calificacion == "MUY BIEN – 90" ? 'selected':'' }}>MUY BIEN – 90</option>
                        <option value="BIEN – 80" {{ $constancia->calificacion == "BIEN – 80" ? 'selected':'' }}>BIEN – 80</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Número de Registro</label>
                    <input type="text" name="no_registro" class="form-control" value="{{ $constancia->no_registro }}">
                </div>

                <div class="col-md-4">
                    <label>Número de Folio</label>
                    <input type="text" name="no_folio" class="form-control" value="{{ $constancia->no_folio }}">
                </div>

            </div>

            <div class="mb-3">
                <label>Fecha de emisión</label>
                <input type="date" name="fecha_emision" value="{{ $constancia->fecha_emision }}" class="form-control">
            </div>

            <button class="btn btn-success px-4">Actualizar</button>

        </form>

    </div>
</div>

@endsection
