<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'permisos';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        //nombre, descripcion, estado, rol_id
        'id', 'rol_id', 'acceso_id'
    ];

    /**
     * Se obtiene el rol al que pertenece el permiso
     */
    public function rol()
    {
        return $this->belongsTo('App\Models\Rol');
    }

    /**
     * Se obtiene el acceso al que pertenece el permiso
     */
    public function acceso()
    {
        return $this->belongsTo('App\Models\Acceso');
    }
    
}
