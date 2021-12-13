<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

use DateTime;
use Carbon;

class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * Nombre de la tabla
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'GD_id', 'estado', 'rol_id', 'nombre_usuario', 'password', 
    ];

    protected $primaryKey = 'id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'created_at', 'updated_at',
        'password', 'remember_token',
    ];

    /**
     * Obtiene el rol al que pertenece el usuario
     */
    public function datos($id)
    { 
        //$id = $_GET['id'];
        //dd($id);
        $usuario= new Usuario_GD;
        $usuario = Usuario_GD::where('IDUSUA','=',$id)->first();
        dd($usuario);
        return Response::json($usuario);
        //$this->hasOne('App\Models\Usuario_GD', 'IDUSUA', $id);

    }

    public function rol()
    {
        return $this->belongsTo('App\Models\Rol');
    }

    public function asignacionR()
    {
        return $this->hasMany('App\Models\Asignacion', 'asiUsuarioId', 'id');
    }

    public function asignacionU()
    {
        return $this->hasMany('App\Models\Asignacion', 'asiUsuarioId', 'id');
    }


    /**
     * Se obtienen los logs que posee el usuario
     */
    public function logs()
    {
        return $this->hasMany('App\Models\Log');
    }

    /**
     * Obtiene el usuario en gestión documental relacionado
     */
    public function usuario_GD()
    {
        return $this->hasOne('App\Models\Usuario_GD', 'IDUSUA', 'GD_id');
    }

    public function cargo()
    {
        //Obtiene el cargo al que pertenece el usuario      
           return $this->belongsTo('App\Models\cargo', 'usuCargo', 'IDCARG');
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }
 
    /**
     * Función que permite conocer el tiempo entre la fecha actual y en la que se creó el 
     * registro
     */
    public function diferenciaFechaCreacion($fecha){
        $diferencia = "hace";
        //dd(Carbon\Carbon::now());
        
        if(!$this->created_at->diff(new Datetime())->y && 
            !$this->created_at->diff(new Datetime())->m && 
            !$this->created_at->diff(new Datetime())->d && 
            !$this->created_at->diff(new Datetime())->h && 
            !$this->created_at->diff(new Datetime())->i){
            return $diferencia . "unos segundos";
        }

        if($this->created_at->diff(new Datetime())->d){
            if($this->created_at->diff(new Datetime())->y){
                if($this->created_at->diff(new Datetime())->y == 1){
                    $diferencia = $diferencia . "1 año";
                }else{
                    $diferencia = $diferencia . $this->created_at->diff(new Datetime())->y . " años";
                }
    
                if($this->created_at->diff(new Datetime())->m && $this->created_at->diff(new Datetime())->d){
                    $diferencia = $diferencia . ", ";
                }else if($this->created_at->diff(new Datetime())->m){
                    $diferencia = $diferencia . " y ";
                }
            }
    
            if($this->created_at->diff(new Datetime())->m){
                if($this->created_at->diff(new Datetime())->m == 1){
                    $diferencia = $diferencia . "1 mes";
                }else{
                    $diferencia = $diferencia . $this->created_at->diff(new Datetime())->d . " meses";
                }
    
                if($this->created_at->diff(new Datetime())->d){
                    $diferencia = $diferencia . " y ";
                }
            }
    
            if($this->created_at->diff(new Datetime())->d){
                if($this->created_at->diff(new Datetime())->d == 1){
                    $diferencia = $diferencia . "1 día";
                }else{
                    $diferencia = $diferencia . $this->created_at->diff(new Datetime())->d . " días";
                }
            }
        }else
        {
            if($this->created_at->diff(new Datetime())->h){
                if($this->created_at->diff(new Datetime())->h == 1){
                    $diferencia = $diferencia . "1 hora";
                }else{
                    $diferencia = $diferencia . $this->created_at->diff(new Datetime())->h . " horas";
                }
    
                if($this->created_at->diff(new Datetime())->i){
                    $diferencia = $diferencia . " y ";
                }
            }
    
            if($this->created_at->diff(new Datetime())->i){
                if($this->created_at->diff(new Datetime())->i == 1){
                    $diferencia = $diferencia . "1 minuto";
                }else{
                    $diferencia = $diferencia . $this->created_at->diff(new Datetime())->i . " minutos";
                }
            }
        }
        return $diferencia; 
    }

    public function Equipment()
    {
        return $this->belongsTo('App\Models\Equipment');
    }

    public function Maintenance()
    {
        return $this->hasMany('App\Models\Maintenance');
    }
}

