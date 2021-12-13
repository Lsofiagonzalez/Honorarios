@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-uppercase">
                        <h3>Sistema</h3>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-header">Mes Anterior</div>
                            <div class="card-body d-flex align-items-center">
                                <div style="font-size: 50px">
                                    <i class="far fa-calendar-minus"></i>
                                </div>
                                <p class="text-capitalize ml-2">
                                        {{ strftime('%B - %Y', strtotime($sistema->mesAnteriorText())) }}
                                </p>
                            </div> 
                            
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                
                                <form action="{{route('sistema.definir-mes-anterior')}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"> <strong>Retrocer</strong></button>
                                </form>
                            </div>
                        </div>
                        @include('parciales.sistema')
                        <div class="card bg-success text-white mb-4">
                            <div class="card-header">Mes Siguiente</div>
                            <div class="card-body d-flex align-items-center">
                                <div style="font-size: 50px">
                                    <i class="far fa-calendar-plus"></i>
                                </div>
                                <p class="text-capitalize ml-2">
                                        {{ strftime('%B - %Y', strtotime($sistema->mesSiguienteText())) }}
                                </p>
                            </div> 
                            
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                
                                <form action="{{route('sistema.definir-mes-siguiente')}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"> <strong>Adelantar</strong></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group">
                                <form action="{{ route('sistema.definir-dias-habiles') }}" method="post">
                                    @csrf
                                    <input type="number" name="diasHabiles" class="form-control text-center"
                                     value="{{$sistema->diasHabiles}}" min="0" max="31" required>
                                     <button class="btn btn-primary mt-2" type="submit">Definir Días Hábiles</button>
                                </form>
                            </div>
                            <div class="form-group">
                                @if ($sistema->estado == 1)
                                    <form action="{{route('sistema.cerrar')}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"> <strong>Cerrar Sistema</strong> </button>
                                    </form>
                                @else
                                    <form action="{{route('sistema.abrir')}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success"> <strong>Abrir Sistema</strong></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
