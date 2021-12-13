{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Roles')

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
            <div class="card mb-3">
                <div class="card-header">
                    <h4><i class="fa fa-angle-right"></i> Buscar
                    </h4>
                </div>
                <div class="card-body">
                    <form id="buscar" style= "margin-left:3%; margin-right:3%" method="GET" action="{{ route('roles.buscar') }}">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="text-center w-25">
                                        <div class="form-group p-2">
                                            <label for="caracteristica">Característica</label>
                                            <select class="form-control" name="caracteristica" id="caracteristica">
                                                @foreach(\Schema::getColumnListing("roles") as $columna)
                                                @if($columna != "created_at" && $columna != "updated_at")
                                                    @if($columna == 'rol_id')
                                                    <option value="{{ $columna }}" {{ (isset($caracteristica)) ? (($caracteristica == $columna) ? 'selected' : '') : '' }}>rol hereda</option>
                                                        @continue
                                                    @endif
    
                                                    <option value="{{$columna}}" {{ (isset($caracteristica)) ? (($caracteristica == $columna) ? 'selected' : '') : '' }}>{{$columna}}</option>
                                                @endif
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
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0>Inactivo</option>                                                
                                                        </select>
                                                        @break
                                                
                                                    @case('rol_id')
                                                        <select class="form-control" name="valor" id="valor">
                                                            @foreach (App\Models\Rol::get() as $rol)
                                                                <option value="{{ $rol->id }}" {{ (isset($valor) ? (($valor == $rol->id) ? 'selected' : '') : '') }}>{{ $rol->nombre }}</option>
                                                            @endforeach                                               
                                                        </select>
                                                        @break
    
                                                    @default
                                                    <input type=
                                                        @if($caracteristica == 'id' || $caracteristica == 'GD_id')
                                                        {{ 'number' }}
                                                        @elseif($caracteristica == 'created_at' || $caracteristica == 'updated_at')
                                                        {{ 'date' }}
                                                        @else
                                                        {{ 'text' }}
                                                        @endif 
                                                    class="form-control" {{ (isset($caracteristica)) ? (($caracteristica == 'id' || $caracteristica == 'GD_id') ? 'min=1' : '') : '' }} name="valor" id="valor" value={{ (isset($valor)) ? $valor : '' }}>
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
                    <h4><i class="fa fa-angle-right"></i> @yield('TituloPagina')
                    </h4>
                </div>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        @foreach(\Schema::getColumnListing("roles") as $columna)
                            @if($columna != "created_at" && $columna != "updated_at")
                                @if($columna == "rol_id")
                                    <th class="text-uppercase text-center">Rol hereda</th>
                                @else
                                    <th class="text-uppercase text-center">{{ $columna }}</th>
                                @endif
                            @endif
                        @endforeach
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $rol)
                    <?php $nombre=$rol->nombre ?>
                    <tr>
                        @foreach(\Schema::getColumnListing("roles") as $columna)
                            @if($columna != "created_at" && $columna != "updated_at")
                                @if($columna == "nombre")
                                    <td>
                                    @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','1')->get() as $rol1)
                                    @if($rol1)
                                        <a href="{{route('roles.mostrar', $rol->id)}}">
                                            {{ $rol[$columna] }}
                                        </a>
                                    @endif
                                    @endforeach
                                    @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','0')->get() as $rol2)
                                    @if($rol2)
                                        <?php echo  $nombre ?>
                                    @endif
                                    @endforeach
                                    </td>
                                    @continue
                                @endif 

                                @if($columna == "estado")
                                    @if($rol[$columna] == "1")
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
                                
                                @if($columna == "rol_id")
                                    <td class="text-center">
                                    @if($rol->rol_id != null)
                                        @foreach (App\Models\Acceso::where('controlador','=','RolController@mostrar')->where('estado','=','1')->get() as $rol1)
                                        @if($rol1)
                                        <a href="{{route('roles.mostrar', $rol->rol->id)}}">
                                        {{ $rol->rol->nombre }}
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
                                    </td>
                                    @continue
                                @endif

                                <td>
                                @if($columna == "icono")
                                    <i class="fa {{ $rol[$columna] }}"><br>
                                @endif 
                                    {{ $rol[$columna] }}
                                </td>

                            @endif
                        @endforeach
                        <td>
                        @foreach (App\Models\Acceso::where('controlador','=','RolController@editar')->where('estado','=','1')->get() as $edit)
                        @if($edit)
                            <a href="{{route('roles.editar', $rol->id)}}">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                            @endif
                            @endforeach
                            @foreach (App\Models\Acceso::where('controlador','=','RolController@eliminar')->where('estado','=','1')->get() as $elim)
                            @if($elim)
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['roles.eliminar', $rol->id]
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
                    {{ $roles->links('componentes.paginacion') }}
                </div>
            </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
    </div><!-- /row -->
</div>
@stop