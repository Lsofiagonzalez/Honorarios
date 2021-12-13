<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert("INSERT INTO usuariosAPP (nombre_usuario, password, rol_id, GD_id, created_at, updated_at) VALUES ('jrvalverde', '". addslashes(Hash::make("12345")) ."', 2, 715, GETDATE(), GETDATE())");
    }
}
