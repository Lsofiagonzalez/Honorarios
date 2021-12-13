<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class ParametrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //valor, abreviacion, nombre, parametro_tabla_id, created_at, updated_at
        DB::insert("INSERT INTO parametro_tablas (valor, abreviacion, nombre, parametro_tabla_id, created_at, updated_at) VALUES ('0', abreviacion, nombre, parametro_tabla_id, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO parametro_tablas (valor, abreviacion, nombre, parametro_tabla_id, created_at, updated_at) VALUES ('1', abreviacion, nombre, parametro_tabla_id, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO parametro_tablas (valor, abreviacion, nombre, parametro_tabla_id, created_at, updated_at) VALUES ('0', abreviacion, nombre, parametro_tabla_id, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO parametro_tablas (valor, abreviacion, nombre, parametro_tabla_id, created_at, updated_at) VALUES ('1', abreviacion, nombre, parametro_tabla_id, GETDATE(), GETDATE())");
    }
}
