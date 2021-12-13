<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sistema;
use App\Models\LogActividad;

class DashboardController extends Controller
{
    
    public function index()
    {

        $sistema = Sistema::findOrFail(1);

        /**
         * Guardar las entradas al dashboard.
         */
        $logActividad = new LogActividad();
        $logActividad->actividad = 'Visualización del dashboard.';
        $logActividad->usuario_id = Auth::user()->id;
        $logActividad->save();
        ///////////////////////////////

        if(Auth::user()->rol->id==3)
        {
            return view('dashboard.medico',compact('sistema'));
        }
        if(Auth::user()->rol->id==4)
        {
            return view('dashboard.auxiliar',compact('sistema'));
        }
        if(Auth::user()->rol->id==5)
        {
            return view('dashboard.auditor',compact('sistema'));
        }
        if(Auth::user()->rol->id==6)
        {
            return view('dashboard.generico',compact('sistema'));
        }
        return view('dashboard.dashboard',compact('sistema'));
       
    }
}
