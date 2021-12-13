<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sistema;
use App\Models\LogActividad;
use Illuminate\Support\Facades\Auth;

class SistemaController extends Controller
{
    /**
     * Ver la configuración del sistema referente a las fechas y estados del sistema.
     * @return sistema.ver la vista donde se puede visualizar la información del sistema.
     */
    public function verConfiguracion()
    {
        $sistema = Sistema::findOrFail(1);
        setlocale(LC_TIME, 'spanish');
        
        /**
         * Guardar las entradas a la configuración del sistema.
         */
        $logActividad = new LogActividad();
        $logActividad->actividad = 'Ingreso a la configuración del sistema.';
        $logActividad->usuario_id = Auth::user()->id;
        $logActividad->save();
        ///////////////////////////////


        return view('sistema.ver',compact('sistema'));
    }

    /**
     *Definir el mes anterior como mes actual del sistema.
     */
    public function definirMesAnterior()
    {
        $sistema = Sistema::findOrFail(1);

        $nuevoPeriodo = $sistema->mesAnterior();

        $sistema->fechaEvaluada = $nuevoPeriodo;
        $sistema->update();

        $logActividad = new LogActividad();
        $logActividad->actividad = 'Se cambió '.strftime('%B - %Y', strtotime($nuevoPeriodo));
        $logActividad->usuario_id = Auth::user()->id;
        $logActividad->save();


        return back()->with('success','El mes anterior ha sido definido con éxito.');
    }


    /**
     * Definir el mes siguiente como mes actual del sistema.
     */
    public function definirMesSiguiente()
    {
        $sistema = Sistema::findOrFail(1);

        $sistema->fechaEvaluada = $sistema->mesSiguiente();
        $sistema->update();

        return back()->with('success','El mes siguiente ha sido definido con éxito.');
    }

    /**
     * Cerrar el sistema.
     */
    public function cerrarSistema()
    {
        $sistema = Sistema::findOrFail(1);

        $sistema->estado = 0;
        $sistema->update();

        return back()->with('success','El sistema se ha cerrado con éxito.');
    }

    /**
     * Abrir el sistema.
     */
    public function abrirSistema()
    {
        $sistema = Sistema::findOrFail(1);

        $sistema->estado = 1;
        $sistema->update();

        return back()->with('success','El sistema se ha abierto con éxito.');
    }

    public function errorPermiso()
    {
        return view('errores.permisos');
    }

    /**
     * Definir el número de días hábiles para seguir generando boletas mientras el sistema 
     * se encuentra en una fecha anterior.
     */
    public function definirDiasHabiles(Request $request)
    {
        $sistema = Sistema::findOrFail(1);
        $sistema->diasHabiles = $request->diasHabiles;
        $sistema->update();

        return back()->with('success','Se ha definido el número de días hábiles para generar boletas de manera exitosa.');
    }
}
