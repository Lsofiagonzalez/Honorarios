<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controlUsuarios extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'controlUsuarios';

    protected $primaryKey = 'id';

    /**
     * Conexión de base de datos asociada
     */
    protected $connection = 'HONORARIOS';

    /**
	* Se desactivan los campos create_at y update_at
	*/
	public $timestamps = false;
    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        'id', 'idCargo', 'nomCargo', 'accesoGD', 'accesoCirujia', 'accesoIntranet', 'accesoReportes',
        'accesoSIV', 'accesoVehiculos', 'accesoMtoSis', 'accesoKsar', 'accesoCenso', 'accesoAccionS',
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

    
}
