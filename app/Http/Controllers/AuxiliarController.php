<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ConsultaHonorario;
use App\Models\ConsultaHonorarioAuxiliar;
use App\Models\DetalleHonorarioCambio;
use App\Models\Honorario;
use App\Models\Boleta;
use App\Models\Consecutivo;
use App\Models\Ambito;
use Illuminate\Support\Facades\Storage;
use App\Mail\NotificacionBoleta;
use Illuminate\Support\Facades\Mail;
use App\Models\LogActividad;

use function PHPUnit\Framework\isNull;

class AuxiliarController extends Controller
{
    public function create()
    {
        $honorarios = null;
        // $fechaFinal = null;
        $fechaInicial = null;
        $nombre = null;
        $ambito = null;
        $medicoConsultar = null;
        $idsTemp = array();
        $medicos = ConsultaHonorario::medicosHonorarios();
        $ambitos = Ambito::where('estado',1)->orderBy('nombre')->get();

        // return response($medicos);

        Alert::success('Success Title', 'Success Message');
        return view('auxiliares.create', compact('honorarios','fechaInicial',
                        'nombre','medicos','ambito','medicoConsultar','idsTemp','ambitos'));
    }

    /**
     * 
     */
    public function consultar(Request $request)
    {
        

        $ambitos = Ambito::where('estado',1)->orderBy('nombre')->get();
        /**
         * 
         */
        $idsTemp = array();

        $medicoConsultar = $request->medicoConsultar;
        /**
         * Se obtiene el médico selecionado en el formulario.
         */
        $usuario = ConsultaHonorario::medicoHonorario($medicoConsultar);
        
        /**
         * Se obtienen todos los medicos que trabajan por honorarios
         */
        $medicos = ConsultaHonorario::medicosHonorarios();

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

        /**
         * Fecha inicial de la cual se va a consultar los servicios realizados.
         */
        $fechaInicial = date("Y-m-d", strtotime($request->fechaInicial));

        /**
         * En cual se van a consultar los servicios prestados por el médico.
         */
        $ambito = $request->ambito;

        /**
         * Consultar en el ámbito Consulta externa
         */
        
        if($ambito==1)
        {
            // $datos = $this->consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorarioAuxiliar::consultarConsultaExterna($fechaInicial,$codigoMedico,$numeroIdentificacion,$tipoDocumento); 
            
        }
        /**
         * Consultar en el ambito de hospitalizacion.
         */
        if($ambito==2)
        {
            // $datos = $this->consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorarioAuxiliar::consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial); 
            // dd($ambito);

        }
        /**
         *Consultar en el ambito de cirugia
         */
        if($ambito==3)
        {
            // $datos = $this->consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorarioAuxiliar::consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial); 

        }

        /**
         * Se actualizan los honorarios.
         */
        ConsultaHonorarioAuxiliar::actualizarHonorariosReales($datos);


        // return response($datos);

        /**
         * Se obtienen los honorarios actualizados en el rango de fecha especificada.
         */
        $honorarios = Honorario::where('COD_MEDICO',$codigoMedico)
                                ->where('AMBITO',$ambito)
                                ->where('ID_BOLETA',0)
                                ->orderBy('HORA_MVTO')
                                ->whereDate('HORA_MVTO',$fechaInicial)
                                ->get();
        $idhonorarios = Honorario::where('COD_MEDICO',$codigoMedico)
                                ->where('AMBITO',$ambito)
                                ->where('ID_BOLETA',0)
                                ->orderBy('HORA_MVTO')
                                ->whereDate('HORA_MVTO',$fechaInicial)->select('ID')
                                ->get();
        $estadoConsulta = 0;
       
            // foreach ($idhonorarios as $key => $honorario)
            // {     

            //     $estadoConsulta = DetalleHonorarioCambio::consultarDetalleHonorario($honorario);
            // }
    //     $valorHora= 3500;
    // if($request -> horas){
    //    $horas = $request -> horas;
    //    $totalHoras= $horas * $valorHora;

    // }{
    //     $horas= 0;
    //     $totalHoras= 0.00;
    // }
        $total = Honorario::where('COD_MEDICO',$codigoMedico)
                            ->where('AMBITO',$ambito)
                            ->where('ID_BOLETA',0)
                            ->whereDate('HORA_MVTO',$fechaInicial)
                            ->sum('CXP_MED_MVTO');

            
                return view('auxiliares.create', compact('honorarios','fechaInicial','total','nombre',
                'medicos','ambito','medicoConsultar','idsTemp','ambitos','estadoConsulta'));
            

    }

