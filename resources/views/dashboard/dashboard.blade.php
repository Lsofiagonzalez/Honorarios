@extends('componentes.navbar')
@section('content')
<div class="container-fluid">
 <h1 class="mt-4">Dashboard</h1>
 <div class="row breadcrumb mb-4 bg-primary">
    <div class="col-md-12 col-xl-12 col-sm-12 d-flex justify-content-between">
        @include('parciales.sistema')
        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="card bg-dark text-white mb-4" >
                <div class="card-body">Registro De Actividades (Todas)</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"
                        href="{{ route('auxiliares.listar-boletas-realizadas') }}">
                        <div class="text-white" style="font-size: 50px">
                            <i class="fas fa-sort-amount-up-alt mr-2"></i>
                        </div>
                    </a>
                    <div class="text-white" style="font-size: 25px">
                        <p>{{ count(App\Models\LogActividad::get()) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4" style="height: 11rem">
                <div class="card-body">Actividad (Periodo Actual)</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"
                        href="{{ route('auxiliares.listar-boletas-realizadas') }}">
                        <div class="text-white" style="font-size: 50px">
                            <i class="fas fa-funnel-dollar"></i>
                        </div>
                    </a>
                     <div class="text-white" style="font-size: 25px">
                        {{-- <p>{{ count(App\Models\LogActividad::whereBetween('created_at',[
                                                     date("Y-d-m", strtotime($sistema->fechaEvaluada)),
                                                     date("Y-d-m", strtotime($sistema->fechaLimite()))])
                                                     ->get())}}
                        </p> --}}
                    </div> 
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div> --}}
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
            Logs De Actividad
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @php
                    $actividades = App\Models\LogActividad::latest()->get();
                @endphp
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                       <th>ID</th>
                       <th>Fecha</th>
                       <th>Actividad</th>
                       <th>Usuario</th>
                   </thead>
                   <tbody>
                       @foreach ($actividades as $actividad)
                           <tr>
                               <td>{{$actividad->id}}</td>
                               <td>{{$actividad->created_at}}</td>
                               <td>{{$actividad->actividad}}</td>
                               @php
                                   $usuario = $actividad->usuario;
                               @endphp
                               @if ($usuario->GD_id>0)
                                   <td>
                                       {{$usuario->usuarioGD->NOMUSU.' '.$usuario->usuarioGD->APEUSU}}
                                   </td>
                               @else
                                <td>
                                    {{$usuario->medicoHonorario()->NOMBRE}}
                                </td>
                               @endif
                              
                           </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection