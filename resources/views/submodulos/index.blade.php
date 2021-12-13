{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Submódulos')

@section('scripts')
    <script src="{{ asset('js/buscar.js')}}"></script>
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
            @if(Session::has('info_message'))
            <article class="alert alert-info">
                {{ Session::get('info_message') }}
            </article>
            @endif
            <div class=" card mb-3">
                <div class="card-header">
                    <h4><i class="fa fa-angle-right"></i> Buscar
                    </h4>
                </div>
                <div class="card-body">
                    <form id="buscar" style= "margin-left:3%; margin-right:3%" method="GET" action="{{ route('submodulos.buscar') }}">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="text-center w-25">
                                        <div class="form-group p-2">
                                            <label for="caracteristica">Característica</label>
                                            <select class="form-control" name="caracteristica" id="caracteristica">
                                                @foreach(\Schema::getColumnListing("submodulos") as $columna)
                                                @if($columna == "created_at" || $columna == "updated_at")
                                                    @break
                                                @elseif($columna == "modulo_id")
                                                    <option value="{{$columna}}" {{ (isset($caracteristica)) ? (($caracteristica == $columna) ? 'selected' : '') : '' }}>Modulo</option>
                                                    @continue
                                                @endif
                                                    <option value="{{$columna}}" {{ (isset($caracteristica)) ? (($caracteristica == $columna) ? 'selected' : '') : '' }}>{{$columna}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center w-50">
                                        <div class="form-group p-2">
                                            <label for="valor">Valor</label>
                                            @isset($caracteristica)
                                                @switch($caracteristica)
                                                    @case('estado')
                                                        <select class="form-control" name="valor" id="valor">
                                                            <option value=1 selected >Activo</option>
                                                            <option value=0>Inactivo</option>                                                
                                                        </select>
                                                        @break
    
                                                     @case('visible')
                                                        <select class="form-control" name="valor" id="valor">
                                                            <option value=1 selected>Visible</option>
                                                            <option value=0>No visible</option>                                                
                                                        </select>
                                                        @break  
                                                
                                                    @case('modulo_id')
                                                        <select class="form-control" name="valor" id="valor">
                                                            @foreach (App\Models\Modulo::get() as $modulo)
                                                                <option value="{{ $modulo->id }}" selected>{{ $modulo->nombre }}</option>
                                                            @endforeach                                               
                                                        </select>
                                                        @break
                                                
                                                    @default
                                                    <input type=
                                                        @if($caracteristica == 'id')
                                                        {{ 'number' }}
                                                        @elseif($caracteristica == 'created_at' || $caracteristica == 'updated_at')
                                                        {{ 'date' }}
                                                        @else
                                                        {{ 'text' }}
                                                    @endif
                                                    class="form-control" {{ (isset($caracteristica)) ? (($caracteristica == 'id') ? 'min=1' : '') : '' }} name="valor" id="valor" value={{ (isset($valor)) ? $valor : '' }}>
                                                @endswitch
                                            @else
                                            <input type=text class="form-control">
                                            @endisset
                                        </div>
                                    </td>
                                    <td class="text-center w-25">
                                        <button type="submit" class="btn btn-primary btn-lg">Buscar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>  
            </div>
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-angle-right"></i>@yield('TituloPagina')
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            @foreach(\Schema::getColumnListing("submodulos") as $columna)
                                @if($columna != "created_at" && $columna != "updated_at")
                                    @if($columna == "modulo_id")
                                        <th class="text-uppercase text-center">Modulo al que pertenece</th>
                                    @else
                                        <th class="text-uppercase text-center">{{ $columna }}</th>
                                    @endif
                                @endif
                            @endforeach
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($submodulos as $submodulo)
                        <?php $nombre = $submodulo->nombre?>
                        <tr>
                            @foreach(\Schema::getColumnListing("submodulos") as $columna)
                                @if($columna != "created_at" && $columna != "updated_at")
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
                                            @foreach (App\Models\Acceso::where('controlador','=','ModuloController@mostrar')->where('estado','=','1')->get() as $mod)
                                            @if($mod)
                                                <a href="{{route('modulos.mostrar',$submodulo->modulo->id)}}">
                                                    {{ $submodulo->modulo->nombre }}
                                                </a>
                                            @endif
                                            @endforeach
                                            @foreach (App\Models\Acceso::where('controlador','=','ModuloController@mostrar')->where('estado','=','0')->get() as $modu)
                                            @if($modu)
                                                <?php echo $submodulo->modulo->nombre ?>
                                            @endif
                                            @endforeach
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
                                        <i class="fas fa-edit">
                                        </i>
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
                    <div class="text-center">
                        {{ $submodulos->links('componentes.paginacion') }}
                    </div>
                </div>
            </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
    </div>
</div>
@stop