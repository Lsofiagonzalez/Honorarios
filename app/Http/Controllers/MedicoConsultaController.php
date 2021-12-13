<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Models\Honorario;
use App\Models\ConsultaHonorario;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\GenerarSoporteRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\SoportePago;
use App\Models\Consecutivo;
use Illuminate\Support\Facades\Storage;
use App\Mail\NotificacionSoporte;
use Illuminate\Support\Facades\Mail;
use App\Models\Sistema;
use Carbon\Carbon;
use App\Models\Ambito;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Models\LogActividad;
use PhpParser\Node\Stmt\Echo_;

class MedicoConsultaController extends Controller
{
    
    public function verFormulario()
    {
        $datos = null;
        $fechaFinal = null;
        $fechaInicial = null;
        $nombre = null;
        $idsTemp = array();
  
        $ambitos = Ambito::where('estado',1)->orderBy('nombre')->get();
        
        // Alert::success('Success Title', 'Success Message');
        return view('medicos.create', compact('datos','fechaInicial',
        'fechaFinal','nombre','idsTemp','ambitos'));
    }

    /**
     * 
     */
    public function consultar(Request $request)
    {

        $sistema = Sistema::findOrFail(1);

        $idsTemp = array();
        
        $ambito = $request->ambitoConsultar;
        // $medicoConsultar = null;

        $ambitos = Ambito::where('estado',1)->orderBy('nombre')->get();

        $soporteTemp = SoportePago::where('generado_por', Auth::user()->id)
                                    ->whereDate('fechaInicio',$sistema->fechaEvaluada)
                                    ->where('ID_AMBITO',$ambito)
                                    ->first();
        /**
        * Se obtiene el usuario atenticado.
        */
        $usuario = Auth::user()->medicoHonorario();
                
        $datos = "";
                // return response($usuario);
                
        /**
        * Tipo de identificación del médico.
        */
        $tipoDocumento = $usuario->TP_ID_PERS;

        /**
        * Código del médico en la tabla T_MEDICOS de la base de datos ESALUD. 
        */
        $codigoMedico = $usuario->COD_MD_MEDS;

        /**
        * Número de identificación del médico.
        */
        $numeroIdentificacion = $usuario->IDENT_MD_MEDS;

        /**
        * Nombre completo del médico.
        */
        $nombre = $usuario->NOMBRE;


        // $sistema = Sistema::findOrFail(1);


        $fechaLimite = $sistema->fechaLimite()->format('Y-m-d');

                
        /**
        * Fecha inicial de la cual se va a consultar los servicios realizados.
        */
        $fechaInicial =  date("Y-m-d", strtotime($sistema->mesAnterior()));
        $anioInicial =  date("Y", strtotime($sistema->mesAnterior()));
        $mesInicial =  date("m", strtotime($sistema->mesAnterior()));
        


        /**
        * Fecha final en el intervalo de consulta de los servicios realizados por un médico.
        */
        $fechaFinal  =  date("Y-m-d", strtotime($fechaLimite));

        /**
        * En cual se van a consultar los servicios prestados por el médico.
        */
                

        /**
         * Consultar en el ámbito Consulta externa
        */
                
        if($ambito==1)
        {
                    // $datos = $this->consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorario::consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal,$codigoMedico,$anioInicial,$mesInicial, $nombre); 
                    
        }
                /**
                 * Consultar en el ambito de hospitalizacion.
                 */
        if($ambito==2)
        {
                    // $datos = $this->consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorario::consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal); 
                    // dd($ambito);

        }
                /**
                 *Consultar en el ambito de cirugia
                */
        if($ambito==3)
        {
                    // $datos = $this->consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorario::consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal); 

        }

                /**
                 * Se actualizan los honorarios.
                 */
        ConsultaHonorario::actualizarHonorariosReales($datos);
        $datosReal=0;
        foreach($datos as $key => $dato){
            if (($dato->IDBOLETA !=0 || $dato->IDBOLETA != NULL || $dato->CODSER != NULL)&& $dato->ID_SOPORTE == 0 ) {
              
                $datosReal= $datosReal+1;
            }
        }
        // if(!$soporteTemp)
        // {          
        //         /**
        //          * Se obtienen los honorarios actualizados en el rango de fecha especificada.
        //          */
        //         $honorarios = Honorario::where('COD_MEDICO',$codigoMedico)
        //                                 ->where('AMBITO',$ambito)
        //                                 ->where('ID_SOPORTE',0)
                                       
        //                                 // ->whereNotNull('NU_FACPAC_MVTO')
        //                                 ->whereBetween('HORA_MVTO',[$fechaInicial,$fechaFinal])
        //                                 ->where('HORA_MVTO','>','2021-10-01') 
        //                                 ->orderBy('HORA_MVTO')->get();

                                       
        //         $total = Honorario::where('COD_MEDICO',$codigoMedico)
        //                             ->where('AMBITO',$ambito)
        //                             ->where('EST_ATEN','ATENDIDA')
        //                             // ->whereNotNull('NU_FACPAC_MVTO')
        //                             ->where('ID_SOPORTE',0)
        //                             ->whereBetween('HORA_MVTO',[$fechaInicial,$fechaFinal])
        //                             ->where('HORA_MVTO','>','2021-10-01') 
        //                             ->sum('CXP_MED_MVTO');
                $fechaInicial = $sistema->fechaEvaluada;
                return view('medicos.create', compact('datos','datosReal','fechaInicial','fechaFinal','nombre','ambito','ambitos','idsTemp'));
        // else
        // {
        //     return redirect()->route('medicos.editar-soporte',$soporteTemp);
        // }


    }
   
