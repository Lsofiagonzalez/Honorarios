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
                                        <td>{{ $honorario->CT_SER_MVTO}}</td>
                                        <td>{{number_format($honorario->CXP_MED_MVTO,2,",",".")}}</td>
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
                        <a class="btn btn-primary mr-2" href="{{ route('medicos.formulario') }}">Generar Nuevo</a>
                        <a id="bModificar" class="btn btn-danger mr-2" href="{{ url()->previous() }}">Modificar Datos</a>
                        <form action="{{ route('medicos.actualizar-soporte',$soporte) }}" method="post" onsubmit="desactivarBoton()">
                            @csrf
                            <input type="hidden" name="nombreMedico" value="{{$nombreMedico}}">
                            <input type="hidden" name="fechaInicio" value="{{$fechaInicio}}">
                            <input type="hidden" name="fechaFinal" value="{{$fechaFinal}}">
                            <input type="hidden" name="ambito" value="{{$ambito}}">
                            <input type="hidden" name="opcion" value="1">
                            @foreach ($honorarios as $key => $honorario)
                                <input type="hidden" name="honorariosGenerar[]" value="{{$honorario->ID}}">  
                            @endforeach
                            <button type="submit" id="bDescargar" class="btn btn-success mr-2" >Actualizar & Descargar</button>
                        </form>
                        
                        <form action="{{ route('medicos.actualizar-soporte',$soporte) }}" method="post" onsubmit="desactivarBoton()">
                            @csrf
                            <input type="hidden" name="nombreMedico" value="{{$nombreMedico}}">
                            <input type="hidden" name="fechaInicio" value="{{$fechaInicio}}">
                            <input type="hidden" name="fechaFinal" value="{{$fechaFinal}}">
                            <input type="hidden" name="ambito" value="{{$ambito}}">
                            <input type="hidden" name="opcion" value="2">
                            @foreach ($honorarios as $key => $honorario)
                                <input type="hidden" name="honorariosGenerar[]" value="{{$honorario->ID}}">
                            @endforeach
                            <button type="submit" id="bEnviar" class="btn btn-info" >Actualizar & Enviar Por Correo</button>
                        </form>
                    </div>
                </div>
             </div>
         </div>
     </div>
 </div>
@endsection