@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card" style="height: 40rem">
                    <div class="card-header text-uppercase text-center">
                        <h3> <strong> Soporte De Pago Honorarios Médicos</strong></h3>
                    </div>
                    <div class="card-header text-uppercase text-center">
                        <h4> <strong> {{ $nombreMedico }}</strong></h4>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-body table-responsive">

                        <table class="table text-center text-uppercase" style="font-size: 14px">
                            <thead>
                                <th>Fecha/Hora</th>
                                <th>Documento Paciente</th>
                                <th>Nombre Paciente</th>
                                <th>Servicio</th>
                                <th>Cantidad</th>
                                <th>CxP Med</th>
                            </thead>
                            <tbody>
                                @foreach ($honorarios as $key => $honorario)
                                <tr>
                                        <td>{{ $honorario->HORA_MVTO }}</td>
                                        <td>{{ $honorario->NUM_PACIENTE }}</td>
                                        <td>{{ $honorario->NOM_PACIENTE }}</td>
                                        <td>{{ $honorario->SERVICIO }}</td>
                                        <td>{{ $honorario->CT_SER_MVTO }}</td>
                                        <td>{{number_format($honorario->CXP_MED_MVTO,0,",",".")}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="2">$ {{number_format($total,0,",",".")}}</th>
                                <th></th>
                                
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        
                        <div class="form-group d-flex">
                            <button  class="btn btn-primary mr-2" onclick="history.back(-1)">Volver</button>
                            <a class="btn btn-primary mr-2" href="{{ route('medicos.formulario') }}">Generar Nuevo</a>
                            {{-- <form action="{{ route('medicos.modificar-datos') }}" method="post"
                                onsubmit="desactivarBoton()">
                                @csrf
                                @foreach ($honorarios as $key => $honorario)
                                    <input type="hidden" name="honorariosGenerar[]" value="{{ $honorario->ID }}">
                                @endforeach
                                <input type="hidden" name="nombreMedico" value="{{ $nombreMedico }}">
                                <input type="hidden" name="fechaInicio" value="{{ $fechaInicio }}">
                                <input type="hidden" name="fechaFinal" value="{{ $fechaFinal }}">
                                <input type="hidden" name="ambito" value="{{ $ambito }}">
                                <input type="hidden" name="opcion" value="1">
                                <button type="submit" id="bModificar" class="btn btn-danger mr-2">Modificar Soporte</button>
                            </form> --}}
                            <form action="{{ route('medicos.generar-soporte') }}" method="post"
                                onsubmit="desactivarBoton()">
                                @csrf
                                @foreach ($honorarios as $key => $honorario)
                                    <input type="hidden" name="honorariosGenerar[]" value="{{ $honorario->ID }}">
                                @endforeach 
                                <input type="hidden" name="nombreMedico" value="{{ $nombreMedico }}">
                                <input type="hidden" name="fechaInicio" value="{{ $fechaInicio }}">
                                <input type="hidden" name="fechaFinal" value="{{ $fechaFinal }}">
                                <input type="hidden" name="ambito" value="{{ $ambito }}">
                                <input type="hidden" name="opcion" value="1">
                                <button type="submit" id="bDescargar" class="btn btn-info mr-2">Clausurar y Descargar</button>
                            </form>
                            <form action="{{ route('medicos.generar-soporte') }}" method="post"
                                onsubmit="desactivarBoton()">
                                @csrf
                                @foreach ($honorarios as $key => $honorario)
                                    <input type="hidden" name="honorariosGenerar[]" value="{{ $honorario->ID }}">
                                @endforeach
                                <input type="hidden" name="nombreMedico" value="{{ $nombreMedico }}">
                                <input type="hidden" name="fechaInicio" value="{{ $fechaInicio }}">
                                <input type="hidden" name="fechaFinal" value="{{ $fechaFinal }}">
                                <input type="hidden" name="ambito" value="{{ $ambito }}">
                                <input type="hidden" name="opcion" value="2">
                                <button type="submit" id="bEnviar" class="btn btn-success">Clausurar y Enviar por Correo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
