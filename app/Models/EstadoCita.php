<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCita extends Model
{
    use HasFactory;
    /**
     * 
     */
    protected $table = 'ESTADOCITA';


    /**
     * 
     */
    protected $connection = 'FORMULARIOS';

    // protected $connection = 'DESARROLLO';
    /**
     * 
     */
    public $timestamps = false;

    /**
     * 
     */
  
    protected $primaryKey = 'ID_ESTAD';


      protected $fillable = ['ESTADO'];
}
