<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActividad extends Model
{
    use HasFactory;


     /**
     * 
     */
    protected $table = 'LogActividad';


    /**
     * 
     */
    protected $connection = 'HONORARIOS';

    /**
     * 
     */
    public $timestamps =false;

    /**
     * 
     */
    protected $primaryKey = 'id';


    /**
     * 
     */
    protected $fillable = ['actividad','usuario_id','created_at','updated_at'];


    public function usuario()
    {
       return $this->belongsTo(User::class,'usuario_id');
    }


}
