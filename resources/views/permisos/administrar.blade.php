{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Permisos a accesos')

@section('scripts')
    <script src="{{ asset('js/buscar.js')}}"></script>
@stop

@section('estilos')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/accesos/index.css')}}">
@stop

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
                {{ Session::get('error_message') }}
            </article>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between col-md-12">
                        <h3>
                            <span>
                                <i class="fa fa-angle-right"></i> 
                                @yield('TituloPagina')
                            </span>
                        </h3>
                        <h1 style="font-size: 35px;">
                            <span>
                                <a href="{{ route('roles.mostrar', $rol->id) }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="card-body">
                    <form id="buscar" method="POST" action="{{ route('permisos.actualizar', $rol->id) }}">
                        @foreach(App\Models\Modulo::get() as $modulo)
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <h4><i class="fa fa-angle-right"></i> 
                                {{ $modulo->nombre }} <br>
                            </h4>
                            <hr>
                            @foreach($modulo->submodulos as $submodulo)
                            <h5><i class="fa fa-angle-right"></i> 
                                {{ $submodulo->nombre }} <br>
                            </h5>
                            <section id="unseen">
                            <table class="table table-striped table-advance table-hover table-condensed tabla-accesos">
                                <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">Rol Hereda</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Visible</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($submodulo->accesos as $index => $acceso)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" aria-label="Checkbox para seleccionar el permiso"
                                            name="accesos[]"
                                            value="{{$acceso->id}}"
                                            @if(is_array(old('accesos')) && in_array($acceso->id, old('accesos')))
                                                checked
                                            @elseif(count($rol->permisosHereda()->where('acceso_id', '=', $acceso->id)))
                                                checked disabled
                                            @elseif(count($rol->permisos->where('acceso_id', '=', $acceso->id)))
                                                checked 
                                            @endif
                                            >
                                        </td>
                                        <td class="text-center">
                                            @if(count($rol->permisosHereda()->where('acceso_id', '=', $acceso->id)))
                                                <a href="{{ route('roles.mostrar', $rol->permisosHereda()->where('acceso_id', '=', $acceso->id)->first()->rol->id) }}">
                                                        {{$rol->permisosHereda()->where('acceso_id', '=', $acceso->id)->first()->rol->nombre}}
                                                </a>
                                            @elseif(count($rol->permisos->where('acceso_id', '=', $acceso->id)))
                                                Propio
                                            @else
                                                -----
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('accesos.mostrar', $acceso->id)}}">
                                            {{$acceso->nombre}}
                                            </a>
                                        </td>
                                        <td>{{$acceso->descripcion}}</td>
                                        <td class="text-center">
                                            @if($acceso->estado == "1")
                                            <span class="badge badge-success">
                                                Activo
                                            </span>
                                            @else
                                            <span class="badge badge-danger">
                                                Inactivo
                                            </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($acceso->visible == "1")
                                            <span class="badge badge-info">
                                                Visible
                                            </span>
                                            @else
                                            <span class="badge badge-warning">
                                                No visible
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endforeach
                            <br>
                        @endforeach
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
                        </div>
                        </section>
                        </form>
                </div>
            </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
    </div><!-- /row -->
</div>
@stop