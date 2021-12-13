<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consecutivo extends Model
{
    use HasFactory;


     /**
     * 
     */
    protected $table = 'Consecutivo';


    /**
     * 
     */
    protected $connection = 'HONORARIOS';

    public $timestamps = false;


    protected $primaryKey = 'id';


    protected $fillable = [
        'id', 'prefijo', 'num_conse', 'tipo_documento'
    ];
}
