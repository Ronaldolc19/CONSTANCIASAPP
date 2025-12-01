@extends('layouts.admin')

@section('title', 'Asignar Permisos')

@section('content')
<div class="card shadow">

    <div class="card-header bg-dark text-white">
        <h4>Permisos de {{ $usuario->name }}</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('usuarios.permisos.guardar', $usuario->id) }}" method="POST">
            @csrf

            <div class="row">
                @foreach($permisos as $permiso)
                    <div class="col-3">
                        <label>
                            <input type="checkbox" name="permisos[]" value="{{ $permiso->name }}"
                                {{ $usuario->hasPermissionTo($permiso->name) ? 'checked' : '' }}>
                            {{ ucfirst($permiso->name) }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button class="btn btn-success mt-3">Actualizar Permisos</button>

        </form>

    </div>
</div>
@endsection
