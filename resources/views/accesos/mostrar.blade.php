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
                                {{$acceso->nombre}}
                            </span>
                        </h3>
                        <h1 style="font-size: 35px;">
                            <span>
                                <a href="{{ route('accesos.index') }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="form-horizontal style-form">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Id</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->id}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->nombre}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->descripcion}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Estado</label>
                        <div class="col-sm-10">
                            <h4>
                                <span class="badge {{ ($acceso->estado == 1) ? 'badge-success' : 'badge-danger'}}">
                                        {{ ($acceso->estado == 1) ? 'Activo' : 'Inactivo'}}
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Submódulo al que pertenece</label>
                        <div class="col-sm-10">
                        @foreach (App\Models\Acceso::where('controlador','=','SubmoduloController@mostrar')->where('estado','=','1')->get() as $sub)
                        @if($sub)
                            <a href="{{route('submodulos.mostrar', $acceso->submodulo->id)}}">
                                <p class="form-control-static">{{$acceso->submodulo->nombre}}</p>
                            </a>
                        @endif
                        @endforeach
                        @foreach (App\Models\Acceso::where('controlador','=','SubmoduloController@mostrar')->where('estado','=','0')->get() as $sub1)
                        @if($sub1)
                            <?php echo  $acceso->submodulo->nombre ?>
                        @endif
                        @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Controlador</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->controlador}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Ruta</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->ruta_nombre}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10">
                            <h4>
                                <span class="badge {{ ($acceso->visible == 1) ? 'badge-info' : 'badge-warning'}}">
                                        {{ ($acceso->visible == 1) ? 'Visible' : 'No visible'}}
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Creado en</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Modificado en</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$acceso->updated_at}}</p>
                        </div>
                    </div>
                </div>
            </div><!-- /content-panel -->
    

        </div><!-- /col-md-12 -->
    </div><!-- /row -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="text-left col-md-6">
                        <h3>
                            <span>
                                <i class="fa fa-angle-right"></i> 
                                Roles con acceso
                            </span>
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-advance table-hover table-condensed tabla-accesos">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($acceso->permisos as $permiso)
                        <tr>
                            <td>
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','1')->get() as $rol1)
                            @if($rol1)
                                <a href="{{ route('roles.mostrar', $permiso->rol->id) }}">
                                    {{$permiso->rol->nombre}}
                                </a>
                            @endif
                            @endforeach
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','0')->get() as $rol2)
                            @if($rol2)
                                <?php echo $permiso->rol->nombre ?>
                            @endif
                            @endforeach
                            </td>
                            <td>
                                {{$permiso->rol->descripcion}}
                            </td>
                            <td class="text-center">
                                @if($permiso->rol->estado == "1")
                                <span class="badge badge-success">
                                    Activo
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    Inactivo
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- /content-panel -->

        </div><!-- /col-md-12 -->
    </div><!-- /row -->
</div>
@stop
