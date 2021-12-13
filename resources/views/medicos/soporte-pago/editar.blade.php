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
                        <form action="{{ route('medicos.consultar') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center">
                                
                                @include('parciales.sistema')
                                
                                <div class="form-group col-md-4 col-sm-3">
                                    <div class="text-center">
                                        Ámbito
                                        @switch($ambito)
                                            @case(1)
                                                <input type="text" class="form-control text-center" value="CONSULTA EXTERNA" readonly>
                                                @break
                                            @case(2)
                                                <input type="text" class="form-control text-center" value="HOSPITALIZACION" readonly>
                                                @break
                                            @case(3)
                                                <input type="text" class="form-control text-center" value="CIRUGIA" readonly>
                                                @break
                                            @default
                                                
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($honorarios)
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('medicos.confirmar-soporte',$soporte) }}" method="POST">
                        @csrf
                        <input type="hidden" name="fechaInicial" value="{{ date("Y-m-d", strtotime($fechaInicial)) }}">
                        <input type="hidden" name="fechaFinal" value="{{ date("Y-m-d", strtotime($fechaFinal)) }}">
                        <input type="hidden" name="nombreMedico" value="{{$nombre}}">
                        <input type="hidden" name="ambito" value="{{$ambito}}">
                        <div class="card" style="height: 40rem">
                            <div class="card-header">
                                <h3 class="text-uppercase"> <strong>RESULTADOS CONSULTA</strong></h3>
                            </div>
                            <div class="card-body mb-5">
                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <div class="card-text">
                                            Medico: {{$nombre}} 
                                        </div>
                                        <div class="card-text">
                                            Honorarios generados entre las fechas.
                                        </div>
                                        <div class="card-text">
                                            {{ date("Y-m-d", strtotime($fechaInicial)).' / '.date("Y-m-d", strtotime($fechaFinal))}}
                                        </div>
                                    </div>
                                    <div class="form-group mr-3 mb-3">
                                        <div class="card-text">
                                            Cantidad: {{count($honorarios)}}
                                        </div>
                                        <div class="card-text">
                                            CxP: $ {{number_format($total,0,",",".")}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="shadow bg-danger mt-5">
                            <input type="hidden" id="numero" value="{{count($honorarios)}}">
                            <div class="card-body table-responsive">
    
                                <table class="table text-center text-uppercase" style="font-size: 14px">
                                    <thead>
                                        <th>Fecha/Hora</th>
                                        <th>Documento Paciente</th>
                                        <th>Nombre Paciente</th>
                                        <th>Servicio</th>
                                        <th>Cantidad</th>
                                        <th>CxP Med</th>
                                        <th>
                                            <input type="checkbox" name="seviciosTodos" id="todos" onchange="seleccionarTodosHonorarios()">
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($honorarios as $key => $honorario)

                                            @php
                                                $honorarioOrden = "honorario".$key;
                                            @endphp
                                            <tr>
                                                <td>{{ $honorario->HORA_MVTO }}</td>
                                                <td>{{ $honorario->NUM_PACIENTE }}</td>
                                                <td>{{ $honorario->NOM_PACIENTE }}</td>
                                                <td>{{ $honorario->SERVICIO }}</td>
                                                <td>{{ $honorario->CT_SER_MVTO}}</td>
                                                @if ($honorario->EST_ATEN=='ATENDIDA' || 
                                                    $honorario->EST_ATEN=='HOSPITALIZADO' || 
                                                        $honorario->EST_ATEN=='CIRUGIA')
                                                    <td>{{number_format($honorario->CXP_MED_MVTO,0,",",".")}}</td>
                                                @else 
                                                    <td> 
                                                        <span class="badge badge-warning"> 0,0  </span>
                                                    </td>
                                                @endif
                                                <td>
                                                    @if ($honorario->EST_ATEN=='ATENDIDA' || 
                                                        $honorario->EST_ATEN=='HOSPITALIZADO' || 
                                                        $honorario->EST_ATEN=='CIRUGIA')
                                                        @if ($soporte->honorarios()->where('ID',$honorario->ID)->first())
                                                            <input type="checkbox" name="honorarios[]" id="{{$honorarioOrden}}" value="{{$honorario->ID}}" checked>
                                                        @else
                                                            <input type="checkbox" name="honorarios[]" id="{{$honorarioOrden}}" value="{{$honorario->ID}}">
                                                        @endif
                                                        
                                                    @else
                                                        <span class="badge badge-danger">{{$honorario->EST_ATEN}}</span>
                                                    @endif
                                                </td>
                                                {{-- <td>{{ $dato->NUM_PACIENTE }}</td>
                                                --}}
                                            </tr>
                                        @endforeach
            
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger btn-lg">ACTUALIZAR REPORTE DE PAGO</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        @endif
    </div>
@endsection
