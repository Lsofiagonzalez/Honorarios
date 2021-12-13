<?php use App\Models\DetalleHonorarioCambio;?>
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
                        <form action="{{ route('auxiliares.consultar') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center justify-content-between">
                                @include('parciales.sistema')
                                 <div class="col-8">
                                    <div class="form-group">
                                    @php
                                        $sistema = App\Models\Sistema::findOrFail(1);
                                    @endphp
                                        <div class="d-flex">
                                            <div class="text-center col-6">
                                                Fecha inicial
                                                <input class="form-control" data-format="YYYY-mm-dd" type="date"
                                                    name="fechaInicial" required min="{{ $sistema->fechaEvaluada }}"
                                                    max="{{ $sistema->fechaLimiteConDiasHabilesText()}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mt-2">
                                            <div class="text-center col-6">
                                                Seleccione médico
                                                <select name="medicoConsultar" required="required"
                                                    class="form-control form-control-sm text-center">
                                                        <option value="" selected="selected">SELECCIONA UN MÉDICO*</option>
                                                    @foreach ($medicos as $medico)
                                                        <option value="{{ $medico->ID_USR }}">{{ $medico->NOMBRE }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-center col-6">
                                                Seleccione ambito
                                                <select name="ambito" required
                                                    class="form-control form-control-sm text-center">
                                                    <option value="" selected="selected">SELECCIONA UN ÁMBITO*</option>
                                                    @foreach ($ambitos as $item)
                                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="text-center">
                                <button class="btn btn-primary mt-3" type="submit">Consultar</button>
                                <button type="reset" class="btn btn-secondary mt-3">Limpiar Campos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('parciales.session-status') --}}
        @if ($honorarios)
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('auxiliares.visualizar-boleta') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nombreMedico" value="{{$nombre}}">
                        <input type="hidden" name="ambito" value="{{$ambito}}">
                        <input type="hidden" name="fechaInicial" value="{{$fechaInicial}}">
                        <input type="hidden" name="medicoConsultar" value="{{$medicoConsultar}}">
                        <div class="card" style="height: 40rem">
                            <div class="card-header">
                                <h3 class="text-uppercase"> <strong>RESULTADOS CONSULTA <?php echo $estadoConsulta; ?></strong></h3>
                            </div>
                            <div class="card-body mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <div class="card-text">
                                            Medico: {{$nombre}}
                                        </div>
                                        <div class="card-text">
                                            Honorarios generados entre las fechas.
                                        </div>
                                        <div class="card-text">
                                            {{ date("Y-m-d", strtotime($fechaInicial))}}
                                        </div>
                                    </div>
                                    <div class="form-group mr-3">
                                        <div class="card-text">
                                            Cantidad: {{count($honorarios)}}
                                        </div>
                                        {{-- <div class="card-text">
                                            CxP (%): {{$total}}
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <hr class="shadow-4 bg-danger mt-2">
                            <input type="hidden" id="numero" value="{{count($honorarios)}}">
                            <div class="card-body table-responsive">
                                <table class="table text-center text-uppercase table-hover" style="font-size: 14px">
                                    <thead>
                                        <th>Fecha/Hora</th>
                                        <th>Documento Paciente</th>
                                        <th>Nombre Paciente</th>
                                        <th>Servicio</th>
                                        <th>Cantidad</th>
                                        {{-- <th>CxP Med</th> --}}
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
                            
                                                {{-- <td>{{number_format($honorario->CXP_MED_MVTO,2,",",".")}}</td> --}}
                                                <td>
                                                        
                                                        @if ($honorario->EST_ATEN=='ATENDIDA' || 
                                                            $honorario->EST_ATEN=='HOSPITALIZADO' || 
                                                            $honorario->EST_ATEN=='CIRUGIA')
                                                        @if (in_array($honorario->ID,$idsTemp))

                                                            <input  checked type="checkbox" name="honorarios[]" id="{{$honorarioOrden}}" value="{{$honorario->ID}}">
                                                        @else
                                                            <input type="checkbox" name="honorarios[]" id="{{$honorarioOrden}}" value="{{$honorario->ID}}">
                                                        @endif
                                                    @else
                                                    <?php $estadoConsulta = DetalleHonorarioCambio::consultarDetalleHonorario($honorario->ID); ?>
                                                        @if($estadoConsulta)
                                                             <input type="checkbox" name="honorarios[]" id="{{$honorarioOrden}}" value="{{$honorario->ID}}">
                                                        @else
                                                            <div class="d-flex justify-content-center">
                                                            <a href="{{route('editar-estado',[$honorario])}}"><button class="btn btn-danger" type="button"><i class="fa fa-pen"></i></button></a>
                                                            </div>  
                                                            <span class="badge badge-danger">{{$honorario->EST_ATEN}}</span>
                                                        @endif 
                                                </div>                                                       
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div class="form-group">
                                    <div class="card-text">
                                       Cantidad de Horas: {{$horas}}
                                    </div>
                                    <div class="card-text">
                                        Valor por Hora: {{$valorHora}}
                                    </div>
                                </div> --}}
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger btn-lg">GENERAR BOLETA DE PAGO</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        @endif
    </div>
    
    <script src="../../sweetalert/7.1.2/sweetalert2.all.js"></script> 

@endsection
