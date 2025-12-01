<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos si no existen
        $permisos = ['ver', 'crear', 'editar', 'eliminar'];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles si no existen
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $usuario = Role::firstOrCreate(['name' => 'usuario']);

        // Asignar permisos a admin
        $admin->givePermissionTo($permisos);

        // Crear usuario admin solo si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin_serviciosocial@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Serviciosocial.admin#'),
                'is_active' => 1,
                'is_approved' => 1,
            ]
        );

        // FORZAR asignación de rol
        $user->syncRoles(['admin']);
    }
}
