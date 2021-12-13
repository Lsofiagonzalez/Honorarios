<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ParametroTablasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id, nombre, created_at, updated_at
        DB::insert("INSERT INTO parametro_tablas (nombre, created_at, updated_at) VALUES ('Estado', GETDATE(), GETDATE())");
        DB::insert("INSERT INTO parametro_tablas (nombre, created_at, updated_at) VALUES ('Visibilidad', GETDATE(), GETDATE())");
    }
}
