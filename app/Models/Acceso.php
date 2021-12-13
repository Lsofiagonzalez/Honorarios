<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'accesos';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'submodulo_id', 'controlador', 'ruta_nombre', 'visible'
    ];

    /**
     * Obtiene el submódulo al que pertenece el acceso
     */
    public function submodulo()
    {
        return $this->belongsTo('App\Models\Submodulo');
    }

    /**
     * Se obtienen todos los permisos del acceso
     */
    public function permisos()
    {
        return $this->hasMany('App\Models\Permiso');
    }
}
