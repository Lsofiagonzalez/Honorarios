<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'Modulos';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'icono', 'visible',
    ];

    /**
     * Obtiene los submódulos para cada módulo
     */
    public function submodulos()
    {
        return $this->hasMany('App\Models\Submodulo');
    }

    /**
     * Obtiene los submódulos para cada módulo
     */
    public function submodulosPermiso($rol)
    {
        return $rol->submodulos()->where('modulo_id', '=', $this->id);
    }
}
