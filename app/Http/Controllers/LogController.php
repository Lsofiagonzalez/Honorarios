<?php

namespace App\Http\Controllers;

//////////////////////////////////
//MODELOS
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Acceso;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\Usuario_GD;
use App\Models\Log;

//////////////////////////////////
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

//////////////////////////////////
use Illuminate\Support\Facades\DB;

/////////////////////////////////
use App\Http\Requests\AlmacenarModeloRequest;

////////////////////////////////
//UTILIDADES
use Route;
use Session;
use Validator;
use Hash;
use Auth;

class LogController extends Controller
{
  /**
  * Función que permite listar los logs del sistema
  */

  public function index(){

    $mostrarlog = DB::table('logins')->orderby('id','desc')->limit(100)->get();
    return view('logs.index', compact('mostrarlog'));
  }

  public function buscar()
  {
      $busqueda = request()->get('seleccion');
      return view('logs.busqueda',compact('busqueda'));
  }

  public function mostrar()
  {
    $log = request()->get('seleccion');
    $numero = request()->get('numero');
    if($numero==1)
    {
      $mostrarlog = DB::table('dbo.logs')
      ->join('dbo.usuarios','dbo.logs.responsable_id','=','dbo.usuarios.id')
      ->select('dbo.logs.id','dbo.logs.nombre_tabla','dbo.logs.responsable_id','dbo.logs.accion','dbo.usuarios.nombre_usuario','dbo.logs.estado','dbo.logs.created_at','dbo.logs.updated_at')
      ->where('dbo.logs.responsable_id',$log)
      ->orderby('id','desc')
      ->get();

    }
    elseif($numero==2)
    {

      $mostrarlog = DB::table('dbo.logs')
      ->join('dbo.usuarios', 'dbo.logs.responsable_id', '=', 'dbo.usuarios.id')
      ->select('dbo.logs.id','dbo.logs.nombre_tabla','dbo.logs.responsable_id','dbo.logs.accion','dbo.usuarios.nombre_usuario','dbo.logs.estado','dbo.logs.created_at','dbo.logs.updated_at')
      ->whereDate('logs.created_at',$log)
      ->orderby('id','desc')
      ->get();
    }
    elseif($numero==3)
    {

      $mostrarlog = DB::table('dbo.logs')
      ->join('dbo.usuarios', 'dbo.logs.responsable_id', '=', 'dbo.usuarios.id')
      ->select('dbo.logs.id','dbo.logs.nombre_tabla','dbo.logs.responsable_id','dbo.logs.accion','dbo.usuarios.nombre_usuario','dbo.logs.estado','dbo.logs.created_at','dbo.logs.updated_at')
      ->where('dbo.logs.nombre_tabla','=',$log)
      ->orderby('id','desc')
      ->get();
    }
    else
    {
      $mostrarlog = DB::table('dbo.logs')
      ->join('dbo.usuarios', 'dbo.logs.responsable_id', '=', 'dbo.usuarios.id')
      ->select('dbo.logs.id','dbo.logs.nombre_tabla','dbo.logs.responsable_id','dbo.logs.accion','dbo.usuarios.nombre_usuario','dbo.logs.estado','dbo.logs.created_at','dbo.logs.updated_at')
      ->where('dbo.logs.accion','=',$log)
      ->orderby('id','desc')
      ->get();
    }

    if (count($mostrarlog)==0)
    {
      alert()->warning('Error','No se encontro ningun registro')->showconfirmbutton();
    }
    return view('logs.logins',compact('mostrarlog'));
  }



}