    public function modificarBoleta(Request $request)
    {

        $ambitos = Ambito::where('estado',1)->orderBy('nombre')->get();
        // return response($request);
        /**
         * 
         */
        $idsTemp = $request->honorariosVerificar;

        
        $medicoConsultar = $request->medicoConsultar;
         /**
         * Se obtiene el médico selecionado en el formulario.
         */
        $usuario = ConsultaHonorario::medicoHonorario($medicoConsultar);
        
        /**
         * Se obtienen todos los medicos que trabajan por honorarios
         */
        $medicos = ConsultaHonorario::medicosHonorarios();

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

        /**
         * Fecha inicial de la cual se va a consultar los servicios realizados.
         */
        $fechaInicial = date("Y-m-d", strtotime($request->fechaInicial));

        /**
         * En cual se van a consultar los servicios prestados por el médico.
         */
        $ambito = $request->ambito;

        /**
         * Consultar en el ámbito Consulta externa
         */
        
        if($ambito==1)
        {
            // $datos = $this->consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorarioAuxiliar::consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$codigoMedico); 
            
        }
        /**
         * Consultar en el ambito de hospitalizacion.
         */
        if($ambito==2)
        {
            // $datos = $this->consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorarioAuxiliar::consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial); 
            // dd($ambito);

        }
        /**
         *Consultar en el ambito de cirugia
         */
        if($ambito==3)
        {
            // $datos = $this->consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal);
            $datos = ConsultaHonorarioAuxiliar::consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial); 

        }

        /**
         * Se actualizan los honorarios.
         */
        ConsultaHonorarioAuxiliar::actualizarHonorariosReales($datos);


        // return response($datos);

        /**
         * Se obtienen los honorarios actualizados en el rango de fecha especificada.
         */
        $honorarios = Honorario::where('COD_MEDICO',$codigoMedico)
                                ->where('AMBITO',$ambito)
                                ->where('ID_BOLETA',0)
                                ->whereDate('HORA_MVTO',$fechaInicial)
                                ->get();
        
        $total = Honorario::where('COD_MEDICO',$codigoMedico)
                            ->where('AMBITO',$ambito)
                            ->where('ID_BOLETA',0)
                            ->whereDate('HORA_MVTO',$fechaInicial)
                            ->sum('CXP_MED_MVTO');