    /**
     * 
     */
    public function obtenerUsuarioLogin()
    {
        $usuarios =  DB::connection('ESALUD')->select("SELECT MED.COD_MD_MEDS, PER.TP_ID_PERS,
        MED.IDENT_MD_MEDS,PER.IDENTIF_PERS, 
        (PER.PRINOM_PERS+' '+PER.SEGNOM_PERS+' '+PER.SEGAPE_PERS) AS NOMBRE
        FROM T_PERSONAL AS PER, T_MEDICOS AS MED
        WHERE 
        PER.IDENTIF_PERS = MED.IDENT_MD_MEDS 
        AND PER.TP_ID_PERS = MED.TP_IDMD_MEDS 
        AND (PER.PRIAPE_PERS LIKE '%HON%' OR MED.COD_MD_MEDS = '9475' or PRIAPE_PERS = 'ESALUD') 
        AND MED.COD_MD_MEDS != '0475'
        AND PER.IDENTIF_PERS = '75085796'");
        DB::disconnect('ESALUD');

        $usuario = Arr::first($usuarios);

        return $usuario;
    }

    /**
     * 
     */
    public function visualizarSeleccionPago(Request $request)
    {
        /**
         * Se obtienen los honorarios seleccionados en el formulario.
         */
        // $idHonorariosSeleccionados = $request->honorarios;
        $idHonorariosSeleccionados= $request->honorarios;
        
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

            return view('medicos.soporte',compact('honorarios','idHonorariosSeleccionados','nombreMedico','fechaInicio','fechaFinal','ambito','total'));    
        }
        // else
        // {
        //     return redirect()->route('medicos.formulario')
        //     ->with('error','Debe seleccionar honorarios para poder generar un soporte de pago.');
        // }

        
    }

    /***
     * Modificar los datos sleccionados previamente para generar un soporte.
     */
    public function modificarDatosSoporte(Request $request)
    {

        // return response($request);

        $sistema = Sistema::findOrFail(1);

        $ambito = $request->ambito;

        $idsTemp = $request->honorariosGenerar;
        // $medicoConsultar = null;

        $ambitos = Ambito::orderBy('nombre')->get();
        

        $soporteTemp = SoportePago::where('generado_por', Auth::user()->id)
                                    ->whereDate('fechaInicio',$sistema->fechaEvaluada)
                                    ->where('ID_AMBITO',$ambito)
                                    ->first();
        /**
        * Se obtiene el usuario atenticado.
        */
        $usuario = Auth::user();
                
        $datos = "";
                // return response($usuario);
                
        /**
        * Tipo de identificación del médico.
        */
        $tipoDocumento = $usuario->TP_ID_PERS;

        /**
        * Código del médico en la tabla T_MEDICOS de la base de datos ESALUD. 
        */
        $codigoMedico = $usuario->COD_MD_MEDS;

        /**
        * Número de identificación del médico.
        */
        $numeroIdentificacion = $usuario->IDENT_MD_MEDS;

        /**
        * Nombre completo del médico.
        */
        $nombre = $usuario->NOMBRE;


        $sistema = Sistema::findOrFail(1);


        $fechaLimite = $sistema->fechaLimite()->format('Y-m-d');
        $fechaInicial =  date("Y-m-d", strtotime($sistema->mesAnterior()));
        $anioInicial =  date("Y", strtotime($sistema->mesAnterior()));
        $mesInicial =  date("m", strtotime($sistema->mesAnterior()));
                
        /**
        * Fecha inicial de la cual se va a consultar los servicios realizados.
        */
        $fechaInicial = date("Y-m-d", strtotime($sistema->mesAnterior()));


        /**
        * Fecha final en el intervalo de consulta de los servicios realizados por un médico.
        */
        $fechaFinal  =  date("Y-m-d", strtotime($fechaLimite));

        /**
        * En cual se van a consultar los servicios prestados por el médico.
        */
                

        /**
         * Consultar en el ámbito Consulta externa
        */
                
        if($ambito==1)
        {
                    // $datos = $this->consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
                    $datos = ConsultaHonorario::consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal,$codigoMedico,$anioInicial,$mesInicial, $nombre); 
                    
        }
                /**
                 * Consultar en el ambito de hospitalizacion.
                 */
        if($ambito==2)
        {
                    // $datos = $this->consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorario::consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal); 
                    // dd($ambito);

        }
                /**
                 *Consultar en el ambito de cirugia
                */
        if($ambito==3)
        {
                    // $datos = $this->consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorario::consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal); 

        }

