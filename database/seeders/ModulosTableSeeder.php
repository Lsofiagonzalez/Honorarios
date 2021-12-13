<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ModulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO modulos (nombre, descripcion, icono, created_at, updated_at) VALUES ('Configuración', 'Módulo que enmarca las configuraciones principales del sistema.', 'fa-cogs', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO modulos (nombre, descripcion, icono, created_at, updated_at) VALUES ('Módulo de usuarios', 'Módulo que enmarca las principales opciones sobre usuarios y permisos del sistema.', 'fa-users', GETDATE(), GETDATE())");
    }
}
