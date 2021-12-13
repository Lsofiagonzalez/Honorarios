@extends('componentes.navbar')
@section('content')
 <div class="container">
     <div class="row mt-4">
         <div class="col-12">
             <div class="card" style="height: 40rem">
                 <div class="card-header text-uppercase text-center">
                     <h3> <strong> BOLETA PARA Pago DE Honorarios Médicos</strong></h3>
                 </div>
                 <div class="card-header text-uppercase text-center">
                    <h4> <strong> {{ $nombreMedico }}</strong></h4>
                </div>
                <div class="alert-warning text-center">
                    <p>Por favor verifique que los honorarios seleccionados sean los deseados, recuerde que una vez generada la boleta no se puede modifcar.</p>
                </div>
                <hr class="shadow bg-danger">
                <div class="card-body table-responsive">
                        <table class="table text-center text-uppercase" style="font-size: 14px">
                            <thead>
                                <th>Documento Paciente</th>
                                <th>Nombre Paciente</th>
                                <th>Servicio</th>
                                <th>Fecha/Hora</th>
                                <th>Cantidad</th>
                                {{-- <th>CxP Med</th> --}}
                            </thead>
                            <tbody>
                                @foreach ($honorarios as $key => $honorario)
                                    <tr>
                                        <td>{{ $honorario->NUM_PACIENTE }}</td>
                                        <td>{{ $honorario->NOM_PACIENTE }}</td>
                                        <td>{{ $honorario->SERVICIO }}</td>
                                        <td>{{ $honorario->HORA_MVTO }}</td>
                                        <td>{{ $honorario->CT_SER_MVTO}}</td>
                                        {{-- <td>{{ $honorario->CXP_MED_MVTO }}</td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                {{-- <th></th> --}}
                                <th>{{ $total }}</th>
                            </tfoot>
                        </table>
                </div>
                <div class="card-footer">
                    <div class="form-group d-flex">
                        <a class="btn btn-primary mr-2" href="{{ route('auxiliares.create') }}">Generar Nueva</a>
                        <form action="{{ route('auxiliares.modificar-datos') }}" method="post">
                            @csrf
                            <input type="hidden" name="fechaInicial" value="{{$fechaInicial}}">
                            <input type="hidden" name="medicoConsultar" value="{{$medicoConsultar}}">
                            <input type="hidden" name="ambito" value="{{$ambito}}">
                            @foreach ($honorarios as $key => $honorario)
                                <input type="hidden" name="honorariosVerificar[]" value="{{$honorario->ID}}">
                            @endforeach
                            <input type="hidden" name="nombreMedico" value="{{$nombreMedico}}">
                            <button type="submit" id="bModificar" class="btn btn-danger mr-2" >Modificar Datos</button>
                        </form>
                        <form action="{{ route('auxiliares.generar-boleta') }}" method="post" onsubmit="desactivarBoton()">
                                @csrf
                                <input type="hidden" name="fechaInicio" value="{{$fechaInicial}}">
                                <input type="hidden" name="fechaFinal" value="{{$fechaInicial}}">
                                <input type="hidden" name="ambito" value="{{$ambito}}">
                                @foreach ($honorarios as $key => $honorario)
                                    <input type="hidden" name="honorariosGenerar[]" value="{{$honorario->ID}}">
                                @endforeach
                                <input type="hidden" name="nombreMedico" value="{{$nombreMedico}}">
                                <input type="hidden" name="opcion" value="1">
                                <button type="submit" id="bDescargar" class="btn btn-info mr-2" >Clausurar y Descargar</button>
                        </form>
                        <form action="{{ route('auxiliares.generar-boleta') }}" method="post" onsubmit="desactivarBoton()">
                                @csrf
                                <input type="hidden" name="fechaInicio" value="{{$fechaInicial}}">
                                <input type="hidden" name="fechaFinal" value="{{$fechaInicial}}">
                                <input type="hidden" name="ambito" value="{{$ambito}}">
                                @foreach ($honorarios as $key => $honorario)
                                    <input type="hidden" name="honorariosGenerar[]" value="{{$honorario->ID}}">
                                @endforeach
                                <input type="hidden" name="nombreMedico" value="{{$nombreMedico}}">
                                <input type="hidden" name="opcion" value="2">
                                <button type="submit" id="bEnviar" class="btn btn-success" >Clausurar y Enviar por Correo</button>
                        </form>
                    </div>
                </div>
             </div>
         </div>
     </div>
 </div>
@endsection
