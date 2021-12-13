<?php

namespace App\Http\Controllers;
//////////////////////////////////
//MODELOS
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Acceso;

use App\Models\Rol;
use App\Models\User;
use App\Models\Usuario_GD;
use App\Models\Log;
use App\Models\matrizPermisos;

//////////////////////////////////
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

//////////////////////////////////
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
/////////////////////////////////
use App\Http\Requests\AlmacenarModeloRequest;

////////////////////////////////
//UTILIDADES
use Route;
use Session;
use Validator;
use Hash;
use Auth;
use File;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;  //se agrega el facade de excel que permite generar
//los informes en formato excel


class UsuarioController extends Controller
{

  /**
  * Permite listar todos los elementos en la tabla
  * usuarios
  */
  public function index()
  {
    $usuarios = User::get();
    return view('usuarios.index',compact('usuarios'));
  }
  /**
  * Permite cargar la vista para validar la existencia del usuario
  */
  public function ver(){
    return view(Route::currentRouteName(), ['ruta' => 'usuarios.ver']);
  }

 
  public function crear(){
    $value = Session::get('cedula');
    return view('usuarios.crear', ['ruta' => 'usuarios.cargar'])->with('value', $value );
  }

  public static function fotoperfil($foto,$cedula)
  {
    if(isset($foto))
    {
      for ($i=0; $i <count($foto) ; $i++)
      {
        return storage::disk('ftp')->put('BIOTIC/FOTOS/'.$cedula.'.jpg',\File::get($foto[$i]));
      }
    }
  }


public function editar(User $usuario){
  return view(Route::currentRouteName(),[
    'usuario' => $usuario,
    'ruta' => 'usuarios.actualizar'
  ]);
}

public function actualizarRol(Request $request,User $usuario)
{
  $usuario->rol_id = $request->rol_id;
  $usuario->update();

  return back()->with('success','El usuario ha sido actualizado con éxito.');
}

/**
* Permite mostrar un usuario existente
*/
public function mostrar(User $usuario){
  return view(Route::currentRouteName(), ['usuario' => $usuario]);
}
//Permite  ver en linea la politica de control de usuarios
public function controlUsuarios(){
  return view('usuarios.controlUsuarios');
}
//permite generar el formato de control de usuarios como archivo de excel
public function controlUExcel(){
  Excel::create("Control de usuarios", function ($excel) {
    $excel->setTitle("Politica control de usuarios");
    $excel->sheet("Hoja 1", function ($sheet) {
      $sheet->loadView('usuarios/controlUExcel');
    });
  })->export('xls');
}
public function buscar()
{
  $usuarios =User::where('estado','<>',2)->orderby('nombre_usuario')->get();
  return view('usuarios.index',compact('usuarios'));
}

/**
* Funcion que permite verificar que la caracteristica exista en la tabla
*/
public function existeCaracteristica($caracteristica){
  if($caracteristica == 'password' ||
  $caracteristica == 'remember_token'){
    return false;
  }

  foreach(\Schema::getColumnListing("usuarios") as $columna){
    if($columna == $caracteristica)
    return true;
  }
  return false;
}

}
