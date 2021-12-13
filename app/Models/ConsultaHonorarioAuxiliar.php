<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class ConsultaHonorarioAuxiliar extends Model
{
    use HasFactory;


    /**
     * 
     */
    public static function consultarConsultaExterna($fechaInicial,$codigoMedico,$numeroIdentificacion,$tipoDocumento)
    {
        $datos = DB::connection('ESALUD')->select("SELECT	AM.TP_ATEN_ADM AS AMBITO,AM.ID_AMSION, AM.ID_CONV_ADM, MV.PREF_MVTO, MV.NUFA_MVTO,AM.TP_ATEN_ADM, 
        (IC.TPID_PCTE+' '+IC.IDEN_PCTE) AS NUPACIENTE,
        (PC.PRI_NOM_PCTE+' '+PC.SEG_NOM_PCTE+' '+PC.PRI_APELL_PCTE+' '+PC.SEG_APELL_PCTE) AS NOPACIENTE, 
        MV.CODSER_MVTO AS COD_SER, MV.ID_MVTO,
        SE.NOM_SER, MV.HORA_MVTO AS HORA_ATEN_MVTO, MV.CT_SER_MVTO,  MV.VL_TOT_MVTO,
		CASE  H.TP_VAL_CONF_HON 
			WHEN 2 THEN H.VALOR_CONF_HON
			WHEN 1 THEN MV.VL_TOT_MVTO * (H.VALOR_CONF_HON/100)
		END AS CXP_MED_MVTO,US.NOM_USR as NOM_MEDICO,  IC.COD_MD_HISTOC AS COD_MD_MEDS,hc.estado AS ESTADO,
        (	case 
            when (select top 1 ID_HISTORIAL from T_HISTO_CITAS I where I.ID_CITA = IC.ID_CITA AND ESTADO = 10) IS NOT NULL THEN 'ATENDIDA'
            when hc.estado = '0' and ic.tipo_cita = '1'  then 'ASIGNADA'
            when hc.estado = '0'  and ic.tipo_cita = '2' then 'ASIGNADA EXTRA'
            when hc.estado = '1' then 'ASISTIDA'
            when hc.estado = '2' then 'EN SALA DE ESPERA'
            when hc.estado = '3' then 'ANULADA'
            when hc.estado = '4' then 'NO ASISTIDA'
            when hc.estado = '5' then 'TRASLADADA'
            when hc.estado = '6' then 'RESERVADA'
            when hc.estado = '7' then 'AUTORIZADA'
            when hc.estado = '8' then 'POR AUTORIZAR'
            when hc.estado = '9' then 'RECHAZADA'
            when hc.estado = '10' then 'ATENDIDA'
            when hc.estado = '11' then 'EN CONSULTORIO'
            when hc.estado = '12' then 'NO ATENDIDA'
            end 
        ) as estado,  HR.NUM_PACIENTE AS NUM_PACIENTEHR , HR.NOM_PACIENTE AS NOM_PACIENTEHR, HR.CODSER AS CODSERHR, HR.COD_MEDICO AS COD_MEDICOHR, HR.ID_MVTO AS ID_MVTOHR, HR.id AS IDHR, HR.fechaInicio AS fechaInicioHR
        FROM        
            T_INFO_CITAS AS IC INNER JOIN T_HISTO_CITAS AS HC ON (IC.ID_HISTORIAL = HC.ID_HISTORIAL)
								INNER JOIN T_MVTOS AS MV ON (IC.ID_CITA = MV.ID_CITA)
								INNER JOIN T_ADMISIONES AS AM ON ( MV.ID_ADM_MVTO = AM.ID_AMSION)
								INNER JOIN T_PACIENTES AS PC  ON (IC.ID_PCTE = PC.ID_PCTE)
								INNER JOIN T_SER AS SE ON (MV.CODSER_MVTO = SE.COD_SER)
								INNER JOIN T_MEDICOS AS MD ON (IC.COD_MD_HISTOC = MD.COD_MD_MEDS) 
								INNER JOIN T_USR AS US ON (MD.IDENT_MD_MEDS = US.IDENTIF_PERS AND MD.TP_IDMD_MEDS = US.TP_ID_PERS)
								INNER JOIN T_CONF_HONORARIOS H ON (MD.COD_MD_MEDS = H.COD_MED_CONF_HON
																AND MV.CODSER_MVTO = H.ID_SER_CONF_HON
																AND (AM.TP_ATEN_ADM = H.AMBITO_CONF_HON OR H.AMBITO_CONF_HON = 0))
								LEFT JOIN (SELECT NUM_PACIENTE, NOM_PACIENTE, CODSER, COD_MEDICO, ID_MVTO, id, fechaInicio from  OPENQUERY ([CR-TIC-64], 'SELECT HR.NUM_PACIENTE, HR.NOM_PACIENTE, HR.CODSER, HR.COD_MEDICO, HR.ID_MVTO, B.id, B.fechaInicio FROM HONORARIOS..HonorariosReal HR INNER JOIN HONORARIOS..Boleta B On (HR.ID_BOLETA = B.ID)') WHERE fechaInicio = '$fechaInicial') AS
								HR ON (MV.ID_MVTO = HR.ID_MVTO)
        WHERE  MD.COD_MD_MEDS = CONVERT(nvarchar(45),'$codigoMedico')
        AND    CONVERT(date,IC.FECHA_INI) = '$fechaInicial'
        AND     AM.TP_ATEN_ADM = 1     
		AND	    HR.ID_MVTO IS NULL");
        //,array($fechaInicial,$codigoMedico,$numeroIdentificacion,$tipoDocumento));
            DB::disconnect('ESALUD');

            return $datos;
    }
    /**
     * 
     */
    public static function consultarHospitalizacion($numeroIdentificacion,$tipoDocumento,$fechaInicial)
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
            MV.HORA_MVTO = ?",array($numeroIdentificacion,$tipoDocumento,$fechaInicial));
            DB::disconnect('ESALUD');

            return $datos;

    }

    /**
     * 
     */
    public static function consultarCirugia($numeroIdentificacion,$tipoDocumento,$fechaInicial)
    {
        $datos = DB::connection('ESALUD')->select("SELECT '3' AS AMBITO, MV.ID_ADM_MVTO AS ID_AMSION, AM.ID_CONV_ADM,
                MV.PREF_MVTO, MV.NUFA_MVTO, AM.TP_ATEN_ADM, (PC.TP_ID_PCTE+' '+PC.NUM_ID_PCTE) AS NUM_PACIENTE, 
                (PC.PRI_NOM_PCTE+' '+PC.SEG_NOM_PCTE+' '+PC.PRI_APELL_PCTE+' '+PC.SEG_APELL_PCTE) AS NOM_PACIENTE, 
                MV.CODSER_MVTO AS COD_SER, SE.NOM_SER, MV.ID_MVTO,MV.HORA_MVTO AS HORA_ATEN_MVTO, MV.CT_SER_MVTO,
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
            MV.HORA_MVTO    = ?  AND
            MV.NUFA_MVTO	IS NOT NULL AND	
            CS.TP_CTOLIQ	IN	(1, 3)",array($numeroIdentificacion,$fechaInicial));
        DB::disconnect('ESALUD');

        return $datos;
    }

    /**
     * 
     */
    public static function actualizarHonorariosReales($datos)
    {
        $estadoAtencion;

        foreach ($datos as $key => $dato) 
        {
            $honorariosTemp = Honorario::where('NUM_PACIENTE',$dato->NUPACIENTE)
                                        ->where('CODSER',$dato->COD_SER)
                                        ->where('HORA_MVTO',$dato->HORA_ATEN_MVTO)
                                        ->where('ID_MVTO',$dato->ID_MVTO)
                                        ->first();

            switch ($dato->AMBITO) {
                case '1':
                    $estadoAtencion = $dato->estado;
                break;
                case '2':
                    $estadoAtencion = 'HOSPITALIZADO';
                break;
                case '3':
                    $estadoAtencion = 'CIRUGIA';
                break;
            }
            if ($honorariosTemp) 
            {
                $honorariosTemp->NUM_PACIENTE = $dato->NUPACIENTE;
                $honorariosTemp->NOM_PACIENTE = $dato->NOPACIENTE;
                $honorariosTemp->CODSER = $dato->COD_SER;
                $honorariosTemp->SERVICIO = $dato->NOM_SER;
                $honorariosTemp->HORA_MVTO = $dato->HORA_ATEN_MVTO;
                // $honorariosTemp->DOCCANTABLE = $dato->NUFA_MVTO;
                $honorariosTemp->NU_FACPAC_MVTO = $dato->NUFA_MVTO;
                $honorariosTemp->CT_SER_MVTO = $dato->CT_SER_MVTO;
                $honorariosTemp->VL_TOT_MVTO = floatval($dato->VL_TOT_MVTO);
                $honorariosTemp->CXP_MED_MVTO = floatval($dato->CXP_MED_MVTO);
                // $honorariosTemp->DIFERENCIA = floatval($dato->DIFERENCIA);
                // $honorariosTemp->ESTADO = $dato->
                $honorariosTemp->MEDICO = $dato->NOM_MEDICO;
                $honorariosTemp->COD_MEDICO= $dato->COD_MD_MEDS;
                // $honorariosTemp->RADICADO = $dato->
                // $honorariosTemp->NUM_ORDEN = $dato->
                $honorariosTemp->AMBITO = $dato->AMBITO;
                // $honorariosTemp->EST_ATEN = $estadoAtencion;
                $honorariosTemp->ID_MVTO = $dato->ID_MVTO;
                $honorariosTemp->update();
            }
            else
            {
                $honorarioGuardar = new Honorario();
                $honorarioGuardar->NUM_PACIENTE = $dato->NUPACIENTE;
                $honorarioGuardar->NOM_PACIENTE = $dato->NOPACIENTE;
                $honorarioGuardar->CODSER = $dato->COD_SER;
                $honorarioGuardar->SERVICIO = $dato->NOM_SER;
                $honorarioGuardar->HORA_MVTO = $dato->HORA_ATEN_MVTO;
                // $honorariosTemp->DOCCANTABLE = $dato->NUFA_MVTO;
                $honorarioGuardar->NU_FACPAC_MVTO = $dato->NUFA_MVTO;
                $honorarioGuardar->CT_SER_MVTO = $dato->CT_SER_MVTO;
                $honorarioGuardar->VL_TOT_MVTO = floatval($dato->VL_TOT_MVTO);
                $honorarioGuardar->CXP_MED_MVTO = floatval($dato->CXP_MED_MVTO);
                // $honorarioGuardar->DIFERENCIA = floatval($dato->DIFERENCIA);
                $honorarioGuardar->MEDICO = $dato->NOM_MEDICO;
                $honorarioGuardar->ESTADO = 'NO PAGO';
                $honorarioGuardar->COD_MEDICO= $dato->COD_MD_MEDS;
                // $honorariosTemp->RADICADO = $dato->
                // $honorariosTemp->NUM_ORDEN = $dato->
                $honorarioGuardar->AMBITO = $dato->AMBITO;
                $honorarioGuardar->EST_ATEN = $estadoAtencion;
                $honorarioGuardar->ID_MVTO = $dato->ID_MVTO;
                $honorarioGuardar->save();
            }
        }

    }
}
