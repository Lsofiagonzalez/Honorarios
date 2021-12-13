<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sistema extends Model
{
    use HasFactory;


      /**
     * 
     */
    protected $table = 'Sistema';


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
    protected $fillable = ['fechaEvaluada','diasHabiles','estado'];

    protected $primaryKey = 'id';


    public function fechaLimite()
    {
       return Carbon::create($this->fechaEvaluada)->addMonth()->subDay();
    }

    /**
     * Obtener la fecha limite del sistemas + los días adicionales.
     */
    public function fechaLimiteConDiasHabiles()
    {
      $fechaLimite = $this->fechaLimite();
       return  $fechaLimite->addDays($this->diasHabiles);
    }

    /**
     * Obtener la fecha limite del sistemas + los días adicionales en formato aaaa-mm-dd.
     */
    public function fechaLimiteConDiasHabilesText()
    {
    
       return  $this->fechaLimiteConDiasHabiles()->format('Y-m-d');
    }


    /**
     * Obtener la fecha limite del sistema en formato aaaa-mm-dd.
     * @return la fecha limite del sistema en formato aaaa-mm-dd.
     */
    public function fechaLimiteText()
    {
       return $this->fechaLimite()->format('Y-m-d');
    }

    /**
     * Obtener el mes anterior a la fecha del sistema.
     */
    public function mesAnterior()
    {
      return Carbon::create($this->fechaEvaluada);
    }

     /**
     * Obtener el mes anterior a la fecha del sistema en formato aaaa-mm-dd.
     */
    public function mesAnteriorText()
    {
      return Carbon::create($this->fechaEvaluada)->subMonth()->format('Y-m-d');
    }

    /**
     * Obtener el mes siguiente a la fecha del sistema.
     */
    public function mesSiguiente()
    {
      return Carbon::create($this->fechaEvaluada)->addMonth();
    }

    /**
     * Obtener el mes siguiente a la fecha del sistema en formato aaaa-mm-dd.
     */
    public function mesSiguienteText()
    {
      return Carbon::create($this->fechaEvaluada)->addMonth()->format('Y-m-d');
    }
}
