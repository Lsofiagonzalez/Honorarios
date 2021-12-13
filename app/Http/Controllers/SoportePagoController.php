<?php

/**
 * Controlador para realizar las operaciones relacioanda con los soportes de pago.
 * @author Julio R. Valverde (Aux. Sistemas).
 * Fecha creación: 28/01/2021.
 * Fecha modificación: 28/01/2021.
 * @version 1.0.0
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoportePago;
use Illuminate\Support\Facades\Storage;
use App\Models\Honorario;
use Illuminate\Support\Facades\Auth;
use App\Models\Sistema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionSoporte;


class SoportePagoController extends Controller
{
    
    /**
     * Visualizar el pdf de un soporte de pago.
     * @param $soporte    el soporte del cual se quiere visualizar el pdf.
     */
    public function verPDF(SoportePago $soporte)
    {
        if (Storage::disk('local')->exists($soporte->ubicacionPDF)) {
            return Storage::disk('local')->response($soporte->ubicacionPDF);
        }
    }

    /**
     * Descargar el pdf de un soporte de pago.
     * @param $soporte el soporte del cual se quiere descargar el pdf.
     */
    public function descargarPDF(SoportePago $soporte)
    {

        if (Storage::disk('local')->exists($soporte->ubicacionPDF)) {
            return Storage::disk('local')->download($soporte->ubicacionPDF);
        }
    }

    /**
     * Editar un soporte de pago que se haya realizado en el mes en el que se encuentra el sistema.
     * @param $soporte  el soporte de pago que se quiere editar.
     * @return  la vista para editar el soporte.
     */
    public function editar(SoportePago $soporte)
    {
        $usuario = Auth::user()->medicoHonorario();
        
        $codigoMedico = $usuario->COD_MD_MEDS;

        $fechaFinal = null;
        $fechaInicial = null;
        $nombre = $usuario->NOMBRE;
        $total = 0;
        $ambito = $soporte->ID_AMBITO;

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

        
        $honorarios = Honorario::where('COD_MEDICO',$codigoMedico)
        ->where('AMBITO',$ambito)
        ->whereIn('ID_SOPORTE',[0,$soporte->id])
        ->whereBetween('HORA_MVTO',[$fechaInicial,$fechaFinal])
        ->get();

        $total = Honorario::where('COD_MEDICO',$codigoMedico)
            ->where('AMBITO',$ambito)
            ->whereIn('ID_SOPORTE',[0,$soporte->id])
            ->whereBetween('HORA_MVTO',[$fechaInicial,$fechaFinal])
            ->sum('CXP_MED_MVTO');

        $fechaInicial = $sistema->fechaEvaluada;

        return view('medicos.soporte-pago.editar', compact('soporte','honorarios','fechaInicial','fechaFinal','nombre','total','ambito'));
    }

    /**
     * Confirmar la actualización de un soporte de pago.
     * @param $soporte el soporte de pago  que se quiere actualizar
     * @param $request los datos que se quieren actualizar en el soporte.
     * @return la vista para descargar o enviar por correo el pdf del soporte actualizado.
     */
    public function confirmarActualizacion(Request $request,SoportePago $soporte)
    {
        $idHonorariosSeleccionados = $request->honorarios;

        // return response($idHonorariosSeleccionados);
        /**
         * 
         */
        $fechaInicio = $request->fechaInicial;

        /**
         * 
         */
        $fechaFinal = $request->fechaFinal;

        /**
         * 
         */
        $ambito = $request->ambito;

        if($idHonorariosSeleccionados)
        {
            $honorarios = Honorario::whereIn('ID',$idHonorariosSeleccionados)->get();

            $total = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CXP_MED_MVTO');
            /**
             * Nombre completo del médico que realiza el soporte.
             */
            $nombreMedico = $request->nombreMedico;

            return view('medicos.soporte-pago.confirmar',compact('honorarios','nombreMedico','total','fechaInicio','fechaFinal','ambito','soporte'));    
        }
        else
        {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Actualizar la información relacionada a un soporte de pago.
     * @param $soporte el soporte de pago  que se quiere actualizar
     * @param $request los datos que se quieren actualizar en el soporte.
     */
    public function actualizarSoporte(Request $request,SoportePago $soporte)
    {
        $this->revertirEstadoHonorarios($soporte->honorarios);

        $idHonorariosSeleccionados = $request->honorariosGenerar;

        // return response($idHonorariosSeleccionados);
       
        $honorarios = Honorario::whereIn('ID',$idHonorariosSeleccionados)->get();

        $total = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CXP_MED_MVTO');

        $cantidadTotal = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CT_SER_MVTO');
        /**
        * Nombre completo del médico que realiza el soporte.
        */
        $nombreMedico = $request->nombreMedico;

        $carpeta = 'SOPORTES';

        $radicado = $soporte->radicado;

        // dd($pdf);
        /**
         * Ruta donde se guardará el archivo en el servidor.
         */
        $ubicacionPDF = $carpeta.'/'.$radicado.'.pdf';

        $soporte = $this->actualizarSoporteRecibido($soporte,$cantidadTotal,$total,$radicado);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('medicos.pdf',compact('soporte','honorarios','total','nombreMedico','cantidadTotal','radicado'));
        
        Storage::disk('local')->put($ubicacionPDF,$pdf->output());

        $this->actualizarEstadoHonorarios($honorarios, $soporte);

        /**
         * Opción 1 para generar y descargar el soporte.
         * Opción 2 para generar y enviar el soporte por correo.
         */
        if($request->opcion==1)
        {
            return $pdf->download($radicado.'.pdf');
        }
        else
        {
            /**
            * Descomentar esta y linea para enviar la boleta al médico y comentar 
            * la línea de la declaración de $correo del 'aux.nomina@hiu.org.co'
            */
            $correo = $soporte->autor->medicoHonorario()->CORREO;

            
            //$correo = "aux.nomina@hiu.org.co";
            if($correo)
            {
                        // return response('Enviando correo');
                Mail::to($correo)->send(new NotificacionSoporte($pdf->output(),$soporte));
                return redirect()->route('medicos.listar-soportes')
                            ->with('success','Se generó el soporte de pago '.$soporte->radicado.',y envió por correo éxitosamente.');
            }
            else
            {
                return redirect()->route('medicos.listar-soportes')
                ->with('warning','Se generó el soporte de pago '.$soporte->radicado.', pero no se pudo enviar por correo.');
            }

        }

    }

    /**
     * Actualizar la información de un soporte de pago
     * @param $soporte            el soporte de pago que se quiere actualizar.
     * @param $cantidadTotal      la cantidad de servicios que se facturaron en el soporte de pago.
     * @param $total              el total en dinero de los servicios facturados.
     * @param $radicado           el radicado del soporte de pago que se quiere actualizar.
     * @return el soporte de pago actualizado.
     */
    public function actualizarSoporteRecibido($soporte,$cantidadTotal,$total,$radicado)
    {
       $soporte->cantidad = $cantidadTotal;
       $soporte->total = $total;
       $soporte->update();

       return SoportePago::where('radicado',$radicado)->first();

    }

    /**
     * Revertir la información de los estados de los honorarios.
     * @param $honorarios  los honorarios a los cuales se les va a cambiar el estado.
     */
    public function revertirEstadoHonorarios($honorarios)
    {
       foreach ($honorarios as $key => $honorario) 
       {
           $honorario->ID_SOPORTE = 0;
           $honorario->ESTADO = 'NO PAGO';
           $honorario->update();
       }
    }

    /**
     * Actualizar el estado de los honorarios asociados a un soporte de pago.
     * @param $honorarios  los honorarios a los cuales se les va a cambiar el estado.
     * @param $soporte  el soporte de pago asociado a los honorarios.
     */
    public function actualizarEstadoHonorarios($honorarios, $soporte)
    {
       foreach ($honorarios as $key => $honorario) 
       {
           $honorario->ID_SOPORTE = $soporte->id;
           $honorario->ESTADO = 'PENDIENTE';
           $honorario->update();
       }
    }
}
