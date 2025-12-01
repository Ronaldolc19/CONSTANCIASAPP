<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function aprobar($id)
    {
        $u = User::findOrFail($id);
        $u->is_approved = 1;
        $u->save();

        return back()->with('success', 'Usuario aprobado');
    }

    public function desaprobar($id)
    {
        $u = User::findOrFail($id);
        $u->is_approved = 0;
        $u->save();

        return back()->with('success', 'Usuario desaprobado');
    }

    public function activar($id)
    {
        $u = User::findOrFail($id);
        $u->is_active = 1;
        $u->save();

        return back()->with('success', 'Usuario activado');
    }

    public function desactivar($id)
    {
        $u = User::findOrFail($id);
        $u->is_active = 0;
        $u->save();

        return back()->with('success', 'Usuario desactivado');
    }

    public function roles($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();

        return view('usuarios.roles', compact('usuario', 'roles'));
    }

    public function guardarRol(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->syncRoles([$request->rol]);

        return redirect()->route('usuarios.index')->with('success', 'Rol actualizado');
    }

    public function permisos($id)
    {
        $usuario = User::findOrFail($id);
        $permisos = Permission::all();

        return view('usuarios.permisos', compact('usuario', 'permisos'));
    }

    public function guardarPermisos(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->syncPermissions($request->permisos ?? []);

        return redirect()->route('usuarios.index')->with('success', 'Permisos actualizados');
    }
}
