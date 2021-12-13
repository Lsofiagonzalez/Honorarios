@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row">
          <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-uppercase"> <strong>Prestación De Servicios</strong></h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('medicos.consultar') }}" method="POST" onsubmit="boton.disabled = true; return true;">
                            @csrf
                            <div class="d-flex align-items-center">
                                @include('parciales.sistema')
                                <div class="form-group col-md-4 col-sm-3">
                                    <div class="text-center">
                                        Seleccione ámbito
                                        <select name="ambitoConsultar" required
                                            class="form-control form-control-sm text-center">
                                            <option value="" selected="selected">SELECCIONA UN ÁMBITO*</option>
                                            @foreach ($ambitos as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary mt-3" id="boton" name="boton" type="submit">Consultar</button>
                                <button type="reset" class="btn btn-secondary mt-3">Limpiar Campos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($datos)
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('medicos.visualizar-pago') }}" method="POST">
                        @csrf
                        <input type="hidden" name="fechaInicial" value="{{ date('Y-m-d', strtotime($fechaInicial)) }}">
                        <input type="hidden" name="fechaFinal" value="{{ date('Y-m-d', strtotime($fechaFinal)) }}">
                        <input type="hidden" name="nombreMedico" value="{{ $nombre }}">
                        <input type="hidden" name="ambito" value="{{ $ambito }}">
                        <div class="card" style="height: 40rem">
                            <div class="card-header">
                                <h3 class="text-uppercase"> <strong>RESULTADOS CONSULTA</strong></h3>
                            </div>
                            <div class="card-body mb-5">
                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <div class="card-text">
                                            Medico: {{ $nombre }}
                                        </div>
                                        <div class="card-text">
                                            Honorarios generados entre las fechas.
                                        </div>
                                        <div class="card-text">
                                            {{ date('Y-m-d', strtotime($fechaInicial)) . ' / ' . date('Y-m-d', strtotime($fechaFinal)) }}
                                        </div>
                                    </div>
                                    <div class="form-group mr-3 mb-3">
                                        <div class="card-text">
                                            Cantidad: {{ ($datosReal) }}
                                        </div>
                                        {{-- <div class="card-text">
                                            CxP(%): $ {{ number_format($total,2,",",".") }}
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <hr class="shadow bg-danger mt-5">
                            <input type="hidden" id="numero1" value="{{count($datos)}}">
                            <div class="card-body table-responsive">
                                <table class="table text-center text-uppercase table-striped" style="font-size: 14px">
                                    <thead>
                                       <th>
                                        <input type="checkbox" name="seviciosTodos1" id="todos1"
                                        onchange="seleccionarTodosHonorariosMedico()"> </th>
                                        <th>Fecha/Hora</th>
                                        <th>Documento Paciente</th>
                                        <th>Nombre Paciente</th>
                                        <th>Servicio</th>
                                        <th>Cantidad</th>
                                        <th>CxP Med</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($datos as $key => $honorario)
                                            @php
                                                $honorarioOrden = "honorario". $key;
                                            @endphp
                                        @if(($honorario->IDBOLETA != 0 || $honorario->IDBOLETA != NULL ) && $honorario->ID_SOPORTE == 0 )
                                            <tr>
                                                <td>
                                                     <input  type="checkbox" name="honorarios[]" id="{{ $honorarioOrden }}" value="{{$honorario->ID}}">
                                                </td>
                                                <td>{{ $honorario->HORA_MVTO }}</td>
                                                <td>{{ $honorario->NUM_PACIENTE }}</td>
                                                <td>{{ $honorario->NOM_PACIENTE }}</td>
                                                <td>{{ $honorario->NOM_SER}}</td>
                                                <td>{{ $honorario->CT_SER_MVTO }}</td>
                                                <td>{{number_format($honorario->CXP_MED_MVTO,0,",",".")}}</td>
                                            </tr>
                                            @endif
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger btn-lg">GENERAR REPORTE DE PAGO</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
 
@endsection
