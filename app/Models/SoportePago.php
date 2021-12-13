<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoportePago extends Model
{
    use HasFactory;

    protected $table = 'SoportePago';


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
        'id', 'radicado', 'fechaInicio','ID_AMBITO', 'fechaFinal', 'cantidad','total','generado_por','ubicacionPDF','created_at','updated_at'
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
    public function honorarios()
    {
        return $this->hasMany(Honorario::class,'ID_SOPORTE');
    }
}
