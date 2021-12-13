<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable;
    /**
     * 
     */
    protected $table = 'usuariosAPP';

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
    public $timestamps = true;

    /**
     * 
     */
    // protected $fillable = ['IDPROC'];
    protected $primaryKey = 'id';


    protected $fillable = [
        'id', 'GD_id', 'estado', 'rol_id', 'nombre_usuario', 'password', 
    ];

    /**
    * Cambios en la configuracion original de Laravel para login
    * 1. En esta clase, crear la funcion  getAuthPassword()
    * 2. En app\Http\Controllers\Auth\LoginController.php se crea la funcion username()
    * 3. app\Extensions\MyEloquentUserProvider.php se crea completamente este archivo.
    * 4. app\Providers\AuthServiceProvider.php acá se agrega MyEloquentUserProvider
    *    y en la funcion boot se agrega   Auth::provider
    * 5. Se modifica config\auth.php configurando la nueva guard 'Custom'
    */
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'PASUSU', 'remember_token',
    // ];

    protected $hidden = [
            'password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        // return $this->PASUSU;

        return $this->password;
    }
    /**
     * 
     */
    public function rol()
    {
        return $this->belongsTo('App\Models\Rol');
    }

    /**
     * 
     */
    public function medicoHonorario()
    {
        $usuarios =  DB::connection('ESALUD')->select("SELECT MED.COD_MD_MEDS, PER.TP_ID_PERS,
        MED.IDENT_MD_MEDS,PER.IDENTIF_PERS, PER.MAIL_PERS AS CORREO, PER.TEL_PERS AS TELEFONO,
        PER.CEL_PERS AS CELULAR, (PER.PRINOM_PERS+' '+PER.SEGNOM_PERS+' '+PER.SEGAPE_PERS) AS NOMBRE
        FROM T_PERSONAL AS PER, T_MEDICOS AS MED, T_USR AS U
        WHERE 
        PER.IDENTIF_PERS = MED.IDENT_MD_MEDS 
        AND PER.TP_ID_PERS = MED.TP_IDMD_MEDS
		AND U.IDENTIF_PERS = PER.IDENTIF_PERS
        AND U.TP_ID_PERS = 'CC'
        AND (PER.PRIAPE_PERS LIKE '%HON%' OR MED.COD_MD_MEDS = '9475' or PRIAPE_PERS = 'ESALUD') 
        AND MED.COD_MD_MEDS != '0475'
		AND U.ID_USR = ? ", array($this->nombre_usuario));

        $usuario = Arr::first($usuarios);

        return $usuario;
    }

    public function especialidades()
    {
        $medico = $this->medicoHonorario();
        $especialidades = DB::connection('ESALUD')->select("SELECT T_ESP.* FROM T_MEDICOXESPEC, T_ESP 
        WHERE T_ESP.ID_ESP=T_MEDICOXESPEC.COD_ESP_MDXESP 
        AND T_MEDICOXESPEC.COD_MD_MDXESP = ?", array($medico->COD_MD_MEDS));
        DB::disconnect('ESALUD');

        return $especialidades;
    }

    /**
     * 
     */
    public function usuarioGD()
    {
        return $this->belongsTo(Usuario_GD::class,'GD_id');
    }

    /**
     * 
     */
    public function boletasAuxiliar()
    {
        return $this->hasMany(Boleta::class, 'generado_por');
    }


    /**
     * 
     */
    public function boletasMedico()
    {
        $medicoTemp = $this->medicoHonorario();

        return Boleta::where('COD_MED',$medicoTemp->COD_MD_MEDS)->get();
    }


    /**
     * 
     */
    public function soportes()
    {
        return $this->hasMany(SoportePago::class, 'generado_por');
    }
}
