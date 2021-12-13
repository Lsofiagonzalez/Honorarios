<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class DetalleHonorarioCambio extends Model
{
    use HasFactory;
    /**
     * 
     */
    protected $table = 'DetalleHonorarioCambio';


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
  
    protected $primaryKey = 'ID';


      protected $fillable = ['ID_HON','EST_HON','EST_CAMBIO','MEDICO','OBSERVACION'];

      public static function consultarDetalleHonorario($idhonorarios)
    {
      $estadoConsulta = DB::connection('HONORARIOS')->select("SELECT EST_CAMBIO 
            FROM 
                DetalleHonorarioCambio
            WHERE 
                ID_HON =$idhonorarios");
                DB::disconnect('HONORARIOS');
                alert($idhonorarios);
                foreach ($estadoConsulta as $key => $estado)
                {        
                  return $estado->EST_CAMBIO;
                }
                
                // $estado = Arr::first($estadoConsulta);   
    }

}
