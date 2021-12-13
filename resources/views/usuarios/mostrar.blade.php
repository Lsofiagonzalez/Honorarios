{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Accesos')

@section('content')

<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">

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
                                    {{$usuario->nombre_usuario}}
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
                        <div class="form-group" >
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>ID</strong></label>
                            <div class="col-sm-2">
                                <p class="form-control-static">{{$usuario->id}}</p>
                            </div>                          
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>NOMBRE Y APELLIDO</strong></label>
                            <div class="col-sm-5">
                                @foreach (App\Models\Usuario_GD::where('IDUSUA','=',$usuario->GD_id)->get() as $datosGestion)
                                <p class="form-control-static">{{ $datosGestion->NOMUSU." ".$datosGestion->APEUSU }}</p>
                                @endforeach 
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>CARGO</strong></label>
                            <div class="col-sm-10">
                                @foreach (App\Models\Usuario_GD::where('IDUSUA','=',$usuario->GD_id)->get() as $datosGestion)
                                    @foreach (App\Models\cargo::where('IDCARG','=',$datosGestion->IDCARG)->get() as $cargo)
                                        <p class="form-control-static">{{ $cargo->NOMCAR }}</p>
                                    @endforeach
                                @endforeach 
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>DOCUMENTO DE IDENTIDAD</strong></label>
                            <div class="col-sm-10">
                                @foreach (App\Models\Usuario_GD::where('IDUSUA','=',$usuario->GD_id)->get() as $datosGestion)
                                <p class="form-control-static">{{ $datosGestion->CEDUSU }}</p>
                                @endforeach 
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>DIRECCION</strong></label>
                            <div class="col-sm-10">
                                @foreach (App\Models\Usuario_GD::where('IDUSUA','=',$usuario->GD_id)->get() as $datosGestion)
                                <p class="form-control-static">{{ $datosGestion->direccion }}</p>
                                @endforeach 
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>TELEFONO</strong></label>
                            <div class="col-sm-10">
                                @foreach (App\Models\Usuario_GD::where('IDUSUA','=',$usuario->GD_id)->get() as $datosGestion)
                                <p class="form-control-static">{{ $datosGestion->celular }}</p>
                                @endforeach 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>NOMBRE DE USUARIO</strong></label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$usuario->nombre_usuario}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>ESTADO</strong></label>
                            <div class="col-sm-10">
                                <h4>
                                    <span class="badge {{ ($usuario->estado == 1) ? 'badge-success' : 'badge-danger'}}">
                                            {{ ($usuario->estado == 1) ? 'Activo' : 'Inactivo'}}
                                    </span>
                                </h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>ROL</strong></label>
                            <div class="col-sm-10">
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','1')->get() as $rol1)
                            @if($rol1)
                                <a href="{{route('roles.mostrar', $usuario->rol->id)}}">
                                    <p class="form-control-static">{{$usuario->rol->nombre}}</p>
                                </a>
                            @endif
                            @endforeach
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','0')->get() as $rol2)
                            @if($rol2)
                                <?php echo  $usuario->rol->nombre ?>
                            @endif
                            @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>FECHA DE CREACION</strong></label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$usuario->created_at}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label" style = "text-align: center"><strong>FECHA DE MODIFICACION</strong></label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$usuario->updated_at}}</p>
                            </div>
                        </div>
                    </div>
                </div><!-- /content-panel -->
        

            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>

    
</section>

@stop
