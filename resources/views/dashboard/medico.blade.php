@extends('componentes.navbar')
@section('content')
<div class="container-fluid">
 <h1 class="mt-4">Dashboard</h1>
        <div class="row breadcrumb mb-4 bg-primary">
            <div class="col-md-12 col-xl-12 col-sm-12 d-flex justify-content-between">
                @include('parciales.sistema')
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card bg-dark text-white mb-4" style="height: 11rem">
                        <div class="card-body">Honorarios (Todos)</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="text-white" style="font-size: 50px">
                                <i class="far fa-money-bill-alt"></i>
                            </div>
                            <div class="text-white" style="font-size: 20px">
                                <p>$ {{number_format(Auth::user()->soportes()->sum('total') ,2,",",".")}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card bg-info text-white mb-4" style="height: 11rem">
                <div class="card-body">Soportes Generados (Todos)</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('medicos.listar-soportes') }}">
                        <div class="text-white" style="font-size: 50px">
                            <i class="fas fa-funnel-dollar"></i>
                        </div>
                    </a>
                    <div class="text-white" style="font-size: 25px">
                        <p>{{ count(Auth::user()->soportes) }}</p>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card bg-success text-white mb-4" style="height: 11rem">
                <div class="card-body">Honorarios (Periodo Actual)</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="text-white" style="font-size: 50px">
                        <i class="far fa-money-bill-alt"></i>
                    </div>
                    <div class="text-white" style="font-size: 20px">
                        <p>{{number_format(Auth::user()->soportes()->whereDate('fechaInicio',
                            date("Y-m-d", strtotime($sistema->fechaEvaluada)))->sum('total') ,2,",",".")}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card bg-danger text-white mb-4" style="height: 11rem">
                <div class="card-body">Servicios Facturados (Periodo Actual)</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="text-white" style="font-size: 50px">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <a class="small text-white stretched-link" style="font-size: 25px">
                        {{ Auth::user()->soportes()->whereDate('fechaInicio',
                        date("Y-m-d", strtotime($sistema->fechaEvaluada)))->sum('cantidad')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card bg-warning text-white mb-4" style="height: 11rem">
                <div class="card-body">Servicios Pendientes (Periodo Actual)</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('medicos.listar-soportes') }}">
                        <div class="text-white" style="font-size: 50px">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </a>
                    @php
                        $honorariosPendientes = App\Models\Honorario::where('ESTADO','NO PAGO')
                                                           ->where('COD_MEDICO',Auth::user()->medicoHonorario()->COD_MD_MEDS)
                                                           ->whereBetween('HORA_MVTO',[date("Y-m-d", strtotime($sistema->mesAnterior())),
                                                            date("Y-m-d", strtotime($sistema->fechaLimite()))])
                                                            ->get();
                                                           
                    @endphp
                    <div class="text-white" style="font-size: 25px">
                        <p>{{ count($honorariosPendientes) }}</p>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area mr-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div> --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Servicios Pendientes
        </div>
            <div class="card-body table-responsive">
                <table class="table text-center text-uppercase" id="dataTable" style="font-size: 14px">
                    <thead>
                        <th>Fecha/Hora</th>
                        <th>Documento Paciente</th>
                        <th>Nombre Paciente</th>
                        <th>Servicio</th>
                        <th>Cantidad</th>
                        <th>CxP Med</th>
                        <th>
                            Estado
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($honorariosPendientes as $key => $honorario)

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
                                    @if ($honorario->EST_ATEN=='ATENDIDA')
                                        <span class="badge badge-success">{{$honorario->EST_ATEN}}</span> 
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
    </div>
@endsection