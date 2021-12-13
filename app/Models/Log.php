<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Datetime;

class Log extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'logs';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        'registro_id', 'nombre_tabla', 'accion', 'responsable_id', 'estado'
    ];

    /**
     * Obtiene los logs relacionados con un usuario
     */
    public function responsable()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function verboPasado(){
        switch ($this->accion) {
            case 'crear':
                return 'creó';
                break;

            case 'almacenar':
                return 'almacenó';
                break;

            case 'editar':
                return 'editó';
                break;

            case 'actualizar':
                return 'actualizó';
                break;

            case 'eliminar':
                return "eliminó";
                break;
            
            default:
                return $this->accion;
                break;
        }
    }

    /**
     * Función que permite conocer el tiempo entre la fecha actual y en la que se creó el 
     * registro
     */
    public function diferenciaFechaCreacion($fecha){
        $diferencia = "hace ";

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
}
