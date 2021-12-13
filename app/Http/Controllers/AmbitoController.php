<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ambito;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActividad;


class AmbitoController extends Controller
{
    /**
     * Listar los ámbitos disponibles en el sistema.
     */
    public function index()
    {
        $ambitos = Ambito::get();

        return view('ambitos.index',compact('ambitos'));
    }

    /**
     * Cambiar el estado de un ámbito.
     * @param $ambito El ambito al cual se le quiere cambiar el estado.
     */
    public function cambiarEstado(Ambito $ambito)
    {

        
        $estado = $ambito->estado;
        if($estado==1)
        {
            /**
             * Poner el ámbito en inactivo.
             */
            $ambito->estado = 0;

            /**
             * 
             */
            $logActividad = new LogActividad();
            $logActividad->actividad = 'Inhabilitó el ámbito de '.$ambito->nombre;
            $logActividad->usuario_id = Auth::user()->id;
            $logActividad->save();
            
            ///////////////////////////////

        }
        else
        {
            /**
            * 
            */
            $logActividad = new LogActividad();
            $logActividad->actividad = 'Habilitó el ámbito de '.$ambito->nombre;
            $logActividad->usuario_id = Auth::user()->id;
            $logActividad->save();
        
            ///////////////////////////////
            $ambito->estado = 1;
        }

        $ambito->update();

        return back()->with('success','Cambio de estado exitoso.');
    }
}
