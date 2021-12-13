{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Accesos')

@section('content')

<div class="container">
    <div class="row mt-4">
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
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between col-md-12">
                    <h3>
                        <span>
                            <i class="fa fa-angle-right"></i> 
                            Editar
                        </span>
                    </h3>
                    <h1 style="font-size: 35px;">
                        <span>
                            <a href="{{ route('accesos.index') }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                        </span>
                    </h1>
                </div>
            </div>
            <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%" method="POST" action="{{ isset($acceso) ? route($ruta, $acceso->id) : route($ruta) }}">
                <input type="hidden" name="_token" value="{{ Session::token() }}">

                <div class="form-group 
                @if($errors->has('nombre'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-sm-2 col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-10">
                        @if($errors->has('nombre'))
                        <span class="control-label">
                            {{ $errors->first('nombre') }} <br>
                        </span>
                        @endif
                        <input type="text" class="form-control" name="nombre" value=@isset($acceso) "{{ $acceso->nombre }}" @else "{{ old('nombre') }}" @endisset>
                    </div>
                </div>
                <div class="form-group
                @if($errors->has('descripcion'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                    <div class="col-sm-10">
                        @if($errors->has('descripcion'))
                        <span class="control-label">
                        {{ $errors->first('descripcion') }} <br>
                        </span>
                        @endif
                        <textarea class="form-control" name="descripcion" value="{{ isset($acceso) ? $acceso->descripcion : old('descripcion')}}">{{isset($acceso) ? $acceso->descripcion : old('descripcion')}}</textarea>
                        <span class="help-block">Breve explicación de funcionalidad del módulo.</span>
                    </div>
                </div>
                <div class="form-group
                @if($errors->has('estado'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-lg-2 col-sm-2 control-label">Estado</label>
                    <div class="col-sm-10">
                            <div class="input-group-text">
                                <input type="checkbox" aria-label="Checkbox de activación/inactivación" name="estado" 
                                @if($acceso->estado == 1) {{'checked'}}@endif
                                @if('checked') value="1"
                                @else value="0"
                                @endif> Activo
                            </div>
                    </div> 
                </div>
                <div class="form-group
                @if($errors->has('submodulo_id'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-lg-2 col-sm-2 control-label" for="submodulo_id">Submódulo al que pertenece</label>
                    <div class="col-sm-10">
                        @if($errors->has('submodulo_id'))
                        <span class="control-label">
                            {{ $errors->first('submodulo_id') }} <br>
                        </span>
                        @endif

                        <select class="form-control" name="submodulo_id" id="submodulo_id">
                            @foreach(\App\Models\Submodulo::get() as $submodulo)
                                <option value="{{$submodulo->id}}"
                                    {{isset($acceso) ? (($acceso->submodulo_id == $submodulo->id) ? 'selected': '') : ''}}
                                    {{old('submodulo_id') ? ((old('submodulo_id') == $submodulo->id) ? 'selected': '') : ''}}
                                    >{{$submodulo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group
                @if($errors->has('controlador'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-sm-2 col-sm-2 control-label">Controlador</label>
                    <div class="col-sm-10">
                        @if($errors->has('controlador'))
                        <span class="control-label">
                        {{ $errors->first('controlador') }} <br>
                        </span>
                        @endif
                        <textarea class="form-control" name="controlador" value="{{ isset($acceso) ? $acceso->controlador : old('controlador')}}">{{isset($acceso) ? $acceso->controlador : old('controlador')}}</textarea>
                        <span class="help-block">Nombre del controlador y la acción que atenderá al acceso. <br> Debe existir el controlador y la acción.</span>
                    </div>
                </div>
                <div class="form-group
                @if($errors->has('ruta_nombre'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-sm-2 col-sm-2 control-label">Ruta</label>
                    <div class="col-sm-10">
                        @if($errors->has('ruta_nombre'))
                        <span class="control-label">
                        {{ $errors->first('ruta_nombre') }} <br>
                        </span>
                        @endif
                        <textarea class="form-control" name="ruta_nombre" value="{{ isset($acceso) ? $acceso->ruta_nombre : old('ruta_nombre')}}">{{isset($acceso) ? $acceso->ruta_nombre : old('ruta_nombre')}}</textarea>
                        <span class="help-block">Ruta a la cuál estará asociada el acceso.</span>
                    </div>
                </div>
                <div class="form-group
                @if($errors->has('visible'))
                    {{ 'has-error' }}
                @endif
                ">
                    <label class="col-lg-2 col-sm-2 control-label">Visibilidad</label>
                    <div class="col-sm-10">
                        <div class="input-group-text">
                            <select class="form-control" name="visibilidad" name="visibilidad">
                                <option value="0"
                                    {{isset($acceso) ? (($acceso->visible == 0) ? 'selected': '') : ''}}
                                    {{old('visibilidad') == "0" ? 'selected': ''}}
                                    >No visible</option>
                                <option value="1"
                                    {{isset($acceso) ? (($acceso->visible == 1) ? 'selected': '') : ''}}
                                    {{old('visibilidad') == "1" ? 'selected': ''}}
                                    >Visible</option>
                            </select>
                        </div>                            
                    </div> 
                </div>
                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">Editar</button>
                </div>
            </form>
        </div><!-- /content-panel -->

        </div><!-- /col-md-12 -->
    </div><!-- /row -->
</div>
@stop