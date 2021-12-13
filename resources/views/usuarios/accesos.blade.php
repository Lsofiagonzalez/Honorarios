@extends('plantillas.basica')
@extends('componentes.navbar')
@extends('componentes.footer')

@section('TituloPagina', 'Accesos')

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
                                    Sistemas Complementarios
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
                            <h3 style= "margin-left:3%; margin-right:3%" ><br>Todo usuario asociado al cargo {{ $accesos['nomCargo'] }} debera tener acceso a los siguientes sistemas: 
                            <br><br>
                            @if($accesos['accesoGD'] == 1)* Gestion Documental <br> @endif
                            @if($accesos['accesoCirugia'] == 1)* Software de cirugia <br> @endif 
                            @if($accesos['accesoReportes'] == 1)* Reportes atención<br>  @endif 
                            @if($accesos['accesoSIV'] == 1)* Sistema de Voluntariado <br> @endif 
                            @if($accesos['accesoVehiculos'] == 1)* Software de vehiculos <br> @endif 
                            @if($accesos['accesoMtoSis'] == 1)* Mantenimiento sistemas <br> @endif 
                            @if($accesos['accesoksar'] == 1)* Ksar <br> @endif 
                            @if($accesos['accesoCenso'] == 1)* Censo Beneficia <br> @endif 
                            @if($accesos['accesoAccionS'] == 1)* Acción Social <br> @endif <br>
                            </h3>                           
                        </div>
                    </div>
                    <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%"  id="crear" name="crear" method="POST" action="{{ route('usuarios.registrar') }}">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <input type="hidden"  name="NOMUSU" id="NOMUSU" value= "{{ $usuario['NOMUSU']}}">
                    <input type="hidden"  name="APEUSU" id="APEUSU" value= "{{ $usuario['APEUSU']}}">
                    <input type="hidden"  name="TIDUSU" id="TIDUSU" value= "{{ $usuario['TIDUSU']}}">
                    <input type="hidden"  name="CEDUSU" id="CEDUSU" value= "{{ $usuario['CEDUSU']}}">
                    <input type="hidden"  name="genero" id="genero" value= "{{ $usuario['genero']}}">
                    <input type="hidden"  name="rh" id="rh" value= "{{ $usuario['rh']}}">
                    <input type="hidden"  name="idioma" id="idioma" value= "{{ $usuario['idioma']}}">
                    <input type="hidden"  name="seccional" id="seccional" value= "{{ $usuario['seccional']}}">
                    <input type="hidden"  name="num_carnet" id="num_carnet" value= "{{ $usuario['num_carnet']}}">
                    <input type="hidden"  name="ciudad" id="ciudad" value= "{{ $usuario['ciudad']}}">
                    <input type="hidden"  name="barrio" id="barrio" value= "{{ $usuario['barrio']}}">
                    <input type="hidden"  name="direccion" id="direccion" value= "{{ $usuario['direccion']}}">
                    <input type="hidden"  name="celular" id="celular" value= "{{ $usuario['celular']}}">
                    <input type="hidden"  name="CORUSU" id="CORUSU" value= "{{ $usuario['CORUSU']}}">
                    <input type="hidden"  name="fechaNacimiento" id="fechaNacimiento" value= "{{ $usuario['fechaNacimiento']}}">
                    <input type="hidden"  name="IDCARG" id="IDCARG" value= "{{ $usuario['IDCARG']}}">
                    <input type="hidden"  name="LOGUSU" id="LOGUSU" value= "{{ $usuario['LOGUSU']}}">
                    <input type="hidden"  name="PASUSU" id="PASUSU" value= "{{ $usuario['PASUSU']}}">
                    <input type="hidden"  name="DIAVIG" id="DIAVIG" value= "{{ $usuario['DIAVIG']}}">
                    <input type="hidden"  name="DAIAVI" id="DAIAVI" value= "{{ $usuario['DAIAVI']}}">
                    <input type="hidden"  name="rol_id" id="rol_id" value= "{{ $usuario['rol_id']}}">
                    <input type="hidden"  name="bandera" id="bandera" value="0">

                    @if(\App\Models\Usuario_GD::where('CEDUSU','=',$usuario['CEDUSU'])->first())
                    <div class="form-group"  style="background-color:aqua">
                        <br>
                    <h3 style="color:black; background-color:aqua; margin-top:5px"><center>La persona ingresada ya tiene un usuario y rol asignados
                        en Gestion Documental, diligencie los datos que se le solicitan a continuación:</center></h3><br>
                    </div>
                    @else
                    @if($accesos['accesoGD'] == 1)
                    <div class="form-group 
                    @if($errors->has('ROLUSU'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Sistemas Gestion Documental</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL GESTION DOCUMENTAL </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="ROLUSU" id="ROLUSU" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\Parametro::orderBy('IDPARA')->where('IDTABL','=','2')->get() as $roles)
                                    <?php $auxiliar=$roles->IDPARA ?>
                                        <option value="{{ $roles->IDPARA }}"
                                            {{old('ROLUSU') == $auxiliar ? 'selected': ''}}
                                            >{{ $roles->NOMPAR }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif 
                    @endif
                    @if(\App\Models\UsuarioCirugia::where('num_ident','=',$usuario['CEDUSU'])->first())
                    <div class="form-group"  style="background-color:aqua">
                        <br>
                    <h3 style="color:black; background-color:aqua; margin-top:5px"><center>La persona ingresada ya tiene un usuario y rol asignados
                        en el software de cirugia.</center></h3><br>
                    </div>
                    @else
                    @if($accesos['accesoCirugia'] == 1)
                    <div class="form-group 
                    @if($errors->has('cod_tipousu'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software de cirugia</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE DE CIRUGIA </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="cod_tipousu" id="cod_tipousu" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\ParametroCirugia::orderBy('cod_parametro')->where('cod_tabla','=','25')->get() as $rolC)
                                    <?php $auxiliar=$rolC->cod_parametro ?>
                                        <option value="{{ $rolC->cod_parametro }}"
                                            {{old('cod_tipousu') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolC->etiqueta }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @if($accesos['idCargo'] == 38)
                    <div class="form-group 
                    @if($errors->has('CodigoEsp'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">ESPECIALIDAD</label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="CodigoEsp" id="CodigoEsp" aria-controls="dataTable">
                            <option value=" ">--Selecione una especialidad--</option>
                                @foreach(\App\Models\especialidadQX::orderBy('CodigoEsp')->get() as $especialidad)
                                    <?php $auxiliar=$especialidad->CodigoEsp ?>
                                        <option value="{{ $especialidad->CodigoEsp }}"
                                            {{old('CodigoEsp') == $auxiliar ? 'selected': ''}}
                                            >{{ $especialidad->NombreEsp}}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @endif 
                    @endif                   
                    
                    @if($accesos['accesoReportes'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolRA'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Sistema Reportes Atencion</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL REPORTES ATENCION </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolRA" id="codigo_rolRA" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\rolesReportes::orderBy('codigo_rol')->get() as $rolR)
                                    <?php $auxiliar=$rolR->codigo_rol ?>
                                        <option value="{{ $rolR->codigo_rol }}"
                                            {{old('codigo_rolRA') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolR->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoSIV'] == 1)
                    <div class="form-group 
                    @if($errors->has('id_perfil'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Sistemas Voluntariado</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE VOLUNTARIADO </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="id_perfil" id="id_perfil" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\VoluntariadoPerfil::orderBy('idperf')->get() as $rolV)
                                    <?php $auxiliar=$rolV->idperf ?>
                                        <option value="{{ $rolV->idperf }}"
                                            {{old('id_perfil') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolV->nomperf }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    <div class="form-group 
                    @if($errors->has('tip_vol'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">TIPO DE VOLUNTARIO </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="tip_vol" id="tip_vol" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\tipoVoluntario::orderBy('id_tp_vol')->get() as $rolVT)
                                    <?php $auxiliar=$rolVT->id_tp_vol ?>
                                        <option value="{{ $rolVT->id_tp_vol }}"
                                            {{old('tip_vol') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolVT->des_tp_vol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    <!-- /aca me falta poner la verificacion de rh y el barrio --> 
                    @endif
                    @if($accesos['accesoVehiculos'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolV'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Vehiculos</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE DE VEHICULOS </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolV" id="codigo_rolV" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioVeh::orderBy('codigo_rol')->get() as $rolVeh)
                                    <?php $auxiliar=$rolVeh->codigo_rol ?>
                                        <option value="{{ $rolVeh->codigo_rol }}"
                                            {{old('codigo_rolV') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolVeh->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoMtoSis'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolM'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Mantenimiento Sistemas</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE MANTENIMIENTO SISTEMAS </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolM" id="codigo_rolM" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolesUsuarioME::orderBy('codigo_rol')->get() as $rolM)
                                    <?php $auxiliar=$rolM->codigo_rol ?>
                                        <option value="{{ $rolM->codigo_rol }}"
                                            {{old('codigo_rolM') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolM->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoksar'] == 1)
                    <div class="form-group 
                    @if($errors->has('id_rol'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Ksar</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL KSAR</label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="id_rol" id="id_rol" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioKsar::orderBy('id_rol')->get() as $rolK)
                                    <?php $auxiliar=$rolK->id_rol ?>
                                        <option value="{{ $rolK->id_rol }}"
                                            {{old('id_rol') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolK->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    <div class="form-group 
                    @if($errors->has('id_tipomiembro'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">TIPO MIEMBRO KSAR</label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="id_tipomiembro" id="id_tipomiembro" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\TipoMiembroKsar::orderBy('id_tipomiembro')->get() as $tipoM)
                                    <?php $auxiliar=$tipoM->id_tipomiembro ?>
                                        <option value="{{ $tipoM->id_tipomiembro }}"
                                            {{old('id_tipomiembro') == $auxiliar ? 'selected': ''}}
                                            >{{ $tipoM->nombre_tipomiembro }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoCenso'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolCD'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Censo Damnificados</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL CENSO DAMNIFICADOS </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolCD" id="codigo_rolCD" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioCD::orderBy('codigo_rol')->get() as $rolCD)
                                    <?php $auxiliar=$rolCD->codigo_rol ?>
                                        <option value="{{ $rolCD->codigo_rol }}"
                                            {{old('codigo_rolCD') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolCD->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoAccionS'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolAS'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Accion Social</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL ACCION SOCIAL </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolAS" id="codigo_rolAS" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioAS::orderBy('codigo_rol')->get() as $rolAS)
                                    <?php $auxiliar=$rolAS->codigo_rol ?>
                                        <option value="{{ $rolAS->codigo_rol }}"
                                            {{old('codigo_rolAS') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolAS->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    <div class="text-center">
                        <button type="submit" class="btn btn-theme04">Crear</button>
                    </div>
                    </form>
                </div><!-- /content-panel --> 
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>
</section>
@stop
