<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Boleta extends Model
{
    use HasFactory;

    /**
     * 
     */
    protected $table = 'Boleta';


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
    protected $primaryKey = 'id';


    protected $fillable = [
        'id', 'radicado', 'fechaInicio', 'fechaFinal', 'cantidad','COD_MED','ID_AMBITO',
        'generado_por','ubicacionPDF','created_at','updated_at'
    ];

    /**
     * 
     */
    public function autor()
    {
        return $this->belongsTo(User::class,'generado_por');
    }

    /**
     * 
     */
    public function ambito()
    {
        return $this->belongsTo(Ambito::class,'ID_AMBITO');
    }
    /**
     * 
     */
    public function receptor()
    {
       return ConsultaHonorario::medicoHonorarioPorCodigo($this->COD_MED);
    }

    public function especialidadesReceptor()
    {
        $especialidades = DB::connection('ESALUD')->select("SELECT T_ESP.* FROM T_MEDICOXESPEC, T_ESP 
        WHERE T_ESP.ID_ESP=T_MEDICOXESPEC.COD_ESP_MDXESP 
        AND T_MEDICOXESPEC.COD_MD_MDXESP = ?", array($this->COD_MED));
        DB::disconnect('ESALUD');

        return $especialidades;
    }

    public function honorarios()
    {
        return $this->hasMany(Honorario::class,'ID_BOLETA');
    }
}
