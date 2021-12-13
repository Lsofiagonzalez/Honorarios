{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Usuarios')

@section('scripts')
    <script src="{{ asset('js/buscar.js')}}"></script>
@stop

@section('estilos')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/logs/index.css')}}">
@stop

@section('content')
<section id="main-content">
        <section class="wrapper">
            <div class="row mt">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h4><i class="fa fa-angle-right"></i>Logs</h4>
                        
    <!--*****************************************************************************************************************************
        Tabla para mostrar LOGS los segun sea el caso que el usuario solicito
        *****************************************************************************************************************************-->
        <div class="container">
            <div class="row">
                <div class="col">
                    @if($busqueda==1)
                        <form action="{{ route('logs.mostrar') }}" method="POST" style="margin-bottom:20px;">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="numero" value="1">
                                <div class="col-12 align-self-start">
                                    <div class="form-group">
                                        <label>Seleccione por el campo que desea buscar</label>
                                        <select class="form-control" name='seleccion'>
                                            @foreach(\App\Models\Usuario::orderby('nombre_usuario')->get() as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->nombre_usuario }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 align-self-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif($busqueda==2)
                    <form action="{{ route('logs.mostrar') }}" method="POST" style="margin-bottom:20px;">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="numero" value="2">
                                <div class="col-12 align-self-start">
                                    <div class="form-group">
                                        <label>Seleccione la fecha </label>
                                        <input type="date" class="form-control" name='seleccion' value='<?php echo date("Y-m-d");?>'>
                                    </div>
                                </div>
                                <div class="col-12 align-self-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif($busqueda==3)
                        <form action="{{ route('logs.mostrar') }}" method="POST" style="margin-bottom:20px;">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="numero" value="3">
                                <div class="col-12 align-self-start">
                                    <div class="form-group">nombre_tabla
                                        <label>Seleccione por el campo que desea buscar</label>
                                        <select class="form-control" name='seleccion'>
                                            @foreach(\App\Models\Log::orderby('nombre_tabla')->select('nombre_tabla')->distinct()->get() as $usuario)
                                                <option value="{{ $usuario->nombre_tabla }}">{{ $usuario->nombre_tabla }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 align-self-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif($busqueda==4)
                        <form action="{{ route('logs.mostrar') }}" method="POST" style="margin-bottom:20px;">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="numero" value="4">
                                <div class="col-12 align-self-start">
                                    <div class="form-group">
                                        <label>Seleccione por el campo que desea buscar</label>
                                        <select class="form-control" name='seleccion'>
                                            @foreach(\App\Models\Log::orderby('accion')->select('accion')->distinct()->get() as $usuario)
                                                <option value="{{ $usuario->accion }}">{{ $usuario->accion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 align-self-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>               
        
                    </div><!-- /content-panel -->
                </div><!-- /col-md-12 -->
            </div><!-- /row -->
        </section>
    </section>
    @stop
    