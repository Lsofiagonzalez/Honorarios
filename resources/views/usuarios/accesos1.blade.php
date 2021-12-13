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
                            <h3 style= "margin-left:3%; margin-right:3%" >La persona con el documento de identidad ingresado ya tiene
                                un usuario asignado en gestión documental con el cargo de <strong>{{ $accesos['nomCargo'] }}</strong>, por lo tanto
                                se solicita diligenciar la información de los siguientes campos para la creación del usuario en los 
                                sistemas complementarios, que seran los siguientes: 
                            <br><br>
                            @if($accesos['accesoCirugia'] == 1)* Software de cirugia <br> @endif 
                            @if($accesos['accesoReportes'] == 1)* Reportes atención<br>  @endif 
                            @if($accesos['accesoSIV'] == 1)* Sistema de Voluntariado <br> @endif 
                            @if($accesos['accesoVehiculos'] == 1)* Software de vehiculos <br> @endif 
                            @if($accesos['accesoMtoSis'] == 1)* Mantenimiento sistemas <br> @endif 
                            @if($accesos['accesoksar'] == 1)* Ksar <br> @endif 
                            @if($accesos['accesoCenso'] == 1)* Censo Beneficia <br> @endif 
                            @if($accesos['accesoAccionS'] == 1)* Acción Social <br> @endif
                            * BOITIC<br>
                            </h3>                           
                        </div>
                    </div>
                    <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%"  id="crear" name="crear" method="POST" action="{{ route('usuarios.registrar') }}">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <input type="hidden"  name="cedula" id="cedula" value= "{{ $docum['numero_doc']}}">
                    <input type="hidden"  name="bandera1" id="bandera1" value= "1">
                    <input type="hidden"  name="ROLUSU" id="ROLUSU" value= 0 >                    
                    <h3 style="color:aqua"><strong>BIOTIC</strong></h3><br>                    
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">ROL BIOTIC</label>
                        <div class="col-sm-10 @if($errors->has('rol_id1'))
                                {{ 'has-error' }}
                            @endif">
                            @if($errors->has('rol_id1'))
                            <span class="control-label">
                                {{ $errors->first('rol_id1') }} <br>
                            </span>
                            @endif
                            <select class="form-control" name="rol_id1" id="rol_id1">
                                <option value=" ">--Selecione un rol de la lista--</option>
                                @foreach(\App\Models\Rol::where('estado', '=', 1)->get() as $rol)
                                <?php $auxiliar2=$rol->id ?>
                                    <option value="{{$rol->id}}"
                                        {{old('rol_id1') == $auxiliar2 ? 'selected': ''}}
                                        >{{$rol->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if($accesos['accesoCirugia'] == 1)
                    <div class="form-group 
                    @if($errors->has('cod_tipousu1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software de cirugia</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE DE CIRUGIA </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="cod_tipousu1" id="cod_tipousu1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\ParametroCirugia::orderBy('cod_parametro')->where('cod_tabla','=','25')->get() as $rolC)
                                    <?php $auxiliar=$rolC->cod_parametro ?>
                                        <option value="{{ $rolC->cod_parametro }}"
                                            {{old('cod_tipousu1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolC->etiqueta }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @if($accesos['idCargo'] == 38)
                    <div class="form-group 
                    @if($errors->has('CodigoEsp1'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">ESPECIALIDAD</label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="CodigoEsp1" id="CodigoEsp1" aria-controls="dataTable">
                            <option value=" ">--Selecione una especialidad--</option>
                                @foreach(\App\Models\especialidadQX::orderBy('CodigoEsp')->get() as $especialidad)
                                    <?php $auxiliar=$especialidad->CodigoEsp ?>
                                        <option value="{{ $especialidad->CodigoEsp }}"
                                            {{old('CodigoEsp1') == $auxiliar ? 'selected': ''}}
                                            >{{ $especialidad->NombreEsp}}
                                    </option>
                                @endforeach
                        </select>
                        </div>                                               
                    </div>
                    @endif                    
                    @endif 
                    @if($accesos['accesoReportes'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolRA1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Sistema Reportes Atencion</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL REPORTES ATENCION </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolRA1" id="codigo_rolRA1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\rolesReportes::orderBy('codigo_rol')->get() as $rolR)
                                    <?php $auxiliar=$rolR->codigo_rol ?>
                                        <option value="{{ $rolR->codigo_rol }}"
                                            {{old('codigo_rolRA1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolR->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoSIV'] == 1)
                    <div class="form-group 
                    @if($errors->has('id_perfil1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Sistemas Voluntariado</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE VOLUNTARIADO </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="id_perfil1" id="id_perfil1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\VoluntariadoPerfil::orderBy('idperf')->get() as $rolV)
                                    <?php $auxiliar=$rolV->idperf ?>
                                        <option value="{{ $rolV->idperf }}"
                                            {{old('id_perfil1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolV->nomperf }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    <div class="form-group 
                    @if($errors->has('tip_vol1'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">TIPO DE VOLUNTARIO </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="tip_vol1" id="tip_vol1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\tipoVoluntario::orderBy('id_tp_vol')->get() as $rolVT)
                                    <?php $auxiliar=$rolVT->id_tp_vol ?>
                                        <option value="{{ $rolVT->id_tp_vol }}"
                                            {{old('tip_vol1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolVT->des_tp_vol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">BARRIO:</label>
                            <div class="col-sm-4 @if($errors->has('barrio1'))
                                    {{ 'has-error' }}
                                @endif">
                                @if($errors->has('barrio'))
                                <span class="control-label">
                                    {{ $errors->first('barrio1') }} <br>
                                </span>
                                @endif
                                <input type="text" class="form-control" name="barrio1" id="barrio1" value= "{{ old('barrio1') }}">
                            </div>                       
                                <label class="col-sm-2 col-sm-2 control-label">DIRECCIÓN:</label>
                                <div class="col-sm-4 
                                @if($errors->has('direccion1'))
                                    {{ 'has-error' }}
                                @endif">
                                @if($errors->has('direccion1'))
                                    <span class="control-label">
                                        {{ $errors->first('direccion') }} <br>
                                    </span>
                                @endif
                                <input type="text" class="form-control" name="direccion1" id="direccion1" value= "{{ old('direccion1') }}">
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">TELEFONO:</label>
                            <div class="col-sm-4 @if($errors->has('telefono1'))
                                    {{ 'has-error' }}
                                @endif">
                                @if($errors->has('telefono'))
                                <span class="control-label">
                                    {{ $errors->first('telefono1') }} <br>
                                </span>
                                @endif
                                <input type="number" class="form-control" name="telefono1" id="telefono1" value= "{{ old('telefono1') }}">
                            </div>                       
                            <label class="col-sm-2 col-sm-2 control-label">FECHA DE NACIMIENTO</label>
                            <div class="col-sm-4 @if($errors->has('fechaNacimiento1'))
                                    {{ 'has-error' }} 
                                @endif ">
                                @if($errors->has('fechaNacimiento1'))
                                <span class="control-label">
                                    {{ $errors->first('fechaNacimiento1') }} <br>
                                </span>
                                @endif
                                <input type="date" class="form-control" name="fechaNacimiento1" id="fechaNacimiento1" value="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">RH:</label> 
                            <div class="col-sm-4  
                                @if($errors->has('rh1'))
                                    {{ 'has-error' }}
                                @endif"> 
                                @if($errors->has('rh1'))
                                    <span class="control-label">
                                        {{ $errors->first('rh1') }} <br>
                                    </span> 
                                @endif                                                             
                                <select class="form-control" name="rh1" id="rh1" aria-controls="dataTable"  >
                                    <option value=" ">--Selecione una opcion--</option>
                                    @foreach(\App\Models\Voluntariadorh::orderBy('rh_id')->get() as $rh)
                                        <?php $auxiliar=$rh->rh_id ?>
                                            <option value="{{ $rh->rh_id }}"
                                                {{old('rh1') == $auxiliar ? 'selected': ''}}
                                                >{{ $rh->rh_tipo }}
                                            </option>
                                    @endforeach
                                </select>
                            </div> 
                            <label class="col-sm-2 col-sm-2 control-label">N° CARNET:</label>
                            <div class="col-sm-4 
                                @if($errors->has('num_carnetV'))
                                    {{ 'has-error' }}
                                @endif">
                                @if($errors->has('num_carnetV'))
                                    <span class="control-label">
                                        {{ $errors->first('num_carnetV') }} <br>
                                    </span>
                                @endif
                                <input type="text" class="form-control" name="num_carnetV" id="num_carnetV" value= "{{ old('num_carnetV') }}">
                            </div>
                        </div>
                    @endif
                    @if($accesos['accesoVehiculos'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolV1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Vehiculos</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE DE VEHICULOS </label> 
                        <div class="col-sm-4">                                   
                        <select class="form-control" name="codigo_rolV1" id="codigo_rolV1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioVeh::orderBy('codigo_rol')->get() as $rolVeh)
                                    <?php $auxiliar=$rolVeh->codigo_rol ?>
                                        <option value="{{ $rolVeh->codigo_rol }}"
                                            {{old('codigo_rolV1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolVeh->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>
                        @if($accesos['accesoSIV'] == 0)
                        <label class="col-sm-2 col-sm-2 control-label">N° CARNET:</label>
                        <div class="col-sm-4 
                            @if($errors->has('num_carnet1'))
                                {{ 'has-error' }}
                            @endif">
                            @if($errors->has('num_carnet1'))
                            <span class="control-label">
                                {{ $errors->first('num_carnet1') }} <br>
                            </span>
                            @endif
                            <input type="text" class="form-control" name="num_carnet1" id="num_carnet1" value= "{{ old('num_carnet1') }}">
                        </div>
                        @endif                       
                    </div>
                    @endif
                    @if($accesos['accesoMtoSis'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolM1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Mantenimiento Sistemas</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL SOFTWARE MANTENIMIENTO SISTEMAS </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolM1" id="codigo_rolM1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolesUsuarioME::orderBy('codigo_rol')->get() as $rolM)
                                    <?php $auxiliar=$rolM->codigo_rol ?>
                                        <option value="{{ $rolM->codigo_rol }}"
                                            {{old('codigo_rolM1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolM->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoksar'] == 1)
                    <div class="form-group 
                    @if($errors->has('id_rol1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Ksar</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL KSAR</label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="id_rol1" id="id_rol1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioKsar::orderBy('id_rol')->get() as $rolK)
                                    <?php $auxiliar=$rolK->id_rol ?>
                                        <option value="{{ $rolK->id_rol }}"
                                            {{old('id_rol1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolK->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group 
                    @if($errors->has('id_tipomiembro1'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">TIPO MIEMBRO KSAR</label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="id_tipomiembro1" id="id_tipomiembro1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\TipoMiembroKsar::orderBy('id_tipomiembro')->get() as $tipoM)
                                    <?php $auxiliar=$tipoM->id_tipomiembro ?>
                                        <option value="{{ $tipoM->id_tipomiembro }}"
                                            {{old('id_tipomiembro1') == $auxiliar ? 'selected': ''}}
                                            >{{ $tipoM->nombre_tipomiembro }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @if($accesos['accesoSIV'] == 0)
                        <div class="form-group">                            
                            <label class="col-sm-2 col-sm-2 control-label">RH:</label> 
                            <div class="col-sm-4  
                                @if($errors->has('rh2'))
                                    {{ 'has-error' }}
                                @endif"> 
                                @if($errors->has('rh2'))
                                    <span class="control-label">
                                        {{ $errors->first('rh2') }} <br>
                                    </span> 
                                @endif                                                             
                                <select class="form-control" name="rh2" id="rh2" aria-controls="dataTable"  >
                                    <option value=" ">--Selecione una opcion--</option>
                                    @foreach(\App\Models\voluntariadorh::orderBy('rh_id')->get() as $rh)
                                        <?php $auxiliar=$rh->rh_id ?>
                                            <option value="{{ $rh->rh_id }}"
                                                {{old('rh2') == $auxiliar ? 'selected': ''}}
                                                >{{ $rh->rh_tipo }}
                                            </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if($accesos['accesoVehiculos'] == 0 && $accesos['accesoSIV'] == 0)
                    <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">N° CARNET:</label>
                        <div class="col-sm-4 
                            @if($errors->has('num_carnet2'))
                                {{ 'has-error' }}
                            @endif">
                            @if($errors->has('num_carnet'))
                                <span class="control-label">
                                    {{ $errors->first('num_carnet2') }} <br>
                                </span>
                            @endif
                                <input type="text" class="form-control" name="num_carnet2" id="num_carnet2" value= "{{ old('num_carnet2') }}">
                        </div>
                    </div> 
                    @endif 
                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-2 control-label">CIUDAD:</label> 
                        <div class="col-sm-4  
                            @if($errors->has('ciudad1'))
                                {{ 'has-error' }}
                            @endif"> 
                            @if($errors->has('ciudad1'))
                            <span class="control-label">
                                {{ $errors->first('ciudad1') }} <br>
                            </span> 
                            @endif                                  
                        <select class="form-control" name="ciudad1" id="ciudad1" aria-controls="dataTable"  >
                            <option value=" ">--Selecione una ciudad--</option>
                                @foreach(\App\Models\CiudadKsar::orderBy('nombre_ciudad')->get() as $ciudad)
                                    <?php $auxiliar=$ciudad->id_ciudad ?>
                                        <option value="{{ $ciudad->id_ciudad }}"
                                            {{old('ciudad1') == $auxiliar ? 'selected': ''}}
                                            >{{ $ciudad->nombre_ciudad }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                           
                        <label class="col-sm-2 col-sm-2 control-label">SECCIONAL:</label> 
                        <div class="col-sm-4  
                        @if($errors->has('seccional1'))
                                {{ 'has-error' }}
                            @endif">
                            @if($errors->has('seccional1'))
                            <span class="control-label">
                                {{ $errors->first('seccional1') }} <br>
                            </span> 
                            @endif                                   
                        <select class="form-control" name="seccional1" id="seccional1" aria-controls="dataTable"  >
                            <option value=" ">--Selecione una opcion--</option>
                                @foreach(\App\Models\SeccionalKsar::orderBy('id_seccional')->get() as $seccional)
                                    <?php $auxiliar=$seccional->id_seccional ?>
                                        <option value="{{ $seccional->id_seccional }}"
                                            {{old('seccional1') == $auxiliar ? 'selected': ''}}
                                            >{{ $seccional->nombre_seccional }}
                                    </option>
                                @endforeach
                        </select>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">GENERO:</label> 
                        <div class="col-sm-4  @if($errors->has('genero1'))
                                {{ 'has-error' }}
                            @endif"> 
                            @if($errors->has('genero1'))
                            <span class="control-label">
                                {{ $errors->first('genero1') }} <br>
                            </span> 
                            @endif                                 
                        <select class="form-control" name="genero1" id="genero1" aria-controls="dataTable"  >
                            <option value=" ">--Selecione una opcion--</option>
                                @foreach(\App\Models\TipoGeneroKsar::orderBy('id_tipogenero')->get() as $genero)
                                    <?php $auxiliar=$genero->id_tipogenero ?>
                                        <option value="{{ $genero->id_tipogenero }}"
                                            {{old('genero1') == $auxiliar ? 'selected': ''}}
                                            >{{ $genero->nombre_tipogenero }}
                                    </option>
                                @endforeach
                        </select>
                        </div>
                        <label class="col-sm-2 col-sm-2 control-label">PROFESION</label>
                        <div class="col-sm-4 @if($errors->has('profesion1'))
                                {{ 'has-error' }}
                            @endif">
                            @if($errors->has('profesion'))
                            <span class="control-label">
                                {{ $errors->first('profesion1') }} <br>
                            </span>
                            @endif
                            <input type="text" class="form-control" name="profesion1" value= "{{ old('profesion1') }}">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-2 col-sm-2 control-label">IDIOMA:</label> 
                        <div class="col-sm-4  
                        @if($errors->has('idioma1'))
                                {{ 'has-error' }}
                            @endif">
                            @if($errors->has('idioma'))
                            <span class="control-label">
                                {{ $errors->first('idioma1') }} <br>
                            </span> 
                            @endif                                   
                        <select class="form-control" name="idioma1" id="idioma1" aria-controls="dataTable"  >
                            <option value=" ">--Selecione una opcion--</option>
                                @foreach(\App\Models\TipoIdiomaKsar::orderBy('id_idioma')->get() as $idioma)
                                    <?php $auxiliar=$idioma->id_idioma ?>
                                        <option value="{{ $idioma->id_idioma }}"
                                            {{old('idioma1') == $auxiliar ? 'selected': ''}}
                                            >{{ $idioma->nombre_idioma }}
                                    </option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                    @endif
                    @if($accesos['accesoCenso'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolCD1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Censo Damnificados</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL CENSO DAMNIFICADOS </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolCD1" id="codigo_rolCD1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioCD::orderBy('codigo_rol')->get() as $rolCD)
                                    <?php $auxiliar=$rolCD->codigo_rol ?>
                                        <option value="{{ $rolCD->codigo_rol }}"
                                            {{old('codigo_rolCD1') == $auxiliar ? 'selected': ''}}
                                            >{{ $rolCD->nombre_rol }}
                                    </option>
                                @endforeach
                        </select>
                        </div>                       
                    </div>
                    @endif
                    @if($accesos['accesoAccionS'] == 1)
                    <div class="form-group 
                    @if($errors->has('codigo_rolAS1'))
                        {{ 'has-error' }}
                    @endif">
                    <h3 style="color:aqua"><strong>Software Accion Social</strong></h3><br>
                        <label class="col-sm-2 col-sm-2 control-label">ROL ACCION SOCIAL </label> 
                        <div class="col-sm-10">                                   
                        <select class="form-control" name="codigo_rolAS1" id="codigo_rolAS1" aria-controls="dataTable">
                            <option value=" ">--Selecione un rol--</option>
                                @foreach(\App\Models\RolUsuarioAS::orderBy('codigo_rol')->get() as $rolAS)
                                    <?php $auxiliar=$rolAS->codigo_rol ?>
                                        <option value="{{ $rolAS->codigo_rol }}"
                                            {{old('codigo_rolAS1') == $auxiliar ? 'selected': ''}}
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
