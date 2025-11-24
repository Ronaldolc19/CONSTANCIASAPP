@extends('layouts.admin')

@section('title', 'Vista General de Constancias')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h5 class="mb-0">Vista General de Constancias</h5>

        <div>
            <a href="{{ route('constancias.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Nueva Constancia
            </a>
        </div>
    </div>

    <div class="card-body">

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('constancias.general') }}" class="row g-3 mb-3">

            {{-- Buscar --}}
            <div class="col-md-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" 
                       placeholder="Buscar por nombre, cuenta, folio, registro, empresa...">
            </div>

            {{-- Botón filtros --}}
            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>

            {{-- Limpiar --}}
            <div class="col-md-2">
                <a href="{{ route('constancias.general') }}" class="btn btn-secondary w-100">
                    Limpiar
                </a>
            </div>

        </form>

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No. Cuenta</th>
                        <th>Nombre</th>
                        <th>No. Registro</th>
                        <th>No. Folio</th>
                        <th>Calificación</th>
                        <th>Género</th>
                        <th>Carrera</th>
                        <th>Empresa</th>
                        <th>Periodo</th>
                        <th>Fecha Emisión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($constancias as $c)
                    <tr>
                        <td>{{ $c->estudiante->no_cuenta }}</td>

                        <td>{{ $c->estudiante->nombre }} {{ $c->estudiante->ap }} {{ $c->estudiante->am }}</td>

                        <td class="text-center">{{ $c->no_registro }}</td>

                        <td class="text-center">{{ $c->no_folio }}</td>

                        <td class="text-center ">
                            {{ $c->calificacion}}
                        </td>

                        <td class="text-center">{{ $c->estudiante->genero }}</td>

                        <td>{{ $c->estudiante->carrera->nombre }}</td>

                        <td>{{ $c->empresa->nombre }}</td>
                        
                        <td>
                           {{ $c->periodo->periodo_formateado}} 
                        </td>

                        <td class="text-center">
                            {{ $c->fecha_emision  }}
                        </td>

                        <td class="text-center">

                            {{-- GENERAR --}}
                            <a href="{{ route('constancias.docx', $c->id_constancia) }}" 
                                class="btn btn-sm btn-primary" target="_blank">
                                <i class="fas fa-file-word"></i> Generar
                            </a>

                            {{-- VER --}}
                            <a href="{{ route('constancias.show', $c->id_constancia) }}" 
                               class="btn btn-sm btn-info text-white">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- EDITAR --}}
                            <a href="{{ route('constancias.edit', $c->id_constancia) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('constancias.historial', $c->id_constancia) }}"
                                class="btn btn-sm btn-secondary">
                                <i class="fas fa-clock"></i>
                            </a>

                            {{-- ELIMINAR --}}
                            <form action="{{ route('constancias.destroy', $c->id_constancia) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Eliminar constancia?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
