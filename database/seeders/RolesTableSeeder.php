<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //nombre, descripcion, estado, rol_id, created_at, updated_at
        //DB::insert("INSERT INTO roles (nombre, descripcion, created_at, updated_at) VALUES ('General', 'Rol que posee puede ingresar a las páginas básicas de todo usuario como es el dashboard.', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO roles (nombre, descripcion, created_at, updated_at) VALUES ('Administrador', 'Rol que puede acceder a todos los permisos disponibles en el sistema menos aquellos que requieran configuración sobre sistema.', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO roles (nombre, descripcion, rol_id, created_at, updated_at) VALUES ('Desarrollador', 'Rol que puede acceder a todos los permisos disponibles en el sistema.', 1, GETDATE(), GETDATE())");
    }
}
