@extends('layouts.admin')

@section('title', 'Asignar Rol')

@section('content')
<div class="card shadow">

    <div class="card-header bg-info text-white">
        <h4>Asignar Rol a {{ $usuario->name }}</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('usuarios.roles.guardar', $usuario->id) }}" method="POST">
            @csrf

            <label class="form-label">Seleccionar Rol:</label>

            <select name="rol" class="form-control">
                @foreach($roles as $rol)
                    <option value="{{ $rol->name }}" 
                        {{ $usuario->roles->first() && $usuario->roles->first()->name == $rol->name ? 'selected' : '' }}>
                        {{ ucfirst($rol->name) }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary mt-3">Actualizar Rol</button>
        </form>
    </div>

</div>
@endsection
