@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Usuarios del Sistema</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Activo</th>
                    <th>Aprobado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>

                    <td>
                        @if($u->roles->first())
                            <span class="badge bg-info">{{ $u->roles->first()->name }}</span>
                        @else
                            <span class="badge bg-secondary">Sin rol</span>
                        @endif
                    </td>

                    <td>
                        @if($u->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>

                    <td>
                        @if($u->is_approved)
                            <span class="badge bg-success">Aprobado</span>
                        @else
                            <span class="badge bg-warning">Pendiente</span>
                        @endif
                    </td>

                    <td>

                        {{-- APROBAR / DESAPROBAR --}}
                        @if(!$u->is_approved)
                            <a href="{{ route('usuarios.aprobar', $u->id) }}" class="btn btn-success btn-sm">
                                Aprobar
                            </a>
                        @else
                            <a href="{{ route('usuarios.desaprobar', $u->id) }}" class="btn btn-warning btn-sm">
                                Desaprobar
                            </a>
                        @endif

                        {{-- ACTIVAR / DESACTIVAR --}}
                        @if($u->is_active)
                            <a href="{{ route('usuarios.desactivar', $u->id) }}" class="btn btn-danger btn-sm">
                                Desactivar
                            </a>
                        @else
                            <a href="{{ route('usuarios.activar', $u->id) }}" class="btn btn-primary btn-sm">
                                Activar
                            </a>
                        @endif

                        {{-- ROLES --}}
                        <a href="{{ route('usuarios.roles', $u->id) }}" class="btn btn-info btn-sm">
                            Roles
                        </a>

                        {{-- PERMISOS --}}
                        <a href="{{ route('usuarios.permisos', $u->id) }}" class="btn btn-dark btn-sm">
                            Permisos
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
