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
                            @yield('accion')
                        </span>
                    </h3>
                    <h1 style="font-size: 35px;">
                        <span>
                            <a href="{{ route('submodulos.index') }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                        </span>
                    </h1>
                </div>
            </div>
            <div class="card-body">
                <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%" method="POST" action="{{ isset($submodulo) ? route($ruta, $submodulo->id) : route($ruta) }}">
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
                            <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
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
                            <textarea class="form-control" name="descripcion">
                                    {{{ old('descripcion') }}}
                            </textarea>
                            <span class="help-block">Breve explicación de funcionalidad del submódulo.</span>
                        </div>
                    </div>
                    <div class="form-group
                    @if($errors->has('icono'))
                        {{ 'has-error' }}
                    @endif
                    ">
                        <label class="col-sm-2 col-sm-2 control-label">Ícono</label>
                        <div class="col-sm-10">
                            @if($errors->has('icono'))
                            <span class="control-label">
                                {{ $errors->first('icono') }} <br>
                            </span>
                            @endif
                            <input type="text" class="form-control" name="icono" value= "{{ old('icono') }}">
                            <span class="help-block">Nombre del ícono en la librería font-awesome.</span>
                        </div>
                    </div>
                    <div class="form-group
                    @if($errors->has('estado'))
                        {{ 'has-error' }}
                    @endif
                    ">
                        <label class="col-lg-2 col-sm-2 control-label">Estado</label>
                        <div class="col-sm-10">                            
                            <h4>
                                <span class="badge badge-success">
                                    Activo
                                </span>
                            </h4>
                        </div> 
                    </div>
                    <div class="form-group
                    @if($errors->has('modulo_id'))
                        {{ 'has-error' }}
                    @endif
                    ">
                        <label class="col-lg-2 col-sm-2 control-label" for="modulo_id">Módulo al que pertenece</label>
                        <div class="col-sm-10">
                            @if($errors->has('modulo_id'))
                            <span class="control-label">
                                {{ $errors->first('modulo_id') }} <br>
                            </span>
                            @endif
    
                            <select class="form-control" name="modulo_id" id="modulo_id">
                                @foreach(\App\Models\Modulo::where('estado', '=', '1')->get() as $modulo)
                                    <option value="{{$modulo->id}}"
                                        {{isset($submodulo) ? (($submodulo->modulo_id == $modulo->id) ? 'selected': '') : ''}}
                                        {{old('modulo_id') ? ((old('modulo_id') == $modulo->id) ? 'selected': '') : ''}}
                                        >{{$modulo->nombre}}</option>
                                @endforeach
                            </select>
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
                                    <option value="0" {{old('visibilidad') == "0" ? 'selected': ''}} >No visible</option>
                                    <option value="1" {{old('visibilidad') == "1" ? 'selected': ''}} >Visible</option>
                                </select>
                            </div>                            
                        </div> 
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">@yield('accion')</button>
                    </div>
                </form>
            </div>
            
        </div><!-- /content-panel -->

        </div><!-- /col-md-12 -->
    </div> 
</div>
@stop