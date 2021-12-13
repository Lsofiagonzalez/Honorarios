{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Módulos')

@section('content')

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
            <div class="card" >
                <div class="card-header">
                    <div class="d-flex justify-content-between col-md-12">
                        <h3>
                            <span>
                                <i class="fa fa-angle-right"></i> 
                                {{$modulo->nombre}}
                            </span>
                        </h3>
                        <h1 style="font-size: 35px;">
                            <span>
                                <a href="{{ route('modulos.index') }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="form-horizontal style-form">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Id</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$modulo->id}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$modulo->nombre}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$modulo->descripcion}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Ícono</label>
                        <div class="col-sm-10">
                            <i class="fa {{ $modulo->icono }}"></i><br>
                            <p class="form-control-static">{{$modulo->icono}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Estado</label>
                        <div class="col-sm-10">
                            <h4>
                                <span class="badge {{ ($modulo->estado == 1) ? 'badge-success' : 'badge-danger'}}">
                                        {{ ($modulo->estado == 1) ? 'Activo' : 'Inactivo'}}
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Creado en</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$modulo->created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Modificado en</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$modulo->updated_at}}</p>
                        </div>
                    </div>
                </div>
            </div><!-- /content-panel -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-left col-md-6">
                                <h4>
                                    <span>
                                        <i class="fa fa-angle-right"></i>
                                        <a href="{{ route('submodulos.index') }}"> 
                                        Submódulos
                                        </a>
                                    </span>
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    @foreach(\Schema::getColumnListing("submodulos") as $columna)
                                        @if($columna != "created_at" && $columna != "updated_at" && $columna != "modulo_id")
                                            <th class="text-uppercase text-center">{{ $columna }}</th>
                                        @endif
                                    @endforeach
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($modulo->submodulos as $submodulo)
                                <?php $nombre = $submodulo->nombre?>
                                <tr>
                                    @foreach(\Schema::getColumnListing("submodulos") as $columna)
                                        @if($columna != "created_at" && $columna != "updated_at" && $columna != "modulo_id")
                                            @if($columna == "nombre")
                                                <td>
                                                    @foreach (App\Models\Acceso::where('controlador','=','SubmoduloController@mostrar')->where('estado','=','1')->get() as $sub)
                                                    @if($sub)
                                                        <a href="{{route('submodulos.mostrar', $submodulo->id)}}">
                                                            {{ $submodulo[$columna] }}
                                                        </a>
                                                    @endif
                                                    @endforeach
                                                    @foreach (App\Models\Acceso::where('controlador','=','SubmoduloController@mostrar')->where('estado','=','0')->get() as $sub1)
                                                        @if($sub1)
                                                            <?php echo $nombre ?>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                @continue
                                            @endif 
                                            @if($columna == "estado")
                                                @if($submodulo[$columna] == "1")
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
                                            @if($columna == "visible")
                                                @if($submodulo[$columna] == "1")
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
                                            @if($columna == "modulo_id")
                                                <td class="text-center">
                                                    <a href="{{route('modulos.mostrar', $submodulo->modulo_id)}}">
                                                    {{ $submodulo->modulo_nombre }}
                                                    </a>
                                                </td>
                                                @continue
                                            @endif
        
                                            <td>
                                            @if($columna == "icono")
                                                <i class="fa {{ $submodulo[$columna] }}"><br>
                                            @endif
                                                {{ $submodulo[$columna] }}
                                            </td>
                                        @endif
                                    @endforeach
                                    <td>
                                        @foreach (App\Models\Acceso::where('controlador','=','submoduloController@editar')->where('estado','=','1')->get() as $edit)
                                        @if($edit)
                                            <a href="{{route('submodulos.editar', $submodulo->id)}}">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </a>
                                        @endif
                                        @endforeach
                                        @foreach (App\Models\Acceso::where('controlador','=','submoduloController@eliminar')->where('estado','=','1')->get() as $elim)
                                        @if($elim)
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['submodulos.eliminar', $submodulo->id]
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
        </div><!-- /col-md-12 -->
    </div><!-- /row -->
</div>


@stop

@stop
