{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Submódulos')

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
                                {{$submodulo->nombre}}
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
                    <div class="form-horizontal style-form">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Id</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$submodulo->id}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$submodulo->nombre}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$submodulo->descripcion}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Ícono</label>
                            <div class="col-sm-10">
                                <i class="fa {{ $submodulo->icono }}"></i><br>
                                <p class="form-control-static">{{$submodulo->icono}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Estado</label>
                            <div class="col-sm-10">
                                <h4>
                                    <span class="badge {{ ($submodulo->estado == 1) ? 'badge-success' : 'badge-danger'}}">
                                            {{ ($submodulo->estado == 1) ? 'Activo' : 'Inactivo'}}
                                    </span>
                                </h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Módulo al que pertenece</label>
                            <div class="col-sm-10">
                                @foreach (App\Models\Acceso::where('controlador','=','ModuloController@mostrar')->where('estado','=','1')->get() as $mod)
                                @if($mod)
                                <a href="{{route('modulos.mostrar', $submodulo->modulo->id)}}">
                                    <p class="form-control-static">{{ $submodulo->modulo->nombre }}</p>
                                </a>
                                @endif
                                @endforeach
                                @foreach (App\Models\Acceso::where('controlador','=','ModuloController@mostrar')->where('estado','=','0')->get() as $modu)
                                @if($modu)
                                    <?php echo $submodulo->modulo->nombre ?>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Creado en</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$submodulo->created_at}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Modificado en</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{$submodulo->updated_at}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header col-md-12">
                    <h3>
                        <span>
                            <i class="fa fa-angle-right"></i> 
                            Accesos
                        </span>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-advance table-hover table-condensed tabla-accesos">
                        <thead>
                        <tr>
                            @foreach(\Schema::getColumnListing("accesos") as $columna)
                                @if($columna != "created_at" && $columna != "updated_at" && $columna != "submodulo_id")
                                    <th class="text-uppercase text-center">{{ $columna }}</th>
                                @endif
                            @endforeach
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($submodulo->accesos as $acceso)
                        <?php $nombre = $acceso->nombre?>
                        <tr>
                            @foreach(\Schema::getColumnListing("accesos") as $columna)
                                @if($columna != "created_at" && $columna != "updated_at")
                                    @if($columna == "nombre")
                                        <td class="text-justify">
                                            @foreach (App\Models\Acceso::where('controlador','=','AccesoController@mostrar')->where('estado','=','1')->get() as $acc)
                                            @if($acc)
                                                <a href="{{route('accesos.mostrar', $acceso->id)}}">
                                                    {{ $acceso[$columna] }}
                                                </a>
                                            @endif
                                            @endforeach
                                            @foreach (App\Models\Acceso::where('controlador','=','AccesoController@mostrar')->where('estado','=','0')->get() as $acces)
                                            @if($acces)
                                                <?php echo $nombre ?>
                                            @endif
                                            @endforeach
                                        </td>
                                        @continue
                                    @endif 

                                    @if($columna == "estado")
                                        @if($acceso[$columna] == "1")
                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                Activo
                                            </span>
                                        </td>
                                        @else
                                        <td class="text-center">
                                            <span class="badge badge-danger">
                                                Inactivo
                                            </span>
                                        </td>
                                        @endif
                                        @continue
                                    @endif 
                                    
                                    @if($columna == "submodulo_id")
                                        @continue
                                    @endif

                                    @if($columna == "controlador")
                                        <td class="text-justify">
                                            @foreach(explode('@', $acceso[$columna]) as $indice => $parte) 
                                                {{ $parte }} <br> 
                                                @if($indice == 0)
                                                @
                                                @endif
                                            @endforeach
                                        </td>
                                        @continue
                                    @endif

                                    @if($columna == "ruta")
                                        <td class="text-justify">
                                            @foreach(explode('/', $acceso[$columna]) as $indice => $parte) 
                                                @if($acceso[$columna] != "")
                                                    {{ $parte }} <br> 
                                                    @if($indice != (count(explode('/', $acceso[$columna])) - 1) )
                                                    /
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        @continue
                                    @endif

                                    @if($columna == "visible")
                                        @if($acceso[$columna] == "1")
                                        <td class="text-center">
                                            <span class="badge badge-info">
                                                Visible
                                            </span>
                                        </td>
                                        @else
                                        <td class="text-center">
                                            <span class="badge badge-warning">
                                                No visible
                                            </span>
                                        </td>
                                        @endif
                                        @continue
                                    @endif 

                                    <td>
                                        {{ $acceso[$columna] }}
                                    </td>

                                @endif
                            @endforeach
                            <td class="text-justify">
                                <a href="{{route('accesos.editar', $acceso->id)}}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit">
                                        </i>
                                    </button>
                                </a>
                                @foreach (App\Models\Acceso::where('controlador','=','AccesoController@eliminar')->where('estado','=','1')->get() as $elim)
                                @if($elim)
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['accesos.eliminar', $acceso->id]
                                ]) !!}
                                {!! Form::button("<i class=\"fas fa-trash\"></i>", ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                            @endif
                            @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- /content-panel -->

        </div><!-- /col-md-12 -->
    </div>
</div>
@stop
