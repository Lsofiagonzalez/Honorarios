@extends('plantillas.basica')
@extends('componentes.navbar')
@extends('componentes.footer')

@section('TituloPagina', 'Roles')

@section('content')

<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12" >

                @if(Session::has('success_message'))
                <article class="alert alert-success">
                    {{ Session::get('success_message') }}
                </article>
                @endif
                @if(Session::has('error_message'))
                <article class="alert alert-danger">
                    {{ Session::get('error_message') }} <br>
                </article>
                @endif
                <div class="form-panel">
                    <div>
                        <div class="text-left col-md-6">
                            <h3>
                                <span>
                                    <i class="fa fa-angle-right"></i> 
                                    Roles
                                </span>
                            </h3>
                        </div>
                        <div class="text-right col-md-6">
                            <h1 style="font-size: 35px;">
                                <span>
                                    <a href="{{ url()->previous() }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                                </span>
                            </h1>
                        </div>
                    </div>
                    <div class="form-horizontal style-form">
                        <div class="form-group">
                            <h3 style= "margin-left:3%; margin-right:3%" >El usuario que esta editando, tiene acceso a los sistemas de la lista con los roles que 
                                se muestran en la misma. Si desea cambiarlos desplegue la lista y seleccione el nuevo rol. 
                            <br>
                            </h3>                           
                        </div>
                    </div>
                    <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%" method="POST" action="{{ route('usuarios.editaRol') }}">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">                   
                    @foreach(\App\Models\Usuario_GD::where('IDUSUA', '=', $IdGestion)->get() as $UGD)
                    @foreach(\App\Models\controlUsuarios::where('idCargo', '=', $UGD->IDCARG)->get() as $sistemas)
                    <input type="hidden" name="doc" value=" {{ $UGD->CEDUSU }} ">
                        @if($sistemas->accesoGD == 1)
                        <h3 style="color:aqua"><strong>Sistemas Gestion Documental</strong></h3><br>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ROL GESTION DOCUMENTAL </label> 
                            <div class="col-sm-10 @if($errors->has('ROLUSU'))
                                    {{ 'has-error' }}
                                    @endif">
                                @if($errors->has('ROLUSU'))
                                    <span class="control-label">
                                        {{ $errors->first('ROLUSU') }} <br>
                                    </span>
                                @endif                                  
                                <select class="form-control" name="ROLUSU" id="ROLUSU" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                        @foreach(\App\Models\Parametro::orderBy('IDPARA')->where('IDTABL','=','2')->get() as $roles)
                                            <?php $auxiliar=$UGD->ROLUSU ?>                                            
                                            <option value="{{ $roles->IDPARA }}"
                                                {{isset($roles) ? (($roles->IDPARA == $auxiliar) ? 'selected': '') : ''}}>{{ $roles->NOMPAR }}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        </div> 
                        @endif 
                        <h3 style="color:aqua"><strong>BIOTIC</strong></h3><br>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ROL BIOTIC</label>
                            <div class="col-sm-10 @if($errors->has('rol_id'))
                                {{ 'has-error' }}
                                @endif">
                                @if($errors->has('rol_id'))
                                    <span class="control-label">
                                        {{ $errors->first('rol_id') }} <br>
                                    </span>
                                @endif
                                <select class="form-control" name="rol_id" id="rol_id">
                                    <option value=" ">--Selecione un rol de la lista--</option>                                    
                                    @foreach(\App\Models\Rol::where('estado', '=', 1)->get() as $rol)
                                    @foreach(\App\Models\Usuario::where('GD_id', '=', $UGD->IDUSUA)->get() as $UBiotic)
                                        <?php $auxiliar=$UBiotic->rol_id ?>
                                        <option value="{{$rol->id}}"
                                            {{isset($rol) ? (($rol->id == $auxiliar) ? 'selected': '') : ''}}>{{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($sistemas->accesoCirugia == 1)
                        <div class="form-group">
                            <h3 style="color:aqua"><strong>Software de cirugia</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE DE CIRUGIA </label> 
                            <div class="col-sm-10 @if($errors->has('cod_tipousu'))
                                    {{ 'has-error' }}
                                    @endif">                                   
                            <select class="form-control" name="cod_tipousu" id="cod_tipousu" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\ParametroCirugia::orderBy('cod_parametro')->where('cod_tabla','=','25')->get() as $rolC)
                                @foreach(\App\Models\UsuarioCirugia::where('num_ident', '=', $UGD->CEDUSU)->get() as $UCirugia)
                                    <?php $auxiliar=$UCirugia->cod_tipousu ?>
                                    <option value="{{ $rolC->cod_parametro }}"
                                            {{isset($rolC) ? (($rolC->cod_parametro == $auxiliar) ? 'selected': '') : ''}}>{{ $rolC->etiqueta }}
                                    </option>
                                @endforeach
                                @endforeach
                            </select>
                            </div>                       
                        </div>
                        @if($UGD->IDCARG == 38)
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ESPECIALIDAD</label> 
                            <div class="col-sm-10 @if($errors->has('CodigoEsp'))
                                    {{ 'has-error' }}
                                @endif">                                   
                                <select class="form-control" name="CodigoEsp" id="CodigoEsp" aria-controls="dataTable">
                                    <option value=" ">--Selecione una especialidad--</option>
                                    @foreach(\App\Models\especialidadQX::orderBy('CodigoEsp')->get() as $especialidad)
                                    @foreach(\App\Models\MedicoCirugia::where('mdcidentificacion', '=', $UGD->CEDUSU)->get() as $medico)
                                        <?php $auxiliar=$medico->mdcespecialid ?>
                                        <option value="{{ $especialidad->CodigoEsp }}"
                                            {{isset($especialidad) ? (($especialidad->CodigoEsp == $auxiliar) ? 'selected': '') : ''}}>{{ $especialidad->NombreEsp }}
                                        </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>                                               
                        </div>
                        @endif
                        @endif
                        @if($sistemas->accesoReportes == 1)
                            <div class="form-group">
                                <h3 style="color:aqua"><strong>Sistema Reportes Atencion</strong></h3><br>
                                <label class="col-sm-2 col-sm-2 control-label">ROL REPORTES ATENCION </label> 
                                <div class="col-sm-10 @if($errors->has('codigo_rolRA'))
                                        {{ 'has-error' }}
                                        @endif">                                   
                                    <select class="form-control" name="codigo_rolRA" id="codigo_rolRA" aria-controls="dataTable">
                                        <option value=" ">--Selecione un rol--</option>
                                        @foreach(\App\Models\rolesReportes::orderBy('codigo_rol')->get() as $rolR)
                                        @foreach(\App\Models\UsuarioReportes::where('identificacion_usuario', '=', $UGD->CEDUSU)->get() as $UReporte)
                                        <?php $auxiliar=$UReporte->codigo_rol ?>
                                            <option value="{{ $rolR->codigo_rol }}"
                                                {{isset($rolR) ? (($rolR->codigo_rol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolR->nombre_rol }}
                                        </option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>                       
                            </div>
                        @endif
                        @if($sistemas->accesoSIV == 1)
                        <div class="form-group">
                            <h3 style="color:aqua"><strong>Sistemas Voluntariado</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE VOLUNTARIADO </label> 
                            <div class="col-sm-10  @if($errors->has('id_perfil'))
                                    {{ 'has-error' }}
                                    @endif">                                   
                                <select class="form-control" name="id_perfil" id="id_perfil" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\VoluntariadoPerfil::orderBy('idperf')->get() as $rolV)
                                    @foreach(\App\Models\UsuarioVoluntariado::where('docu_usu', '=', $UGD->CEDUSU)->get() as $UVoluntariado)
                                        <?php $auxiliar=$UVoluntariado->id_perfil ?>
                                            <option value="{{ $rolV->idperf }}"
                                                {{isset($rolV) ? (($rolV->idperf == $auxiliar) ? 'selected': '') : ''}}>{{ $rolV->nomperf }}
                                        </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>                       
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">TIPO DE VOLUNTARIO </label> 
                            <div class="col-sm-10 @if($errors->has('tip_vol'))
                                    {{ 'has-error' }}
                                    @endif">                                   
                                <select class="form-control" name="tip_vol" id="tip_vol" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\tipoVoluntario::orderBy('id_tp_vol')->get() as $rolVT)
                                    @foreach(\App\Models\UsuarioVoluntariado::where('docu_usu', '=', $UGD->CEDUSU)->get() as $TipoVol)
                                        <?php $auxiliar=$TipoVol->tip_vol?>
                                        <option value="{{ $rolVT->id_tp_vol }}"
                                            {{isset($rolVT) ? (($rolVT->id_tp_vol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolVT->des_tp_vol }}
                                        </option>
                                    @endforeach
                                    @endforeach
                            </select>
                            </div>                       
                        </div>
                        @endif
                        @if($sistemas->accesoVehiculos == 1)
                        <div class="form-group">
                        <h3 style="color:aqua"><strong>Software Vehiculos</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE DE VEHICULOS </label> 
                            <div class="col-sm-10 @if($errors->has('codigo_rolV'))
                                    {{ 'has-error' }}
                                @endif">                                   
                                <select class="form-control" name="codigo_rolV" id="codigo_rolV" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\RolUsuarioVeh::orderBy('codigo_rol')->get() as $rolVeh)
                                    @foreach(\App\Models\UsuarioVehiculos::where('identificacion_usuario', '=', $UGD->CEDUSU)->get() as $UVehiculo)
                                        <?php $auxiliar=$UVehiculo->codigo_rol ?>
                                        <option value="{{ $rolVeh->codigo_rol }}"
                                            {{isset($rolVeh) ? (($rolVeh->codigo_rol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolVeh->nombre_rol }}
                                        </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif 
                        @if($sistemas->accesoMtoSis == 1)
                        <div class="form-group">
                        <h3 style="color:aqua"><strong>Software Mantenimiento Sistemas</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE MANTENIMIENTO SISTEMAS </label> 
                            <div class="col-sm-10  @if($errors->has('codigo_rolM'))
                                    {{ 'has-error' }}
                                    @endif">                                   
                                <select class="form-control" name="codigo_rolM" id="codigo_rolM" aria-controls="dataTable">
                                <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\RolesUsuarioME::orderBy('codigo_rol')->get() as $rolM)
                                    @foreach(\App\Models\UsuarioME::where('identificacion_usuario', '=', $UGD->CEDUSU)->get() as $UMantenimiento)
                                        <?php $auxiliar=$UMantenimiento->codigo_rol ?>
                                        <option value="{{ $rolM->codigo_rol }}"
                                            {{isset($rolM) ? (($rolM->codigo_rol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolM->nombre_rol }}
                                        </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>                       
                        </div>
                        @endif
                        @if($sistemas->accesoksar == 1)
                        <div class="form-group">
                            <h3 style="color:aqua"><strong>Ksar</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL KSAR</label> 
                            <div class="col-sm-10 @if($errors->has('id_rol'))
                                    {{ 'has-error' }}
                                    @endif">                                   
                                <select class="form-control" name="id_rol" id="id_rol" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\RolUsuarioKsar::orderBy('id_rol')->get() as $rolK)
                                    @foreach(\App\Models\UsuarioKsar::where('numero_documento', '=', $UGD->CEDUSU)->get() as $UKsar)
                                        <?php $auxiliar=$UKsar->id_rol ?>
                                        <option value="{{ $rolK->id_rol }}"
                                            {{isset($rolK) ? (($rolK->id_rol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolK->nombre_rol }}
                                        </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">TIPO MIEMBRO KSAR</label> 
                            <div class="col-sm-10  @if($errors->has('id_tipomiembro'))
                                    {{ 'has-error' }}
                                @endif ">                                   
                                <select class="form-control" name="id_tipomiembro" id="id_tipomiembro" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\TipoMiembroKsar::orderBy('id_tipomiembro')->get() as $tipoM)
                                    @foreach(\App\Models\MiembroKsar::where('numero_documento', '=', $UGD->CEDUSU)->get() as $MKsar)
                                        <?php $auxiliar=$MKsar->id_tipomiembro ?>
                                            <option value="{{ $tipoM->id_tipomiembro }}"
                                                {{isset($tipoM) ? (($tipoM->id_tipomiembro == $auxiliar) ? 'selected': '') : ''}}>{{ $tipoM->nombre_tipomiembro }} 
                                        </option>
                                    @endforeach
                                    @endforeach
                            </select>
                            </div> 
                        </div>
                        @endif
                        @if($sistemas->accesoCenso == 1)
                        <div class="form-group ">
                            <h3 style="color:aqua"><strong>Software Censo Damnificados</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL CENSO DAMNIFICADOS </label> 
                            <div class="col-sm-10 @if($errors->has('codigo_rolCD'))
                                {{ 'has-error' }}
                                @endif">                                   
                                <select class="form-control" name="codigo_rolCD" id="codigo_rolCD" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\RolUsuarioCD::orderBy('codigo_rol')->get() as $rolCD)
                                    @foreach(\App\Models\UsuarioCD::where('numero_documento', '=', $UGD->CEDUSU)->get() as $UCD)
                                        <?php $auxiliar=$UCD->codigo_rol ?>
                                            <option value="{{ $rolCD->codigo_rol }}"
                                                {{isset($rolCD) ? (($rolCD->codigo_rol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolCD->nombre_rol }} 
                                            </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>                       
                        </div>
                        @endif
                        @if($sistemas->accesoAccionS == 1)
                        <div class="form-group">
                        <h3 style="color:aqua"><strong>Software Accion Social</strong></h3><br>
                            <label class="col-sm-2 col-sm-2 control-label">ROL ACCION SOCIAL </label> 
                            <div class="col-sm-10 @if($errors->has('codigo_rolAS'))
                                    {{ 'has-error' }}
                                    @endif">                                   
                                <select class="form-control" name="codigo_rolAS" id="codigo_rolAS" aria-controls="dataTable">
                                    <option value=" ">--Selecione un rol--</option>
                                    @foreach(\App\Models\RolUsuarioAS::orderBy('codigo_rol')->get() as $rolAS)
                                    @foreach(\App\Models\UsuarioAS::where('numero_documento', '=', $UGD->CEDUSU)->get() as $UAS)
                                        <?php $auxiliar=$UAS->codigo_rol ?>
                                            <option value="{{ $rolAS->codigo_rol }}"
                                                {{isset($rolAS) ? (($rolAS->codigo_rol == $auxiliar) ? 'selected': '') : ''}}>{{ $rolAS->nombre_rol }} 
                                        </option>
                                    @endforeach
                                    @endforeach
                            </select>
                            </div>                       
                        </div>
                        @endif                  
                    @endforeach
                    @endforeach
                    <div class="text-center">
                        <button type="submit" class="btn btn-theme04">Editar Roles</button>
                    </div>
                    </form>
                </div><!-- /content-panel --> 
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>
</section>
@stop
