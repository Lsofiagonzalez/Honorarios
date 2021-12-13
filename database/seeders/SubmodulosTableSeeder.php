<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubmodulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, created_at, updated_at) VALUES ('Módulo',    'Submódulo que enmarca las funciones sobre los módulos del sistema.', 1, 'fa-cube', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, created_at, updated_at) VALUES ('Submódulo', 'Submódulo que enmarca las funciones sobre los submódulos del sistema.', 1, 'fa-cubes', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, created_at, updated_at) VALUES ('Acceso',    'Submódulo que enmarca las funciones sobre los accesos del sistema.', 1, 'fa-key', GETDATE(), GETDATE())");

        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, created_at, updated_at) VALUES ('Rol',     'Submódulo que enmarca las funciones sobre los roles de usuarios del sistema.', 2, 'fa-shield', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, visible, created_at, updated_at) VALUES ('Permiso',  'Submódulo que enmarca las funciones sobre los permisos de los roles del sistema.', 2, 'fa-shield', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, created_at, updated_at) VALUES ('Usuario',   'Submódulo que enmarca las funciones sobre los usuarios del sistema.', 2, 'fa-user', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO submodulos (nombre, descripcion, modulo_id, icono, created_at, updated_at) VALUES ('Log',   'Submódulo que enmarca las funciones sobre los logs del sistema.', 2, 'fa-user-secret', GETDATE(), GETDATE())");
    }
}
