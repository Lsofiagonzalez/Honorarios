<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submodulo extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'Submodulos';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'icono', 'visible', 'modulo_id'
    ];

    /**
     * Obtiene el módulo al que pertenece el submódulo
     */
    public function modulo()
    {
        return $this->belongsTo('App\Models\Modulo');
    }

    /**
     * Obtiene los accesos para cada submodulo
     */
    public function accesos()
    {
        return $this->hasMany('App\Models\Acceso');
    }

    public function accesosVisibles()
    {
        return $this->hasMany('App\Models\Acceso')->where('visible','=','1')->get();
    }

    /**
     * Obtiene los accesos para cada submodulo
     */
    public function accesosMenu()
    {
        return $this->hasMany('App\Models\Acceso')->where([
            ['estado', '=', '1'],
            ['visible', '=', '1']
        ])->orderBy('nombre')->get();
    }

    /**
     * Obtiene los accesos para cada submodulo dependiendo de los permisos del rol
     */
    public function accesosPermiso($rol)
    {
        return $rol->accesos()->where('submodulo_id', '=', $this->id);
    }
}
