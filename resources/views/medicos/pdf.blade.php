<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    {{-- <title>Document</title> --}}
    <style>
		.page-break {
		    page-break-after: always;
		}
	</style>
</head>
<body>
    <div class="container-fluid">
    <header>
        {{-- Encabezado --}}
        <div class="row">
            <div class="col-12">
                <h6 class="text-center text-uppercase">Soporte De Pago Prestación De Servicios Por Honorarios</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-10">
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
                                <p class="text-center">{{ $radicado }}</p>
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
                    $medico = $soporte->autor->medicoHonorario();
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
                        @foreach ($soporte->autor->especialidades() as $especialidad)
                            <li>{{$especialidad->NOM_ESP}}</li>
                        @endforeach
                    </ul>
                </td>
                <td> <strong>Ambito:</strong> {{$soporte->ambito->nombre}}</td>
            </tr>
            <tr>
                <td> <strong>Fecha Prestación Del Servicio:</strong> {{$soporte->fechaInicio}} /{{$soporte->fechaFinal}} </td>
                <td> <strong>Fecha Elaboración:</strong>{{ date('Y-m-d H:i',strtotime($soporte->created_at))}}</td>
            </tr>
        </table>
        <hr class="shadow bg-danger">
    </header>
    <main>
        <table class="table text-center text-uppercase" style="font-size: 50%;">
            <tr>
                <th style="width: 10%;">Fecha/Hora</th>
                <th style="width: 10%;">Documento Paciente</th>
                <th style="width: 20%;">Nombre Paciente</th>
                <th style="width: 30%;">Servicio</th>
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 10%;">CxP Med</th>
            </tr>
            <tbody>
                @foreach ($honorarios as $key => $honorario)
                    <tr>
                        <td>{{ $honorario->HORA_MVTO }}</td>
                        <td>{{ $honorario->NUM_PACIENTE }}</td>
                        <td>{{ $honorario->NOM_PACIENTE }}</td>
                        <td>{{ $honorario->SERVICIO }}</td>
                        <td>{{ $honorario->CT_SER_MVTO }}</td>
                        <td>$ {{number_format($honorario->CXP_MED_MVTO,2,",",".")}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{$cantidadTotal}}</th>
                <th>$ {{ number_format($total,2,",",".") }}</th>
            </tfoot>
        </table>
    </main>
    <footer>
        <div class="page-break"></div>
        <div class="row">
            <div class="col-12">
                <span class="text-center" style="font-size: 50%">
                    Generado en {{ config('app.name')  }} por {{ Auth::user()->nombre_usuario }} el día {{date('d-m-Y')}}
                </span>
            </div>
        </div>
    </footer>    
    </div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 780, "$PAGE_NUM", $font, 10);
            ');
        }
    </script>
</body>
</html>
