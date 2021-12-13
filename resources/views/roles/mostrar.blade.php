{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Roles')

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
                                {{$rol->nombre}}<br>
                            </span>
                        </h3>
                        <h1 style="font-size: 35px;">
                            <span>
                                <a href="{{ route('roles.index') }}" class="text-theme03" title="Volver"><i class="fa fa-arrow-circle-left text-right"></i></a>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="form-horizontal style-form">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Id</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$rol->id}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$rol->nombre}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$rol->descripcion}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Estado</label>
                        <div class="col-sm-10">
                            <h4>
                                <span class="badge {{ ($rol->estado == 1) ? 'badge-success' : 'badge-danger'}}">
                                        {{ ($rol->estado == 1) ? 'Activo' : 'Inactivo'}}
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Rol del cuál hereda</label>
                        <div class="col-sm-10">
                        @if($rol->rol_id != null)
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','1')->get() as $rol1)
                            @if($rol1)
                            <a href="{{route('roles.mostrar', $rol->rol->id)}}">
                                <p class="form-control-static">{{$rol->rol->nombre}}</p>
                            </a>
                            @endif
                            @endforeach
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','0')->get() as $rol2)
                            @if($rol2)
                                <?php echo  $rol->rol->nombre ?>
                            @endif
                            @endforeach
                        @else
                        No hereda
                        @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Creado en</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$rol->created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Modificado en</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$rol->updated_at}}</p>
                        </div>
                    </div>
                    <div>
                        <table>
                            
                        </table>
                    </div>
                </div>
            </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between col-md-12">
                        <h3>
                            <span>
                                <i class="fa fa-angle-right"></i> 
                                Permisos de rol
                            </span>
                        </h3>
                        <h1 style="font-size: 35px;">
                            <span>
                                <a href="{{ route('permisos.administrar', $rol->id) }}" class="text-theme03" title="Editar Permisos"><i class="far fa-edit"></i></a>
                            </span>
                        </h1>
                    </div>
                </div>
                <div>
                    <table class="table table-striped table-advance table-hover table-condensed tabla-accesos">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Submódulo</th>
                            <th>Acción</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Visible</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rol->permisosTotal() as $permiso)
                            <tr>
                                <td>
                                @foreach (App\Models\Acceso::where('controlador','=','ModuloController@mostrar')->where('estado','=','1')->get() as $mod)
                                @if($mod)    
                                    <a href="{{ route('modulos.mostrar', $permiso->acceso->submodulo->modulo->id) }}">
                                        {{$permiso->acceso->submodulo->modulo->nombre}}
                                    </a>
                                @endif
                                @endforeach
                                @foreach (App\Models\Acceso::where('controlador','=','ModuloController@mostrar')->where('estado','=','0')->get() as $modu)
                                @if($modu)
                                    <?php echo $permiso->acceso->submodulo->modulo->nombre ?>
                                @endif
                                @endforeach
                                </td>
                                <td>
                                @foreach (App\Models\Acceso::where('controlador','=','SubmoduloController@mostrar')->where('estado','=','1')->get() as $sub)
                                @if($sub)
                                    <a href="{{ route('submodulos.mostrar', $permiso->acceso->submodulo->id) }}">
                                        {{$permiso->acceso->submodulo->nombre}}
                                    </a>
                                @endif
                                @endforeach
                                @foreach (App\Models\Acceso::where('controlador','=','SubmoduloController@mostrar')->where('estado','=','0')->get() as $sub1)
                                    @if($sub1)
                                        <?php echo $permiso->acceso->submodulo->nombre ?>
                                    @endif
                                @endforeach
                                </td>
                                <td>
                                @foreach (App\Models\Acceso::where('controlador','=','AccesoController@mostrar')->where('estado','=','1')->get() as $acc)
                                @if($acc)   
                                    <a href="{{ route('accesos.mostrar', $permiso->acceso->id) }}">
                                        {{$permiso->acceso->nombre}}
                                    </a>
                                @endif
                                @endforeach
                                @foreach (App\Models\Acceso::where('controlador','=','AccesoController@mostrar')->where('estado','=','0')->get() as $acces)
                                @if($acces)
                                    <?php echo $permiso->acceso->nombre ?>
                                @endif
                                @endforeach
                                </td>
                                <td>
                                    {{$permiso->acceso->descripcion}}
                                </td>
                                <td class="text-center">
                                    @if($permiso->acceso->estado == "1")
                                    <span class="badge badge-success label-mini">
                                        Activo
                                    </span>
                                    @else
                                    <span class="badge badge-danger label-mini">
                                        Inactivo
                                    </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($permiso->acceso->visible == "1")
                                    <span class="badge badge-info label-mini">
                                        Visible
                                    </span>
                                    @else
                                    <span class="badge badge-warning label-mini">
                                        No visible
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
