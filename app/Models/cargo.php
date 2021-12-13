<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
  /**
  * Tabla a la que referencia el modelo
  */
  protected $table = 'CARGO';

  protected $primaryKey = 'IDCARG';

  /**
  * Conexión de base de datos asociada
  */
  protected $connection = 'GD';


  /**
  * Los atributos asignables
  *
  * @var array
  */
  protected $fillable = [
    'IDCARG', 'NOMCAR', 'IDPROC',
  ];

  /**
  * Obtiene los usuarios para cada cargo
  */
  public function usuarios()
  {
    return $this->hasMany('App\Models\Usuario_GD');
  }

  public function usuarios2()
  {
    return $this->hasMany('App\Models\Usuario');
  }

  public static function nomcargo($id)
  {
    $gd = User::where('id',$id)->select('GD_id')->first();
    $cargo = Usuario_GD::where('IDUSUA',$gd->GD_id)->select('IDCARG')->first();
    return cargo::where('IDCARG',$cargo->IDCARG)->select('NOMCAR')->first();
  }

  public static function ncargo($id)
  {
    return cargo::where('IDCARG',$id)->select('NOMCAR')->first();
  }


}
