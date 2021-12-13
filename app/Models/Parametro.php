<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'PARAMETRO';

    protected $connection = 'GD';
    
    protected $primaryKey = 'IDPARA';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        'IDPARA', 'ABRPAR', 'NOMPAR', 'IDTABL',
    ];

    
    /**
     * Obtiene el módulo al que pertenece el submódulo
     */
    /*public function parametroTabla()
    {
        return $this->belongsTo('App\Models\ParametroTabla');
    }*/
}