                /**
                 * Se actualizan los honorarios.
                 */
        // ConsultaHonorario::actualizarHonorariosReales($datos);
        
        if(!$soporteTemp)
        {          
                /**
                 * Se obtienen los honorarios actualizados en el rango de fecha especificada.
                 */
                $honorarios = Honorario::where('COD_MEDICO',$codigoMedico)
                                        ->where('AMBITO',$ambito)
                                        ->where('ID_SOPORTE',0)
                                        ->whereBetween('HORA_MVTO',[$fechaInicial,$fechaFinal])
                                        ->get();

                $total = Honorario::where('COD_MEDICO',$codigoMedico)
                                    ->where('AMBITO',$ambito)
                                    ->where('ID_SOPORTE',0)
                                    ->whereBetween('HORA_MVTO',[$fechaInicial,$fechaFinal])
                                    ->sum('CXP_MED_MVTO');

                $fechaInicial = $sistema->fechaEvaluada;
                
                return view('medicos.create', compact('honorarios','fechaInicial','fechaFinal',
                                                'nombre','total','ambito','ambitos','idsTemp'));
        }
        else
        {
            return redirect()->route('medicos.editar-soporte',$soporteTemp);
        }
    }


    /**
     * Generar soporte de pago para los servicios realizados por el médico.
     */
    public function generarSoporte(Request $request)
    {
        $idHonorariosSeleccionados = $request->honorariosGenerar;
       
        $honorarios = Honorario::whereIn('ID',$idHonorariosSeleccionados)->get();

        $total = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CXP_MED_MVTO');

        $cantidadTotal = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CT_SER_MVTO');
        /**
        * Nombre completo del médico que realiza el soporte.
        */
        $nombreMedico = $request->nombreMedico;

        $carpeta = 'SOPORTES';

        // return response($request);
        /**
         * Se obtiene el consecutivo y se crea el radicado.
         */
        $consecutivo = Consecutivo::findOrFail(2);
        $radicado = $consecutivo->prefijo.'-'.$consecutivo->num_conse;

        // dd($pdf);
        /**
         * Ruta donde se guardará el archivo en el servidor.
         */
        $ubicacionPDF = $carpeta.'/'.$radicado.'.pdf';

        /**
         * Fecha de inicio en el rango
         */
        $fechaInicio = $request->fechaInicio;

        /**
         * 
         */
        $fechaFinal = $request->fechaFinal;

        $ambito = $request->ambito;

        $soporte = $this->crearSoporte($fechaInicio,$fechaFinal,$radicado,$cantidadTotal,$ubicacionPDF,$total,$ambito);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('medicos.pdf',compact('soporte','honorarios','total','nombreMedico','cantidadTotal','radicado'));
        
        Storage::disk('local')->put($ubicacionPDF,$pdf->output());
        $this->actualizarEstadoHonorarios($honorarios, $soporte);
 

        /**
        * Se actualiza el consecutivo.
        */
        $consecutivo->num_conse = $consecutivo->num_conse + 1;
        $consecutivo->update();

        /**
         * Opción 1 para generar y descargar el soporte.
         * Opción 2 para generar y enviar el soporte por correo.
         */
        if($request->opcion==1)
        {

            $logActividad = new LogActividad();
            $logActividad->actividad = 'Se generó el soporte de pago '.$soporte->radicado;
            $logActividad->usuario_id = Auth::user()->id;
            $logActividad->save();

            return $pdf->download($radicado.'.pdf');

                    
        }
        else
        {
            /**
            * Descomentar esta y linea para enviar la boleta al médico y comentar 
            * la línea de la declaración de $correo del 'aux.nomina@hiu.org.co'
            */
            $correo = $soporte->autor->medicoHonorario()->CORREO;

            $logActividad = new LogActividad();
            $logActividad->actividad = 'Se generó el soporte de pago '.$soporte->radicado;
            $logActividad->usuario_id = Auth::user()->id;
            $logActividad->save();
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
     * 
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


    /**
     * 
     */
    public function crearSoporte($fechaInicio,$fechaFinal,$radicado,$cantidad,$ubicacionPDF,$total,$ambito)
    {
        $soporte = new SoportePago();
        $soporte->fechaInicio = $fechaInicio;
        $soporte->fechaFinal = $fechaFinal;
        $soporte->radicado = $radicado;
        $soporte->cantidad = $cantidad;
        $soporte->ubicacionPDF = $ubicacionPDF;
        $soporte->total = $total;
        $soporte->ID_AMBITO = $ambito;
        $soporte->generado_por = Auth::user()->id;
        $soporteReturn = $soporte->save();



        return SoportePago::where('radicado',$radicado)->first();
    }

    /**
     * 
     */
    public function listarBoletas()
    {
        $boletas = Auth::user()->boletasMedico();

        
        return view('medicos.boletas',compact('boletas'));
    }

    /**
     * 
     */
    public function listarSoportes()
    {
        $soportes = Auth::user()->soportes;
        
        return view('medicos.index',compact('soportes'));
    }

}
