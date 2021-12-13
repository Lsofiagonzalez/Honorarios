<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Auth;

class Usuario_GD extends Model
{
  /**
  * Nombre de la tabla
  */
  protected $table = 'USUARIO';

  /**
  * Nombre del campo de la llave primaria
  */
  protected $primaryKey = 'IDUSUA';

  /**
  * Conexión de base de datos asociada
  */
  protected $connection = 'GD';

  /**
  * Se desactivan los timestamps (created_at y updated_at)
  */
  public $timestamps = false;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'IDUSUA', 'NOMUSU', 'APEUSU', 'IDCARG', 'CORUSU', 'CEDUSU', 'TIDUSU', 'LOGUSU', 'PASUSU', 'ROLUSU', 'FECCRE', 'HORCRE', 'ESTADO', 'PANUSU', 'DIAVIG', 'DAIAVI', 'INIUSU', 'FIRMA', 'firmaCorrespondencia', 'celular', 'telefono', 'direccion', 'ciudad'
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [
  'PASUSU', 'PANUSU',
];

/**
* Función que permite obtener el cargo en la tabla   al que pertenece el usuario
*/
public function cargo()
{
  //Se escribe el modelo al que pertenece, más el nombre de la llave foránea
  //return DB::conection('GD')->table('cargo')->where('IDCARG', '=', $this->IDCARG)->first();
  //Obtiene el cargo al que pertenece el usuario
  return $this->belongsTo('App\Models\cargo', 'IDCARG', 'IDCARG');

}

public static function nombreUsu($id)
{
  $gd_id = User::where('id',$id)->select('GD_id')->first();
  return Usuario_GD::where('IDUSUA',$gd_id->GD_id)->first();
} 

/**
 * Función si se habilitan entradas desde GD base de datos
 */
/*
public static function nombreUsu($id)
{
  if(strlen($id) == 3)
  {
    return Usuario_GD::where('IDUSUA',$id)->first();
  }
  else
  {
    $gd_id = Usuario::where('id',$id)->select('GD_id')->first();
    return Usuario_GD::where('IDUSUA',$gd_id->GD_id)->first();
  }
} */

public static function nombreUsu2($id)
{
  return User::where('GD_id',$id)->first();

}

public static function firma($id)
{
  $gd_id = User::where('id',$id)->select('GD_id')->first();
  //return Usuario_GD::where('IDUSUA',$gd_id->GD_id)->select('FIRMA')->first();
  $firma = Usuario_GD::where('IDUSUA',$gd_id->GD_id)->select('FIRMA')->first();
  $nombre = explode("\\",$firma);
  $archivo = substr ($nombre[count($nombre)-1], 0, strlen($nombre[count($nombre)-1]) - 2);
  return $archivo;

}

    //  /**
    //  * Obtener el nombre y APELLIDO.
    //  *
    //  * @return string
    //  */
    // public function getNameAndTypeAttribute($id)
    // {   
    //    $v = Usuario_GD::where('IDUSUA', $id)->select('NOMUSU')->first();
    //     return $v;
    // }

}
