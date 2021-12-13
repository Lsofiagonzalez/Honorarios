<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambito extends Model
{
    use HasFactory;
    /**
     * 
     */
    protected $table = 'Ambito';


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
  
    protected $primaryKey = 'id';


      protected $fillable = ['nombre','estado'];
}
