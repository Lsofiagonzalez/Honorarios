@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br>
                <br>
                <div class="card">
                    <div class="card-header text-uppercase text-center">
                        
                        <h3 class="text-danger">  <strong> MODIFICAR ESTADO </strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mx-auto">
                            <form action="{{route('update')}}" method="post">
                                @csrf
                                <div class="form-group d-flex align-items-center">
                                    <label class="form-control text-uppercase border-info text-center">Nombre del Paciente</label>
                                   
                                    <input name="nom_paciente" class="form-control text-center" value="{{$honorario->NOM_PACIENTE}}" disabled>
                                    <input name="nom_paciente" type="hidden" class="form-control text-center" value="{{$honorario->NOM_PACIENTE}}">
                                    <input name="idHonorario" type="hidden" class="form-control text-center"  value="{{$honorario->ID}}" >
                                
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <label class="form-control text-uppercase border-info text-center">Documento</label>
                                    
                                    <input name="num_paciente" class="form-control text-center" value="{{$honorario->NUM_PACIENTE}}" disabled>
                                    <input name="num_paciente" type="hidden" class="form-control text-center" value="{{$honorario->NUM_PACIENTE}}">              
                                    <input name="medico_honorario" type="hidden" class="form-control text-center" value="{{$honorario->MEDICO}}">        
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <label class="form-control text-uppercase border-info text-center">Estado</label>
                                    <input name="estado_hon" class="form-control text-center" value="{{$honorario->EST_ATEN}}" disabled>                               
                                    <input name="estado_hon" type="hidden" class="form-control text-center" value="{{$honorario->EST_ATEN}}">                               
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <label class="form-control text-uppercase border-info text-center">Estado</label>
                                    <select class="form-control text-uppercase border-info" name="estado" required>
                                        <option value="">-- Seleccionar opción --</option>
                                        <option value="ASISTIDA" style="font-size:13px">ASISTIDA</option>
                                        <option value="EN SALA DE ESPERA" style="font-size:13px">EN SALA DE ESPERA</option>
                                        <option value="ANULADA" style="font-size:13px">ANULADA</option>
                                        <option value="NO ASISTIDA" style="font-size:13px">NO ASISTIDA</option>
                                        <option value="TRASLADADA" style="font-size:13px">TRASLADADA</option>
                                        <option value="RESERVADA" style="font-size:13px">RESERVADA</option>
                                        <option value="AUTORIZADA" style="font-size:13px">AUTORIZADA</option>
                                        <option value="POR AUTORIZAR" style="font-size:13px">POR AUTORIZAR</option>
                                        <option value="RECHAZADA" style="font-size:13px">RECHAZADA</option>
                                        <option value="ATENDIDA" style="font-size:13px">ATENDIDA</option>
                                        <option value="EN CONSULTORIO" style="font-size:13px">EN CONSULTORIO</option>
                                        <option value="NO ATENDIDA" style="font-size:13px">NO ATENDIDA</option>
                                        </select>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <label class="form-control text-uppercase border-info text-center">Observacion</label>
                                    <textarea type="text-block" name="observ" class="form-control" required ></textarea>
                                </div>
                              
                                <div class="d-flex justify-content-center mb-3">
                                    <button class="btn btn-primary btn-block mt-4" type="submit">CAMBIAR ESTADO</button>

                                    <a class="btn btn-primary btn-block mt-4" style="background-color: red" href="javascript: history.go(-1)">VOLVER AL LISTADO</a>
                                </div>    
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script src="{{asset('SGD/js/proceso-editar.js')}}"></script>
@endsection
