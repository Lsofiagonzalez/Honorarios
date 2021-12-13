<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    {{-- <title>Document</title> --}}
</head>
<body>
    <div class="container-fluid">
        {{-- Encabezado --}}
        <div class="row">
            <div class="col-12">
                <h6 class="text-center text-uppercase">Boleta Control Prestación De Servicios Por Honorarios</h6>
             </div>
        </div>
        <div class="row">
            <div class="col-10" style="font-size: 50%">        
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th style="width: 35%">
                                <img class="card-img-top" src="{{ public_path('img/LogoHospital.jpg') }}"
                                    alt="Logo Hospital">
                            </th>
                            <th style="width: 40%">
                                <img class="card-img-top" src="{{ public_path('img/nit.png') }}" alt="Logo Cruz Roja">
                            </th>
                            <th style="width: 25%">
                                <p class="text-center">{{ $boleta->radicado }}</p>
                                <img class="card-img-top" src="{{ public_path('img/LogoCruzRoja.png') }}"
                                    alt="Logo Cruz Roja">
                            </th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <hr class="shadow bg-danger">
            <table class="table text-uppercase" style="font-size: 50%;">
                <tr>
                    @php
                        $medico = $boleta->receptor();
                    @endphp
                    <td> <strong>Médico:</strong> {{$nombreMedico}}</td>
                    <td> <strong>Correo:</strong>{{$medico->CORREO}} </td>
                </tr>
                <tr>
                    <td> <strong>Teléfono:</strong> {{$medico->TELEFONO}}</td>
                    <td> <strong>Celular:</strong>{{$medico->CELULAR}} </td>
                </tr>
                <tr>
                    <td> <strong>Especialidades:</strong> 
                        <ul>
                            @foreach ($boleta->especialidadesReceptor() as $especialidad)
                                <li>{{$especialidad->NOM_ESP}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td> <strong>Ambito:</strong> {{$boleta->ambito->nombre}}</td>
                </tr>
                <tr>
                    <td> <strong>Fecha Prestación Del Servicio:</strong> {{$boleta->fechaInicio}} </td>
                    <td> <strong>Fecha Elaboración:</strong>{{ date('Y-m-d H:i',strtotime($boleta->created_at))}}</td>
                </tr>
            </table>
        {{-- Servicios facturados --}}
        <hr class="shadow bg-danger">
        <table class="table text-center text-uppercase" style="font-size: 45%;">
            <tr>
                <th style="width: 10%;">Documento Paciente</th>
                <th style="width: 20%;">Nombre Paciente</th>
                <th style="width: 30%;">Servicio</th>
                <th style="width: 10%;">Fecha/Hora</th>
                <th style="width: 10%;">Cantidad</th>
                {{-- <th style="width: 10%;">CxP Med</th> --}}
            </tr>
            <tbody>
                @foreach ($honorarios as $key => $honorario)
                    <tr>
                        <td>{{ $honorario->NUM_PACIENTE }}</td>
                        <td>{{ $honorario->NOM_PACIENTE }}</td>
                        <td>{{ $honorario->SERVICIO }}</td>
                        <td>{{ $honorario->HORA_MVTO }}</td>
                        <td>{{ $honorario->CT_SER_MVTO }}</td>
                        {{-- <td>$ {{number_format($honorario->CXP_MED_MVTO,2,",",".")}}</td> --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                {{-- <th>{{$cantidadTotal}}</th> --}}
                <th>{{ $total }}</th>
            </tfoot>
        </table>
        <table>
            @php
                    $autor = $boleta->autor->usuarioGD;
            @endphp
            <tr>
                <th>
                    Elaborado Por:
                </th>
            </tr>
            <tbody>
                @php
                    $servidor = 'http://192.168.2.56:9053/documental/';
                @endphp
                <tr>
                    <td>
                        <img style="width: 150px" src="{{ asset( $servidor. str_replace("\\", "/", $autor->firmaCorrespondencia) ) }}"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size: 50%;">{{$autor->NOMUSU.' '.$autor->APEUSU}}</p>
                        <p style="font-size: 50%;">{{$autor->cargo->NOMCAR}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