        return view('auxiliares.create', compact('honorarios','fechaInicial','total',
        'nombre','medicos','ambito','medicoConsultar','idsTemp','ambitos','datos'));
    }

    /**
     * 
     */
    public function visualizarBoleta(Request $request)
    {
        // return response($request);
        /**
         * Se obtienen los honorarios seleccionados en el formulario.
         */
        $idHonorariosSeleccionados = $request->honorarios;

        $ambito = $request->ambito;

        $medicoConsultar = $request->medicoConsultar;

        $fechaInicial = $request->fechaInicial;

        // return response($fechaInicial);

        if($idHonorariosSeleccionados)
        {
            $honorarios = Honorario::whereIn('ID',$idHonorariosSeleccionados)->get();

            $total = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CT_SER_MVTO');
            /**
             * Nombre completo del médico que realiza el soporte.
             */
            $nombreMedico = $request->nombreMedico;

            return view('auxiliares.boleta',compact('honorarios','nombreMedico','total',
                                                'ambito','fechaInicial','medicoConsultar'));    
        }
        else
        {
            return redirect()->route('auxiliares.create')
            ->with('error','Debes seleccionar por lo menos un honorario para generar la boleta.');
        }

        
    }

    /**
     * Generar la boleta de pago para los servicios realizados por el médico.
     */
    public function generarBoleta(Request $request)
    {
        $idHonorariosSeleccionados = $request->honorariosGenerar;
       
        /**
         * Honorarios
         */
        $honorarios = Honorario::whereIn('ID',$idHonorariosSeleccionados)
                                 ->where('ID_BOLETA',0)->get();

        /**
         * Cantidad de servicios seleccionados
         */

        if(count($honorarios)==count($idHonorariosSeleccionados))
        {
                $total = Honorario::whereIn('ID',$idHonorariosSeleccionados)->sum('CT_SER_MVTO');

                /**
                * Nombre completo del médico que realiza el soporte.
                */
                $honorario = Arr::first($honorarios);

                $codigo_medico = $honorario->COD_MEDICO;

                $nombreMedico = $request->nombreMedico;

                $ambito = $request->ambito;
                 
                $fechaInicio = $request->fechaInicio;
                $carpeta = 'BOLETAS';

                /**
                 * Se obtiene el consecutivo y se crea el radicado.
                 */
                $consecutivo = Consecutivo::findOrFail(1);
                $radicado = $consecutivo->prefijo.'-'.$consecutivo->num_conse;

                // dd($pdf);
                /**
                 * Ruta donde se guardará el archivo en el servidor.
                 */
                $ubicacionPDF = $carpeta.'/'.$radicado.'.pdf';

            

                /**
                 * Se crea la boleta
                 */
                $boleta = $this->crearBoleta($request->fechaInicio,$request->fechaFinal,
                                            $radicado,$total,$ubicacionPDF,$codigo_medico,$ambito);


                $pdf = app('dompdf.wrapper');
                $pdf->loadView('auxiliares.pdf',compact('honorarios','total','nombreMedico','boleta'));

                Storage::disk('local')->put($ubicacionPDF,$pdf->output());
                /**
                 * Se actualiza el id de la boleta en los honorarios.
                 */
                $this->actualizarEstadoHonorarios($honorarios, $boleta);

                /**
                * Se actualiza el consecutivo.
                */
                $consecutivo->num_conse = $consecutivo->num_conse + 1;
                $consecutivo->update();
                $eliminarHonorarios = Honorario::where('AMBITO',$ambito)
                                        ->where('ID_BOLETA',0)
                                        ->delete();
               
                /**
                 * Opción 1 para generar y descargar la boleta.
                 * Opción 2 para generar y enviar la boleta.
                 */
                if($request->opcion==1)
                {
                    $logActividad = new LogActividad();
                    $logActividad->actividad = 'Se generó la boleta de pago '.$boleta->radicado;
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
                     $correo = $boleta->receptor()->CORREO;
                    $logActividad = new LogActividad();
                    $logActividad->actividad = 'Se generó la boleta de pago '.$boleta->radicado;
                    $logActividad->usuario_id = Auth::user()->id;
                    $logActividad->save();

                    //$correo = "aux.nomina@hiu.org.co";
                    if($correo)
                    {
                        
                        // return response('Enviando correo');
                        Mail::to($correo)->send(new NotificacionBoleta($pdf->output(),$boleta));
                        return redirect()->route('auxiliares.create')
                        ->with('success','Se generó la boleta '.$boleta->radicado.',y envió por correo éxitosamente.');
                    }
                    else
                    {
                        return redirect()->route('auxiliares.create')
                        ->with('warning','Se generó la boleta '.$boleta->radicado.', pero no se pudo enviar por correo.');
                    }
                    
                }

        }
        else
        {
            return redirect()->route('auxiliares.create')
            ->with('error','No se se generó la boleta, porque alguno de los honorarios seleccionados ya se encuentra contabilizado en una boleta.');
        }

        
       

    }
    /**
     * Actualizar los estados de los honorarios
     * @param $boleta la boleta a la cual se le van a asociar los honorarios.
     * @param $honorarios los honorarios a los cuales se les va asignar una boleta.
     */
    
    public function editarEstado(Honorario $honorario)
    {
        return view('auxiliares.edit',compact('honorario'));
    }


    public function update(Request $request)
    {
        $datos = new DetalleHonorarioCambio();
        $datos -> ID_HON = $request-> idHonorario;
        $datos -> EST_HON = $request -> estado_hon;
        $datos -> EST_CAMBIO = $request -> estado;
        $datos -> MEDICO = $request ->medico_honorario;
        $datos -> USUARIO_MOD = Auth::user()->nombre_usuario;
        $datos -> OBSERVACION = $request -> observ;
        $datos -> save();
        $est_aten = Honorario::where('ID',$datos->ID_HON)->first();
        $est_aten->EST_ATEN = "ATENDIDA";
        $est_aten->save();
        return redirect()->route('auxiliares.create');
       
    }
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
    public function actualizarEstadoHonorarios($honorarios, $boleta)
    {
       foreach ($honorarios as $key => $honorario) 
       {
           $honorario->ID_BOLETA = $boleta->id;
           $honorario->update();
       }
    }


    /**
     * Crear una boleta de pago para un medico
     */
    public function crearBoleta($fechaInicio,$fechaFinal,$radicado,$cantidad,$ubicacionPDF,$codigo_medico,$ambito)
    {
        $boleta = new Boleta();
        $boleta->fechaInicio = $fechaInicio;
        $boleta->fechaFinal = $fechaFinal;
        $boleta->radicado = $radicado;
        $boleta->cantidad = $cantidad;
        $boleta->ubicacionPDF = $ubicacionPDF;
        $boleta->COD_MED = $codigo_medico;
        $boleta->generado_por = Auth::user()->id;
        $boleta->ID_AMBITO = $ambito;
        $boletaReturn = $boleta->save();



        return Boleta::where('radicado',$radicado)->first();
    }

    /**
     * 
     */
    public function listarBoletas()
    {
        $boletas = Auth::user()->boletasAuxiliar;
        return view('auxiliares.index',compact('boletas'));
    }

   


}
