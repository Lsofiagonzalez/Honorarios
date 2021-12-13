<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class LogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id, registro_id, nombre_tabla, accion, responsable_id

        //Logs de módulos
        foreach(App\Models\Modulo::get() as $modulo){
            $log = new App\Models\Log;
            $log->registro_id = $modulo->id;
            $log->nombre_tabla = 'modulos';
            $log->accion       = 'crear';
            $log->responsable_id = 1;
            $log->save();
        }

        //Logs de submódulos
        foreach(App\Models\Submodulo::get() as $submodulo){
            $log = new App\Models\Log;
            $log->registro_id = $submodulo->id;
            $log->nombre_tabla = 'submodulo';
            $log->accion       = 'crear';
            $log->responsable_id = 1;
            $log->save();
        }

        //Logs de accesos
        foreach(App\Models\Acceso::get() as $acceso){
            $log = new App\Models\Log;
            $log->registro_id = $acceso->id;
            $log->nombre_tabla = 'accesos';
            $log->accion       = 'crear';
            $log->responsable_id = 1;
            $log->save();
        }

        //Logs de permisos
        foreach(App\Models\Permiso::get() as $permiso){
            $log = new App\Models\Log;
            $log->registro_id = $permiso->id;
            $log->nombre_tabla = 'permisos';
            $log->accion       = 'crear';
            $log->responsable_id = 1;
            $log->save();
        }

        //Logs de permisos
        foreach(App\Models\Rol::get() as $rol){
            $log = new App\Models\Log;
            $log->registro_id = $rol->id;
            $log->nombre_tabla = 'roles';
            $log->accion       = 'crear';
            $log->responsable_id = 1;
            $log->save();
        }

        //Logs de usuarios
        foreach(App\Models\Usuario::get() as $usuario){
            $log = new App\Models\Log;
            $log->registro_id = $usuario->id;
            $log->nombre_tabla = 'usuarios';
            $log->accion       = 'crear';
            $log->responsable_id = 1;
            $log->save();
        }
    }
}
