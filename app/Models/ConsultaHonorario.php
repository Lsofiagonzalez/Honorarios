<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class ConsultaHonorario extends Model
{
    use HasFactory;


    /**
     * 
     */
    public static function consultarConsultaExterna($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal,$codigoMedico,$anioInicial,$mesInicial, $nombre)
    {
        /*$datos = DB::connection('ESALUD')->select("SELECT BO.IDBOLETA, BO.ID, BO.ID_SOPORTE, 
                                                CASE 
                                                WHEN MV.CODSER_MVTO IN  (SELECT COD_SER FROM T_SER WHERE NOM_SER LIKE '%JUNTA%') THEN MV.CODSER_MVTO
                                                ELSE BO.CODSER
                                                END AS CODSER, 
                                                CASE 
                                                WHEN MV.CODSER_MVTO IN  (SELECT COD_SER FROM T_SER WHERE NOM_SER LIKE '%JUNTA%') THEN (SELECT TP_ID_PCTE+' '+NUM_ID_PCTE FROM T_PACIENTES I WHERE I.ID_PCTE = A.ID_PCTE_ADM)
                                                ELSE BO.NUM_PACIENTE
                                                END AS NUM_PACIENTE,
                                                CASE 
                                                WHEN MV.CODSER_MVTO IN  (SELECT COD_SER FROM T_SER WHERE NOM_SER LIKE '%JUNTA%') THEN (SELECT PRI_NOM_PCTE+' '+SEG_NOM_PCTE+' '+PRI_APELL_PCTE+' '+SEG_APELL_PCTE FROM T_PACIENTES I WHERE I.ID_PCTE = A.ID_PCTE_ADM)
                                                ELSE BO.NOM_PACIENTE
                                                END AS NOM_PACIENTE,
                                                CASE (BO.VL_TOT_MVTO - MV.VL_TOT_MVTO)
                                                WHEN 0 THEN BO.CXP_MED_MVTO
                                                ELSE (IIF(CH.TP_VAL_CONF_HON = 2, CH.VALOR_CONF_HON, ( MV.VL_TOT_MVTO * (CH.VALOR_CONF_HON/100))))
                                                END AS CXP_MED_MVTO, 
                                                CASE 
                                                WHEN MV.CODSER_MVTO IN  (SELECT COD_SER FROM T_SER WHERE NOM_SER LIKE '%JUNTA%') THEN MV.ID_MVTO
                                                ELSE BO.ID_MVTO
                                                END AS ID_MVTO,
                                                CASE 
                                                WHEN MV.CODSER_MVTO IN  (SELECT COD_SER FROM T_SER WHERE NOM_SER LIKE '%JUNTA%') THEN 1
                                                ELSE 0
                                                END AS ESJUNTA, S.NOM_SER, MV.CT_SER_MVTO, MV.HORA_MVTO, MV.NUFA_MVTO,MV.VL_TOT_MVTO, A.TP_ATEN_ADM AS AMBITO
        FROM	T_ADMISIONES A INNER JOIN T_MVTOS MV ON (A.ID_AMSION = MV.ID_ADM_MVTO)	
						INNER JOIN T_CONF_HONORARIOS CH ON ((MV.CODSER_MVTO = CH.ID_SER_CONF_HON AND MV.TP_SER_MVTO = 1) 
															AND MV.CODMED_MVTO = CH.COD_MED_CONF_HON
															AND (A.TP_ATEN_ADM	= CH.AMBITO_CONF_HON OR CH.AMBITO_CONF_HON = 0))
					INNER JOIN T_SER S ON (MV.CODSER_MVTO = S.COD_SER)
					LEFT JOIN (SELECT * 
								FROM OPENQUERY ([CR-TIC-64],'SELECT B.ID AS IDBOLETA, B.fechaInicio, B.COD_MED, DB.ID AS IDDETALLEBOLETA, DB.NUM_PACIENTE,DB.ID, DB.NOM_PACIENTE, DB.CODSER, DB.HORA_MVTO, DB.ID_SOPORTE, 
																DB.NU_FACPAC_MVTO, DB.VL_TOT_MVTO, DB.CXP_MED_MVTO, DB.ID_MVTO  
																FROM HONORARIOS..BOLETA B INNER JOIN HONORARIOS..HONORARIOSREAL DB ON (B.ID = DB.ID_BOLETA)') 
								WHERE month(FECHAINICIO) =  $mesInicial AND COD_MED	=	$codigoMedico) BO ON (MV.ID_MVTO = BO.ID_MVTO)
        WHERE	YEAR(MV.HORA_MVTO) >= $anioInicial
        AND		MONTH(MV.HORA_MVTO) >=$mesInicial
        AND		MV.CODMED_MVTO	=	$codigoMedico
        order by hora_mvto asc");*/
        // array($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal));
            $generado_por = Auth::user()->id;
            $datos = DB::connection('ESALUD')->select("EXEC INTERLABprueba..[CrearBoletaMedico] $codigoMedico, $generado_por, $anioInicial, $mesInicial, '$nombre'");
            DB::disconnect('ESALUD');

            return $datos;
    }

    /**
     * 
     */
    public static function consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal)
    {
        $datos = DB::connection('ESALUD')->select("SELECT AM.ID_AMSION, AM.ID_CONV_ADM, AM.TP_ATEN_ADM AS AMBITO, 
            (PC.TP_ID_PCTE+' '+PC.NUM_ID_PCTE) AS NUM_PACIENTE, 
            (PC.PRI_NOM_PCTE+' '+PC.SEG_NOM_PCTE+' '+PC.PRI_APELL_PCTE+' '+PC.SEG_APELL_PCTE) AS NOM_PACIENTE, 
            SER.COD_SER, SER.NOM_SER, MV.HORA_MVTO AS HORA_ATEN_MVTO, MV.PREF_MVTO, MV.NUFA_MVTO, MV.CT_SER_MVTO, MV.VL_TOT_MVTO, 
            MV.CXP_MED_MVTO, MV.VL_TOT_MVTO - MV.CXP_MED_MVTO AS DIFERENCIA, US.NOM_USR as NOM_MEDICO, MD.COD_MD_MEDS, MV.ID_MVTO
            FROM 
                T_MVTOS AS MV, T_ADMISIONES AS AM, T_USR AS US, 
                T_PACIENTES AS PC, T_SER AS SER, T_MEDICOS AS MD 
            WHERE 
            MV.ID_ADM_MVTO = AM.ID_AMSION AND
            MV.CODMED_MVTO = MD.COD_MD_MEDS AND
            MD.IDENT_MD_MEDS = US.IDENTIF_PERS AND 
            MD.TP_IDMD_MEDS = US.TP_ID_PERS AND 
            AM.ID_PCTE_ADM = PC.ID_PCTE AND 
            MV.CODSER_MVTO = SER.COD_SER AND 
            AM.TP_ATEN_ADM = '2' AND
            US.IDENTIF_PERS = ? AND 
            US.TP_ID_PERS = ?   AND
            MV.HORA_MVTO BETWEEN ?  AND ? ",array($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal));
            DB::disconnect('ESALUD');

            return $datos;

    }

    /**
     * 
     */
    public static function consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial,$fechaFinal)
    {
        $datos = DB::connection('ESALUD')->select("SELECT '3' AS AMBITO, MV.ID_ADM_MVTO AS ID_AMSION, AM.ID_CONV_ADM,
                MV.PREF_MVTO, MV.NUFA_MVTO,MV.VL_TOT_MVTO, AM.TP_ATEN_ADM, (PC.TP_ID_PCTE+' '+PC.NUM_ID_PCTE) AS NUM_PACIENTE, 
                (PC.PRI_NOM_PCTE+' '+PC.SEG_NOM_PCTE+' '+PC.PRI_APELL_PCTE+' '+PC.SEG_APELL_PCTE) AS NOM_PACIENTE, 
                MV.CODSER_MVTO AS COD_SER, SE.NOM_SER, MV.VL_TOT_MVTO - MV.CXP_MED_MVTO AS DIFERENCIA, MV.ID_MVTO,MV.HORA_MVTO AS HORA_ATEN_MVTO, MV.CT_SER_MVTO,
        CASE CS.TP_CTOLIQ
            WHEN 1 THEN (SELECT US.NOM_USR FROM T_HONORARIOS I, T_MEDICOS MD, T_USR US WHERE 
                        I.ID_MVTO_HON = MVQX.ID_MVTO AND
                        I.COD_CX_HON = MD.COD_MD_MEDS AND
                        MD.TP_IDMD_MEDS = US.TP_ID_PERS AND
                        MD.IDENT_MD_MEDS = US.IDENTIF_PERS)
            WHEN 3 THEN (SELECT US.NOM_USR FROM T_HONORARIOS I, T_MEDICOS MD, T_USR US WHERE 
                        I.ID_MVTO_HON = MVQX.ID_MVTO AND
                        I.COD_AY_HON = MD.COD_MD_MEDS AND
                        MD.TP_IDMD_MEDS = US.TP_ID_PERS AND
                        MD.IDENT_MD_MEDS = US.IDENTIF_PERS)
        END AS NOM_MEDICO, 
        CASE CS.TP_CTOLIQ
            WHEN 1 THEN (SELECT I.COD_CX_HON FROM T_HONORARIOS I WHERE I.ID_MVTO_HON = MVQX.ID_MVTO )
            WHEN 3 THEN (SELECT I.COD_AY_HON FROM T_HONORARIOS I WHERE I.ID_MVTO_HON = MVQX.ID_MVTO )
        END AS COD_MD_MEDS, CS.TP_CTOLIQ, MVQX.VALOR AS CXP_MED_MVTO
        FROM	
            T_MVTOS MV	
            INNER JOIN T_MVTO_QX MVQX ON MV.ID_MVTO = MVQX.ID_MVTO
            INNER JOIN T_CTOLIQ_SOAT CS ON MVQX.ID_CTOLIQ = CS.ID_CTOLIQ_SOAT,
            T_ADMISIONES AS AM, T_PACIENTES AS PC, T_SER AS SE
        WHERE	
            MV.ID_ADM_MVTO = AM.ID_AMSION AND
            AM.ID_PCTE_ADM = PC.ID_PCTE AND
            MV.CODSER_MVTO = SE.COD_SER AND
            MV.TP_SER_MVTO	= 1 AND 
            MV.COD_CTO_SER_MVTO	= '04' AND	
            ((SELECT US.IDENTIF_PERS FROM T_HONORARIOS I, T_MEDICOS MD, T_USR US WHERE 
                I.ID_MVTO_HON = MVQX.ID_MVTO AND
                I.COD_CX_HON = MD.COD_MD_MEDS AND
                MD.TP_IDMD_MEDS = US.TP_ID_PERS AND
                MD.IDENT_MD_MEDS = US.IDENTIF_PERS) = ? ) AND
            ((SELECT I.COD_CX_HON FROM T_HONORARIOS I WHERE I.ID_MVTO_HON = MVQX.ID_MVTO ) IS NOT NULL or 
            (SELECT I.COD_AY_HON FROM T_HONORARIOS I WHERE I.ID_MVTO_HON = MVQX.ID_MVTO ) IS NOT NULL) AND
            MV.HORA_MVTO    BETWEEN ?  AND ? AND
            MV.NUFA_MVTO	IS NOT NULL AND	
            CS.TP_CTOLIQ	IN	(1, 3)",array($numeroIdentificacion,$fechaInicial,$fechaFinal));
        DB::disconnect('ESALUD');

        return $datos;
    }


    /**
     * Obtener todos los médicos que trabajan por honorarios en el HIU.
     * @return lista de los médicos que trabajan por honorarios.
     */
    public static function medicosHonorarios()
    {
        $usuarios =  DB::connection('ESALUD')->select("SELECT	MED.COD_MD_MEDS, PER.TP_ID_PERS, MED.IDENT_MD_MEDS,PER.IDENTIF_PERS, U.ID_USR, PER.MAIL_PERS AS CORREO, PER.TEL_PERS AS TELEFONO, 
                PER.CEL_PERS AS CELULAR, (PER.PRINOM_PERS+' '+PER.SEGNOM_PERS+' '+PER.SEGAPE_PERS) AS NOMBRE
        FROM	T_PERSONAL AS PER INNER JOIN T_MEDICOS AS MED ON (PER.TP_ID_PERS = MED.TP_IDMD_MEDS AND PER.IDENTIF_PERS = MED.IDENT_MD_MEDS)
                INNER JOIN T_USR AS U ON (MED.TP_IDMD_MEDS = U.TP_ID_PERS AND MED.IDENT_MD_MEDS = U.IDENTIF_PERS)
        WHERE	PER.PRIAPE_PERS LIKE '%HON%'
        AND		U.EST_USR = 1
        AND		MED.EST_USR = 1
        AND		PER.ACTIVO_PERS = 1
        AND		PER.PRINOM_PERS NOT LIKE '%JUNTA%'
        ORDER BY NOMBRE");
        DB::disconnect('ESALUD');

        return $usuarios;
    }


    /**
     * Obtener la información de un médico que trabaja por honorarios.
     * @param $nombre_usuario  el nombre de usuario del médico que se quiere consultar.
     * @return el médico identificado con el nombre de usuario indicado.
     */
    public static function medicoHonorario($nombre_usuario)
    {
        $usuarios =  DB::connection('ESALUD')->select("SELECT	MED.COD_MD_MEDS, PER.TP_ID_PERS, MED.IDENT_MD_MEDS,PER.IDENTIF_PERS, U.ID_USR, PER.MAIL_PERS AS CORREO, PER.TEL_PERS AS TELEFONO, 
		PER.CEL_PERS AS CELULAR, (PER.PRINOM_PERS+' '+PER.SEGNOM_PERS+' '+PER.SEGAPE_PERS) AS NOMBRE
        FROM	T_PERSONAL AS PER INNER JOIN T_MEDICOS AS MED ON (PER.TP_ID_PERS = MED.TP_IDMD_MEDS AND PER.IDENTIF_PERS = MED.IDENT_MD_MEDS)
                INNER JOIN T_USR AS U ON (MED.TP_IDMD_MEDS = U.TP_ID_PERS AND MED.IDENT_MD_MEDS = U.IDENTIF_PERS)
        WHERE	U.ID_USR = ?", array($nombre_usuario));
        DB::disconnect('ESALUD');

        $usuario = Arr::first($usuarios);

        return $usuario;
    }

    /**
     * 
     */
    public static function medicoHonorarioPorCodigo($codigoMedico)
    {
        $usuarios =  DB::connection('ESALUD')->select("SELECT	MED.COD_MD_MEDS, PER.TP_ID_PERS, MED.IDENT_MD_MEDS,PER.IDENTIF_PERS, U.ID_USR, PER.MAIL_PERS AS CORREO, PER.TEL_PERS AS TELEFONO, 
		PER.CEL_PERS AS CELULAR, (PER.PRINOM_PERS+' '+PER.SEGNOM_PERS+' '+PER.SEGAPE_PERS) AS NOMBRE
        FROM	T_PERSONAL AS PER INNER JOIN T_MEDICOS AS MED ON (PER.TP_ID_PERS = MED.TP_IDMD_MEDS AND PER.IDENTIF_PERS = MED.IDENT_MD_MEDS)
                INNER JOIN T_USR AS U ON (MED.TP_IDMD_MEDS = U.TP_ID_PERS AND MED.IDENT_MD_MEDS = U.IDENTIF_PERS)
        WHERE	PER.PRIAPE_PERS LIKE '%HON%'
        AND		U.EST_USR = 1
        AND		MED.EST_USR = 1
        AND		PER.ACTIVO_PERS = 1
        AND		PER.PRINOM_PERS NOT LIKE '%JUNTA%'
		AND MED.COD_MD_MEDS  = ? ", array($codigoMedico));
        DB::disconnect('ESALUD');

        $usuario = Arr::first($usuarios);

        return $usuario;
    }
    /**
     * 
     */
    public static function actualizarHonorariosReales($datos)
    {
        // $estadoAtencion;
        $usuario = Auth::user()->medicoHonorario();
        $nombre = $usuario->NOMBRE;
        
        foreach ($datos as $key => $dato) 
        {
            $honorariosTemp = Honorario::where('NUM_PACIENTE',$dato->NUM_PACIENTE)
                                        ->where('CODSER',$dato->CODSER)
                                        ->where('HORA_MVTO',$dato->HORA_MVTO)
                                        ->where('ID_MVTO',$dato->ID_MVTO)
                                        ->first();
            if($honorariosTemp){
                $honorariosTemp->NUM_PACIENTE = $dato->NUM_PACIENTE;
                $honorariosTemp->NOM_PACIENTE = $dato->NOM_PACIENTE;
                $honorariosTemp->CODSER = $dato->CODSER;
                $honorariosTemp->SERVICIO = $dato->NOM_SER;
                $honorariosTemp->HORA_MVTO = $dato->HORA_MVTO;
                $honorariosTemp->ID_BOLETA = $dato->IDBOLETA;
                // $honorariosTemp->DOCCANTABLE = $dato->NUFA_MVTO;
                // $honorariosTemp->NU_FACPAC_MVTO = $dato->NUFA_MVTO;
                // $honorariosTemp->CT_SER_MVTO = $dato->CT_SER_MVTO;
                // $honorariosTemp->VL_TOT_MVTO = floatval($dato->VL_TOT_MVTO);
                $honorariosTemp->CXP_MED_MVTO = floatval($dato->CXP_MED_MVTO);
                // $honorariosTemp->DIFERENCIA = floatval($dato->DIFERENCIA);
                // $honorariosTemp->ESTADO = $dato->
                // $honorariosTemp->MEDICO = $dato->NOM_MEDICO;
                // $honorariosTemp->COD_MEDICO= $dato->COD_MD_MEDS;
                // $honorariosTemp->RADICADO = $dato->
                // $honorariosTemp->NUM_ORDEN = $dato->
                // $honorariosTemp->AMBITO = $dato->AMBITO;
                // $honorariosTemp->EST_ATEN = $estadoAtencion;
                $honorariosTemp->ID_MVTO = $dato->ID_MVTO;
                $honorariosTemp->update();
         }
        // else
        // {
        // if (($dato->IDBOLETA !=0 || $dato->IDBOLETA != NULL || $dato->CODSER != NULL)&& $dato->ID_SOPORTE == 0 ) {
        //     $honorarioGuardar = new Honorario();
            
        //     $honorarioGuardar->NUM_PACIENTE = $dato->NUM_PACIENTE;
        //     $honorarioGuardar->NOM_PACIENTE = $dato->NOM_PACIENTE;
        //     $honorarioGuardar->CODSER = $dato->CODSER;
        //     $honorarioGuardar->SERVICIO = $dato->NOM_SER;
        //     $honorarioGuardar->HORA_MVTO = $dato->HORA_MVTO;
        //     // $honorariosTemp->DOCCANTABLE = $dato->NUFA_MVTO;
        //     $honorarioGuardar->NU_FACPAC_MVTO = $dato->NUFA_MVTO;
        //     $honorarioGuardar->ID_BOLETA = $dato->IDBOLETA;
        //     $honorarioGuardar->CT_SER_MVTO = $dato->CT_SER_MVTO;
        //     $honorarioGuardar->VL_TOT_MVTO = floatval($dato->VL_TOT_MVTO);
        //     $honorarioGuardar->CXP_MED_MVTO = floatval($dato->CXP_MED_MVTO);
        //     // $honorarioGuardar->DIFERENCIA = floatval($dato->DIFERENCIA);
        //     $honorarioGuardar->MEDICO = $usuario->NOMBRE;
        //     $honorarioGuardar->ESTADO = 'PENDIENTE';
        //     // $honorarioGuardar->COD_MEDICO= $dato->COD_MD_MEDS;
        //     // $honorariosTemp->RADICADO = $dato->
        //     // $honorariosTemp->NUM_ORDEN = $dato->
        //     $honorarioGuardar->AMBITO = $dato->AMBITO;
        //     $honorarioGuardar->ID_MVTO = $dato->ID_MVTO;
        //     $honorarioGuardar->save();
        // }
        // }
        }

    }

}
