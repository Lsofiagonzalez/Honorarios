<?php

/**
 * Representa al usuario con el cual se inicia sesión en E-Salud.
 * @author Julio R. Valverde (Aux. Sistemas).
 * Fecha creación: 22/01/2021.
 * Fecha modificación: 22/01/2021.
 * @version 1.0.0
 */

namespace App\Models\Esalud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioES extends Model
{
    use HasFactory;

    /**
     * 
     */
    protected $table = 'T_USR';

    /**
     * 
     */
    protected $connection = 'ESALUD';


    /**
     * 
     */
    public $timestamps = false;

    /**
     * 
     */
    // protected $fillable = ['IDPROC'];
    // protected $primaryKey = 'ID_USR';


    /**
     * No se permite insertar ningún campo de esta tabla en la base de datos.
     */
    protected $fillable = [];


    public function medico()
    { 
        $usuarios =  DB::connection('ESALUD')->select("SELECT MED.COD_MD_MEDS, PER.TP_ID_PERS,
        MED.IDENT_MD_MEDS,PER.IDENTIF_PERS, 
        (PER.PRINOM_PERS+' '+PER.SEGNOM_PERS+' '+PER.SEGAPE_PERS) AS NOMBRE
        FROM T_PERSONAL AS PER, T_MEDICOS AS MED
        WHERE 
        PER.IDENTIF_PERS = MED.IDENT_MD_MEDS 
        AND PER.TP_ID_PERS = MED.TP_IDMD_MEDS 
        AND (PER.PRIAPE_PERS LIKE '%HON%' OR MED.COD_MD_MEDS = '9475' or PRIAPE_PERS = 'ESALUD') 
        AND MED.COD_MD_MEDS != '0475'
        AND PER.IDENTIF_PERS = '75085796'");
        DB::disconnect('ESALUD');

        $usuario = Arr::first($usuarios);

        return $usuario;
    }
}
