<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos básicos para el sistema
        $permissions = [
            // Permisos de usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'gestionar roles usuarios',

            // Permisos de roles
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Permisos de permisos
            'ver permisos',
            'crear permisos',
            'editar permisos',
            'eliminar permisos',

            // Permisos de proyectos
            'ver proyectos',
            'crear proyectos',
            'editar proyectos',
            'eliminar proyectos',

            // Permisos de herramientas/equipos
            'ver equipos',
            'crear equipos',
            'editar equipos',
            'eliminar equipos',

            // Permisos de inspecciones
            'ver inspecciones',
            'crear inspecciones',
            'editar inspecciones',
            'eliminar inspecciones',
            'asignar inspecciones',

            // Permisos de tareas
            'ver tareas',
            'crear tareas',
            'editar tareas',
            'eliminar tareas',

            // Permisos de reportes
            'ver reportes',
            'crear reportes',
            'editar reportes',
            'eliminar reportes',
            'exportar reportes',

            // Permisos administrativos
            'acceso dashboard',
            'configurar sistema',

            // Permisos de auditoría
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles básicos
        $adminRole = Role::create(['name' => 'Administrador']);
        $supervisorRole = Role::create(['name' => 'Supervisor']);
        $inspectorRole = Role::create(['name' => 'Inspector']);
        $usuarioRole = Role::create(['name' => 'Usuario']);

        // Asignar todos los permisos al administrador
        $adminRole->givePermissionTo(Permission::all());

        // Asignar permisos específicos al supervisor
        $supervisorRole->givePermissionTo([
            'ver usuarios',
            'gestionar roles usuarios',
            'ver roles',
            'ver proyectos',
            'crear proyectos',
            'editar proyectos',
            'ver equipos',
            'crear equipos',
            'editar equipos',
            'ver inspecciones',
            'crear inspecciones',
            'editar inspecciones',
            'asignar inspecciones',
            'ver tareas',
            'crear tareas',
            'editar tareas',
            'ver reportes',
            'crear reportes',
            'editar reportes',
            'exportar reportes',
            'acceso dashboard',
        ]);

        // Asignar permisos específicos al inspector
        $inspectorRole->givePermissionTo([
            'ver proyectos',
            'ver equipos',
            'ver inspecciones',
            'editar inspecciones',
            'ver tareas',
            'crear tareas',
            'editar tareas',
            'ver reportes',
            'crear reportes',
            'editar reportes',
            'acceso dashboard',
        ]);

        // Asignar permisos básicos al usuario
        $usuarioRole->givePermissionTo([
            'ver proyectos',
            'ver equipos',
            'ver inspecciones',
            'ver tareas',
            'ver reportes',
            'acceso dashboard',
        ]);
    }
}
