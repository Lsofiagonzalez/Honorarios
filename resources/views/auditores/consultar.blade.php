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
                        <form action="{{ route('auditores.consultar') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center">
                                @include('parciales.sistema')
                                <div class="form-group col-md-8 col-sm-3">
                                    <div class="d-flex">
                                        <div class="text-center col-6">
                                            Seleccione médico
                                            <select name="medicoConsultar" required="required"
                                                class="form-control form-control-sm text-center">
                                                    <option value="">SELECCIONA UN MÉDICO*</option>
                                                @foreach ($medicos as $medico)
                                                    <option @if ($medico->ID_USR==$medicoConsultar)
                                                        {{ 'selected' }}
                                                    @endif
                                                     value="{{ $medico->ID_USR }}">{{ $medico->NOMBRE }}</option>
                                                @endforeach
                                            </select>
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
        @if ($soportes)
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-uppercase"> <strong>Soportes Generados</strong></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-center text-uppercase table-striped table-hover">
                                    <thead>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            FECHA ELABORACIÓN
                                        </th>
                                        <th>
                                            RADICADO
                                        </th>
                                        <th>
                                            FECHA INICIO
                                        </th>
                                        <th>
                                            FECHA FINAL
                                        </th>
                                        <th>
                                            TOTAL
                                        </th>
                                        <th>
                                            ARCHIVO
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($soportes as $soporte)
                                            <tr>
                                                <td>{{ $soporte->id }}</td>
                                                <td>{{ $soporte->created_at }}</td>
                                                <td> 
                                                    <h3 class="badge badge-success">
                                                        {{ $soporte->radicado }}
                                                    </h3> 
                                                </td>
                                                <td>
                                                    {{$soporte->fechaInicio }}
                                                </td>
                                                <td>
                                                    {{$soporte->fechaFinal }}
                                                </td>
                                                <td>
                                                    {{-- @php
                                                    $usuario = $soporte->autor->medicoHonorario(); 
                                                    @endphp --}}
                                                    $ {{number_format($soporte->total ,2,",",".")}}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-info mr-2 btn-sm" href="{{ route('medicos.soporte-pdf',$soporte) }}" target="_blank" title="ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="{{ route('medicos.descargar-soporte-pdf',$soporte) }}" target="_blank" title="descargar">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        @else
            <div class="alert alert-danger mt-5" role="alert">
                El usuario no ha generado el soporte de pago correspondiente a este periodo.
            </div>
        @endif
        @if ($boletas)
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-uppercase"> <strong>Boletas Generadas</strong></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table class="table text-center table-striped" id="dataTable">
                                    <thead>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            FECHA ELABORACIÓN
                                        </th>
                                        <th>
                                            RADICADO
                                        </th>
                                        <th>
                                            ELABORADO POR
                                        </th>
                                        <th>
                                            ARCHIVO
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($boletas as $boleta)
                                            <tr>
                                                <td>{{ $boleta->id }}</td>
                                                <td>{{ $boleta->created_at }}</td>
                                                <td> 
                                                    <h3 class="badge badge-success">
                                                        {{ $boleta->radicado }}
                                                    </h3> 
                                                </td>
                                                <td>
                                                    {{ $boleta->autor->usuarioGD->NOMUSU.' '.$boleta->autor->usuarioGD->APEUSU }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-info mr-2 btn-sm" href="{{ route('auxiliares.boleta-pdf',$boleta) }}" target="_blank" title="ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="{{ route('auxiliares.descargar-boleta-pdf',$boleta) }}" target="_blank" title="descargar">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif  
        @if ($estadoConsulta==1)
            @if ($honorariosSoporteFaltantes)
                @if (count($honorariosSoporteFaltantes)>0)
                    <div class="card alert-danger mt-4" style="height: 25rem">
                        <div class="card-header alert-danger">
                            <h3 class="text-uppercase"> <strong>Honorarios que no tienen boleta asociada</strong></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table text-center text-uppercase table-striped" style="font-size: 14px">
                                <thead>
                                    <th>Documento Paciente</th>
                                    <th>Nombre Paciente</th>
                                    <th>Servicio</th>
                                    <th>Fecha/Hora</th>
                                    <th>Cantidad</th>
                                    <th>CxP Med</th>
                                    <th>
                                        Estado
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($honorariosSoporteFaltantes as $key => $honorario)
                                        <tr>
                                            <td>{{ $honorario->NUM_PACIENTE }}</td>
                                            <td>{{ $honorario->NOM_PACIENTE }}</td>
                                            <td>{{ $honorario->SERVICIO }}</td>
                                            <td>{{ $honorario->HORA_MVTO }}</td>
                                            <td>{{ $honorario->CT_SER_MVTO}}</td>
                                            <td>{{ $honorario->CXP_MED_MVTO }}</td>
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
                @else
                    
                @endif
                
            @endif
            @if ($honorariosBoletaFaltantes)
                @if (count($honorariosBoletaFaltantes)>0)
                    <div class="card alert-danger mt-4" style="height: 20rem">
                        <div class="card-header alert-danger">
                            <h3 class="text-uppercase"> <strong>Honorarios que no tienen soporte de pago asociado</strong></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table text-center text-uppercase" style="font-size: 14px">
                                <thead>
                                    <th>Documento Paciente</th>
                                    <th>Nombre Paciente</th>
                                    <th>Servicio</th>
                                    <th>Fecha/Hora</th>
                                    <th>Cantidad</th>
                                    <th>CxP Med</th>
                                    <th>
                                        Estado
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($honorariosBoletaFaltantes as $key => $honorario)

                                        @php
                                            $honorarioOrden = "honorario".$key;
                                        @endphp
                                        <tr>
                                            <td>{{ $honorario->NUM_PACIENTE }}</td>
                                            <td>{{ $honorario->NOM_PACIENTE }}</td>
                                            <td>{{ $honorario->SERVICIO }}</td>
                                            <td>{{ $honorario->HORA_MVTO }}</td>
                                            <td>{{ $honorario->CT_SER_MVTO}}</td>
                                            <td>{{ $honorario->CXP_MED_MVTO }}</td>
                                            <td>
                                                @if ($honorario->EST_ATEN=='ATENDIDA')
                                                    <span class="badge badge-success">{{$honorario->EST_ATEN}}</span>
                                                @else
                                                    <span class="badge badge-danger">{{$honorario->EST_ATEN}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>  
                @else
                    
                @endif
            @endif
        @endif
    </div>
@endsection