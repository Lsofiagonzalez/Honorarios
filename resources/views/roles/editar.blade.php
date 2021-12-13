{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Roles')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                @if (Session::has('success_message'))
                    <article class="alert alert-success">
                        {{ Session::get('success_message') }}
                    </article>
                @endif
                @if (Session::has('error_message'))
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
                                    <a href="{{ route('roles.index') }}" class="text-theme03"><i
                                            class="fa fa-arrow-circle-left text-right"></i></a>
                                </span>
                            </h1>
                        </div>
                    </div>
                    <form class="form-horizontal style-form" style="margin-left:3%; margin-right:3%" method="POST"
                        action="{{ isset($rol) ? route($ruta, $rol->id) : route($ruta) }}">
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="form-group 
                            @if ($errors->has('nombre')) {{ 'has-error' }} @endif
                            ">
                            <label class="col-sm-2 col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-10">
                                @if ($errors->has('nombre'))
                                    <span class="control-label">
                                        {{ $errors->first('nombre') }} <br>
                                    </span>
                                @endif
                                <input type="text" class="form-control" name="nombre"
                                    value=@isset($rol) "{{ $rol->nombre }}" @else "{{ old('nombre') }}" @endisset>
                            </div>
                        </div>
                        <div class="form-group
                            @if ($errors->has('descripcion')) {{ 'has-error' }} @endif
                            ">
                            <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-10">
                                @if ($errors->has('descripcion'))
                                    <span class="control-label">
                                        {{ $errors->first('descripcion') }} <br>
                                    </span>
                                @endif
                                <textarea class="form-control" name="descripcion"
                                    value="{{ isset($rol) ? $rol->descripcion : old('descripcion') }}">{{ isset($rol) ? $rol->descripcion : old('descripcion') }}</textarea>
                                <span class="help-block">Breve explicación de funcionalidad del submódulo.</span>
                            </div>
                        </div>
                        <div class="form-group
                            @if ($errors->has('estado')) {{ 'has-error' }} @endif
                            ">
                            <label class="col-lg-2 col-sm-2 control-label">Estado</label>
                            <div class="col-sm-10">
                                <div class="input-group-text">
                                    <input type="checkbox" aria-label="Checkbox de activación/inactivación" name="estado"
                                        value="{{ $rol->estado }}" @if ($rol->estado == 1) {{ 'checked' }} @endif> Activo
                                </div>
                            </div>
                        </div>
                        <div class="form-group
                            @if ($errors->has('rol_id')) {{ 'has-error' }} @endif
                            ">
                            <label class="col-lg-2 col-sm-2 control-label" for="rol_id">Rol del cual hereda</label>
                            <div class="col-sm-10">
                                @if ($errors->has('rol_id'))
                                    <span class="control-label">
                                        {{ $errors->first('rol_id') }} <br>
                                    </span>
                                @endif

                                <select class="form-control" name="rol_id" id="rol_id">
                                    <option value="">No hereda</opcion>
                                        @isset($rol)
                                            <!-- Roles hereda -->
                                            @foreach ($rolesHeredar as $rol_hereda)
                                        <option value="{{ $rol_hereda->id }}"
                                            {{ isset($rol) ? ($rol->rol_id == $rol_hereda->id ? 'selected' : '') : '' }}
                                            {{ old('rol_id') ? (old('rol_id') == $rol_hereda->id ? 'selected' : '') : '' }}>
                                            {{ $rol_hereda->nombre }}</option>
                                        @endforeach
                                    @else
                                        @foreach (\App\Models\Rol::where('estado', '=', '1')->get() as $rol_hereda)
                                            <option value="{{ $rol_hereda->id }}"
                                                {{ isset($rol) ? ($rol->rol_id == $rol_hereda->id ? 'selected' : '') : '' }}
                                                {{ old('rol_id') ? (old('rol_id') == $rol_hereda->id ? 'selected' : '') : '' }}>
                                                {{ $rol_hereda->nombre }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">Editar</button>
                            </div>
                        </form>
                    </div><!-- /content-panel -->

                </div><!-- /col-md-12 -->
            </div><!-- /row -->
        </div>

    @stop
