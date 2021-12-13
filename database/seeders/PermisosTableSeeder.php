<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Modulo;
use App\Models\Permiso;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::insert("INSERT INTO permisos (rol_id, acceso_id, created_at, updated_at) VALUES (1, 1, GETDATE(), GETDATE())");
        //id, rol_id, acceso_id, created_at, updated_at

        //Para el usuario administrador
        //Modulo de usuario
        foreach(Modulo::find(1)->submodulos as $submodulo){
            foreach($submodulo->accesos as $acceso){
                Permiso::insert([
                    "rol_id"    => 2, //DESARROLLADOR
                    "acceso_id"   => $acceso->id
                ]);
            }
        }

        //Para el usuario administrador
        //Modulo de configuracion
        foreach(Modulo::find(2)->submodulos as $submodulo){
            foreach($submodulo->accesos as $acceso){
                Permiso::insert([
                    "rol_id"    => 1, //ADMINISTRADOR
                    "acceso_id"   => $acceso->id
                ]);
            }
        }
    }
}
