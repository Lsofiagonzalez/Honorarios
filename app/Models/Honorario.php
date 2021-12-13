<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Honorario extends Model
{
    use HasFactory;

    /**
     * 
     */
    protected $table = 'HonorariosReal';

    /**
     * 
     */
    // protected $primaryKey = 'IDUSUA';

    /**
     * 
     */
    protected $connection = 'HONORARIOS';

    // protected $connection = 'DESARROLLO';
    /**
     * 
     */
    public $timestamps = false;

    /**
     * 
     */
    // protected $fillable = ['IDPROC'];
    protected $primaryKey = 'ID';


    protected $fillable = [
        'ID', 'NUM_PACIENTE', 'NOM_PACIENTE', 'CODSER', 'SERVICIO', 'HORA_MVTO','DOCCANTABLE','NU_FACPAC_MVTO',
        'CT_SER_MVTO','VL_TOT_MVTO','CXP_MED_MVTO','DIFERENCIA','ESTADO','MEDICO','RADICADO','NUM_ORDEN','AMBITO',
        'EST_ATEN','COD_MEDICO','ID_MVTO','ID_SOPORTE','ID_BOLETA'
    ];

    // public function medico()
    // {
    //     // return  ConsultaHonorario::where('')
    // }

}
