<?php

namespace App\Http\Controllers;

use App\Models\ConsultaHonorario;
use Illuminate\Http\Request;
use App\Models\Boleta;
use App\Models\User;
use App\Models\SoportePago;
use App\Models\Sistema;
use App\Models\Honorario;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use App\Models\LogActividad;


class AuditorController extends Controller
{


    public function index()
    {
        
        $medicos = ConsultaHonorario::medicosHonorarios();

        // $sistema = Sistema::findOrFail(1);

        $boletas  = null;

        $soportes = null;

        $honorariosSoporteFaltantes = null;

        $honorariosBoletaFaltantes = null;

        $medicoConsultar ="";

        $estadoConsulta = 0;

        setlocale(LC_TIME, 'spanish');
        
        return view('auditores.consultar',compact('medicos',
        'boletas','soportes','medicoConsultar','honorariosSoporteFaltantes',
        'honorariosBoletaFaltantes','estadoConsulta'));
    }


    public function consultar(Request $request)
    {

        /**
         * 
         */
        $medicos = ConsultaHonorario::medicosHonorarios();


        $medicoConsultar = $request->medicoConsultar;
        /**
         * 
         */
        $usuario = ConsultaHonorario::medicoHonorario($medicoConsultar);


        /**
         * Código del médico en la tabla T_MEDICOS de la base de datos ESALUD. 
         */
        $codigoMedico = $usuario->COD_MD_MEDS;

      
        $sistema = Sistema::findOrFail(1);


        $fechaLimite = $sistema->fechaLimite()->format('Y-m-d');

        
        /**
         * Fecha inicial de la cual se va a consultar los servicios realizados.
         */
        $fechaInicial = date("Y-m-d", strtotime($sistema->mesAnterior()));


        /**
         * Fecha final en el intervalo de consulta de los servicios realizados por un médico.
         */
        $fechaFinal  =  date("Y-m-d", strtotime($fechaLimite));
        /**
         * 
         */

        /**
         * Se consulta las boletas del mes anterior y del mes actual con el fin de
         * comparar si los honorarios registrados en el soporte de pago tienen
         * boleta asociada.
         */
        $boletasPendientes = Boleta::where('COD_MED',$codigoMedico)
                           ->whereBetween('fechaInicio',[$fechaInicial,$fechaFinal])
                           ->get();
        
        /**
         * 
         */
        $cantidadServiciosBoletas = Boleta::where('COD_MED',$codigoMedico)
                                ->whereBetween('fechaInicio',[$fechaInicial,$fechaFinal])
                                ->sum('cantidad');

        /**
         * Se consulta las boletas del mes actual con el fin de
         * comparar si los honorarios registrados en las boletas tiene soporte 
         * pago en el mes actual.
         */

        $boletasActuales = Boleta::where('COD_MED',$codigoMedico)
                                ->whereBetween('fechaInicio',[$sistema->fechaEvaluada,$fechaFinal])
                                ->get();
        // return response($this->obtenerIdHonorariosBoletas($boletas));



        $usuarioCon = User::where('nombre_usuario',$request->medicoConsultar)->first();

        $soportes = null;

        if ($usuarioCon) 
        {
            $soportes = $usuarioCon->soportes()->whereBetween('fechaInicio',[$sistema->fechaEvaluada,$fechaFinal])->get();
        }
        
        /**
         * Se obtiene los ids de los honorarios pendientes y de los actuales que estan registrados en las boletas.
         */
        $idHonorariosBoletasPendientes = $this->obtenerIdHonorariosBoletas($boletasPendientes);


        /**
         * Se obtienen los ids de las honorarios actuales que estan registrados en las boletas
         */
        $idHonorariosBoletasActuales = $this->obtenerIdHonorariosBoletas($boletasActuales);

        /**
         * Se obtienen los ids de las honorarios actuales que se encuentran registrados en los soportes.
         */
        $idHonorariosSoporte = $this->obtenerIdHonorariosSoporte($soportes);


        /**
         * Se buscan los ids de los honorarios que están en los soportes de pago, pero no están ni en las boletas actuales,
         * ni en las del mes anterior. 
         */
        $idHonorariosSoporteFaltantes = $this->restarConjuntos($idHonorariosSoporte,$idHonorariosBoletasPendientes);


        /**
         * Se buscan los ids de los honorarios que están en la boletas de pago actuales, pero no tienen un soporte de pago asociado.
         */
        $idHonorariosBoletaFaltantes = $this->restarConjuntos($idHonorariosBoletasActuales,$idHonorariosSoporte);

        
        /**
         * Se obtiene los honorarios que están en los soportes de pago, pero no están ni en las boletas actuales,
         * ni en las del mes anterior.
         */
        $honorariosSoporteFaltantes = Honorario::whereIn('ID',$idHonorariosSoporteFaltantes)->get();

        /**
         * Se obtienen los honorarios que están en la boletas de pago actuales, pero no tienen un soporte de pago asociado.
         */
        $honorariosBoletaFaltantes = Honorario::whereIn('ID',$idHonorariosBoletaFaltantes)->get();

        $estadoConsulta = 1;

        $boletas = $boletasPendientes;


        /**
        * 
        */
            $logActividad = new LogActividad();
            $logActividad->actividad = 'Se generó el reporte de auditoría de '.$medicoConsultar;
            $logActividad->usuario_id = Auth::user()->id;
            $logActividad->save();

        /////////////////////////////////////////

        return view('auditores.consultar',compact('medicos',
        'boletas','soportes','medicoConsultar','honorariosSoporteFaltantes',
        'honorariosBoletaFaltantes','estadoConsulta'));
    }


    /**
     * Obtener los ids de los honorarios relacionados con las boletas generadas 
     * para un médico en la fecha actual del sistema.
     * @param $boletas las boletas a las cuales se les va a sacar los ids de los horarios seleccionados.
     */
    public function obtenerIdHonorariosBoletas($boletas)
    {
        $idHonorariosBoletas = array();

        foreach ($boletas as $key => $boleta)
        {
            $honorariosBoleta = $boleta->honorarios;

            foreach ($honorariosBoleta as $honorario) 
            {
               array_push($idHonorariosBoletas,$honorario->ID);
            }
        }
        return $idHonorariosBoletas;
    }

    /**
     * Obtener los ids de los honorarios relacionados con las boletas generadas 
     * para un médico en la fecha actual del sistema.
     * @param $boletas las boletas a las cuales se les va a sacar los ids de los horarios seleccionados.
     */
    public function obtenerIdHonorariosSoporte($soportes)
    {
       $idHonorariosSoporte = array(); 

        if ($soportes) 
        {
            foreach ($soportes as $soporte) 
            {
                    $honorariosSoporte = $soporte->honorarios;

                    foreach ($honorariosSoporte as $honorario) 
                    {
                        array_push($idHonorariosSoporte,$honorario->ID);
                    }
            }
            
        }
        return $idHonorariosSoporte;
    }



    /**
     * Restar los elementos de un conjunto de datos, es decir, encontrar los elementos de A que no están en B.
     * @param $conjuntoA es el conjunto del cual se va comprobar si sus elementos están en el otro conjunto. 
     * @param $conjuntoB es el conjunto del cual se comparan los datos.
     * @return los elementos que estan en A y no están en B.
     */
    public function restarConjuntos($conjuntoA, $conjuntoB)
    {
        $diferencia = array();

        foreach ($conjuntoA as $elementoA)
        {
            if (!in_array($elementoA,$conjuntoB))
            {
                array_push($diferencia,$elementoA);
            }
        }

        return $diferencia;
    }

}
