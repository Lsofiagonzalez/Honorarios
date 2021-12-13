@extends('componentes.navbar')
@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row breadcrumb mb-4 bg-primary">
            <div class="col-md-12 col-xl-12 col-sm-12 d-flex justify-content-between">
                @include('parciales.sistema')
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card bg-dark text-white mb-4" >
                        <div class="card-body">Boletas Generadas (Todas)</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('auxiliares.listar-boletas-realizadas') }}">
                                <div class="text-white" style="font-size: 50px">
                                    <i class="fas fa-funnel-dollar"></i>
                                </div>
                            </a>
                            <div class="text-white" style="font-size: 25px">
                                <p>{{ count(Auth::user()->boletasAuxiliar) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4" style="height: 11rem">
                    <div class="card-body">Servicios Facturados (Total)</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="text-white" style="font-size: 50px">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a class="small text-white stretched-link"
                            style="font-size: 25px">{{ Auth::user()->boletasAuxiliar->sum('cantidad') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4" style="height: 11rem">
                    <div class="card-body">Boletas Generadas (Periodo Actual)</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"
                            href="{{ route('auxiliares.listar-boletas-realizadas') }}">
                            <div class="text-white" style="font-size: 50px">
                                <i class="fas fa-funnel-dollar"></i>
                            </div>
                        </a>
                        <div class="text-white" style="font-size: 25px">
                            <p>{{ count(Auth::user()->boletasAuxiliar()
                                                     ->whereBetween('fechaInicio',[
                                                         date("Y-m-d", strtotime($sistema->fechaEvaluada)),
                                                         date("Y-m-d", strtotime($sistema->fechaLimite()))])
                                                     ->get())}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4" style="height: 11rem">
                    <div class="card-body">Servicios Facturados (Periodo Actual)</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="text-white" style="font-size: 50px">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a class="small text-white stretched-link"
                            style="font-size: 25px">{{ Auth::user()->boletasAuxiliar()->whereBetween('fechaInicio',[
                                date("Y-m-d", strtotime($sistema->fechaEvaluada)),
                                date("Y-m-d", strtotime($sistema->fechaLimite()))])->sum('cantidad') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4" style="height: 11rem">
                    <div class="card-body">Servicios Pendientes (Periodo Actual)</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('medicos.listar-soportes') }}">
                            <div class="text-white" style="font-size: 50px">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                        </a>
                        @php
                            $honorariosPendientes = App\Models\Honorario::where('ID_BOLETA', 0)
                                                        ->whereBetween('HORA_MVTO',[
                                                         date("Y-m-d", strtotime($sistema->fechaEvaluada)),
                                                         date("Y-m-d", strtotime($sistema->fechaLimite()))])->get();
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
                <table class="table text-center text-uppercase table-striped" id="dataTable" style="font-size: 12px">
                    <thead>
                        <th>Documento Paciente</th>
                        <th>Nombre Paciente</th>
                        <th>Servicio</th>
                        <th>Fecha/Hora</th>
                        <th>Medico</th>
                        <th>
                            Estado
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($honorariosPendientes as $key => $honorario)

                            @php
                                $honorarioOrden = 'honorario' . $key;
                            @endphp
                            <tr>
                                <td>{{ $honorario->NUM_PACIENTE }}</td>
                                <td>{{ $honorario->NOM_PACIENTE }}</td>
                                <td>{{ $honorario->SERVICIO }}</td>
                                <td>{{ $honorario->HORA_MVTO }}</td>
                                <td>{{ $honorario->MEDICO }}</td>
                                {{-- <td>{{ $honorario->CXP_MED_MVTO }}</td> --}}
                                <td>
                                    @if ($honorario->EST_ATEN == 'ATENDIDA')
                                        <span class="badge badge-success">{{ $honorario->EST_ATEN }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $honorario->EST_ATEN }}</span>
                                    @endif
                                </td>
                                {{-- <td>{{ $dato->NUM_PACIENTE }}</td> --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endsection
