{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}

@section('TituloPagina', 'Accesos')

@section('scripts')
    <script src="{{ asset('js/buscar.js') }}"></script>
@stop

@section('estilos')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/accesos/index.css') }}">
@stop

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
                        {{ Session::get('error_message') }}
                    </article>
                @endif
                @if (Session::has('info_message'))
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
                        <form id="buscar" style="margin-left:3%; margin-right:3%" method="GET"
                            action="{{ route('accesos.buscar') }}">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="text-center w-25">
                                            <div class="form-group p-2">
                                                <label for="caracteristica">Característica</label>
                                                <select class="form-control" name="caracteristica" id="caracteristica">
                                                    @foreach (\Schema::getColumnListing('accesos') as $columna)
                                                        @if ($columna == 'created_at' || $columna == 'updated_at')
                                                            @break
                                                        @elseif($columna == 'submodulo_id')
                                                            <option value="{{ $columna }}"
                                                                {{ isset($caracteristica) ? ($caracteristica == $columna ? 'selected' : '') : '' }}>
                                                                submodulo</option>
                                                            @continue
                                                        @endif
                                                        <option value="{{ $columna }}"
                                                            {{ isset($caracteristica) ? ($caracteristica == $columna ? 'selected' : '') : '' }}>
                                                            {{ $columna }}</option>
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

                                                        @case('visible')
                                                        <select class="form-control" name="valor" id="valor">
                                                            <option value=1 selected>Visible</option>
                                                            <option value=0>No visible</option>
                                                        </select>
                                                        @break

                                                        @case('submodulo_id')
                                                        <select class="form-control" name="valor" id="caracteristica">
                                                            @foreach (App\Models\Submodulo::get() as $submodulo)
                                                                <option value="{{ $submodulo->id }}" selected>
                                                                    {{ $submodulo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @break

                                                        @default
                                                        <input type=@if ($caracteristica == 'id') {{ 'number' }}
                                                                    @elseif($caracteristica == 'created_at' || $caracteristica == 'updated_at')
                                                                        {{ 'date' }}
                                                                    @else
                                                                        {{ 'text' }} @endif
                                                            class="form-control"
                                                            {{ isset($caracteristica) ? ($caracteristica == 'id' ? 'min=1' : '') : '' }}
                                                            name="valor" id="valor" value={{ isset($valor) ? $valor : '' }}>
                                                    @endswitch
                                                @else
                                                    <input type=text class="form-control">
                                                @endisset
                                            </div>
                                        </td>
                                        <td class="text-center w-25">
                                            <button type="submit" class="btn btn-success">Buscar</button>
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
                    <hr class="shadow bg-danger">
                    <div id="unseen">
                        <table class="table table-striped table-advance table-hover table-condensed tabla-accesos"
                            style="font-size: 14px">
                            <thead>
                                <tr>
                                    @foreach (\Schema::getColumnListing('accesos') as $columna)
                                        @if ($columna != 'created_at' && $columna != 'updated_at')
                                            @if ($columna == 'submodulo_id')
                                                <th class="text-uppercase text-center">Submódulo al que pertenece</th>
                                            @else
                                                <th class="text-uppercase text-center">{{ $columna }}</th>
                                            @endif
                                        @endif
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accesos as $acceso)
                                    <?php $nombre = $acceso->nombre; ?>
                                    <tr>
                                        @foreach (\Schema::getColumnListing('accesos') as $columna)
                                            @if ($columna != 'created_at' && $columna != 'updated_at')
                                                @if ($columna == 'nombre')
                                                    <td class="text-justify">
                                                        @foreach (App\Models\Acceso::where('controlador', '=', 'AccesoController@mostrar')
            ->where('estado', '=', '1')
            ->get()
        as $acc)
                                                            @if ($acc)
                                                                <a href="{{ route('accesos.mostrar', $acceso->id) }}">
                                                                    {{ $acceso[$columna] }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                        @foreach (App\Models\Acceso::where('controlador', '=', 'AccesoController@mostrar')
            ->where('estado', '=', '0')
            ->get()
        as $acces)
                                                            @if ($acces)
                                                                <?php echo $nombre; ?>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @continue
                                                @endif

                                                @if ($columna == 'estado')
                                                    @if ($acceso[$columna] == '1')
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

                                                @if ($columna == 'submodulo_id')
                                                    <td class="text-center">
                                                        @foreach (App\Models\Acceso::where('controlador', '=', 'SubmoduloController@mostrar')
            ->where('estado', '=', '1')
            ->get()
        as $sub)
                                                            @if ($sub)
                                                                <a
                                                                    href="{{ route('submodulos.mostrar', $acceso->submodulo->id) }}">
                                                                    {{ $acceso->submodulo->nombre }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                        @foreach (App\Models\Acceso::where('controlador', '=', 'SubmoduloController@mostrar')
            ->where('estado', '=', '0')
            ->get()
        as $sub1)
                                                            @if ($sub1)
                                                                <?php echo $acceso->submodulo->nombre; ?>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @continue
                                                @endif

                                                @if ($columna == 'controlador')
                                                    <td class="text-justify">
                                                        @foreach (explode('@', $acceso[$columna]) as $indice => $parte)
                                                            {{ $parte }} <br>
                                                            @if ($indice == 0)
                                                                @
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    @continue
                                                @endif

                                                @if ($columna == 'ruta_nombre')
                                                    <td class="text-justify">
                                                        @foreach (explode('/', $acceso[$columna]) as $indice => $parte)
                                                            @if ($acceso[$columna] != '')
                                                                {{ $parte }} <br>
                                                                @if($indice != (count(explode('/', $acceso[$columna])) - 1)
                                                                )
                                                                /
                                                            @endif
                                                        @endif
                                                @endforeach
                                                </td>
                                                @continue
                                            @endif

                                            @if ($columna == 'visible')
                                                @if ($acceso[$columna] == '1')
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
                                    <a href="{{ route('accesos.editar', $acceso->id) }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </a>
                                    @foreach (App\Models\Acceso::where('controlador', '=', 'AccesoController@eliminar')
            ->where('estado', '=', '1')
            ->get()
        as $elim)
                                        @if ($elim)
                                            {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['accesos.eliminar', $acceso->id],
                                            ]) !!}
                                            {!! Form::button("<i class='fas fa-trash'></i>", ['type' => 'submit', 'class' =>
                                            'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                </td>
                                @endif
                                @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $accesos->links('componentes.paginacion') }}
                        </div>
                    </div>
                </div><!-- /content-panel -->
            </div><!-- /col-md-12 -->
        </div>

    </div>
@stop
