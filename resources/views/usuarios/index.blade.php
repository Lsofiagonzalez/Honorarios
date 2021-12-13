{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}
@section('TituloPagina', 'Usuarios')
@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <section id="main-content">
    <section class="container">
      <div class="row mt">
        <div class="col-12">
            <div class="text-right col-12">
              <h1 style="font-size: 35px;">
                <span>
                  <a href="{{ route('dashboard') }}" class="text-theme03">
                    <i class="fa fa-arrow-circle-left text-right"></i>
                  </a>
                </span>
              </h1>
            </div>
            <hr class="shadow bg-danger">
            <div class="card">
                <div class="card-header">
                   <h3 class="text-uppercase"> <strong>Usuarios del sistema</strong></h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="dataTable">
                      <thead>
                        <th class="text-center"  width= "35%">NOMBRE Y APELLIDO</th>
                        <th class="text-center" width= "35%">CARGO</th>
                        <th class="text-center" width= "20%">ROL</th>
                        <th class="text-center" width= "5%">ESTADO</th>
                        <th class="text-center" width= "5%">EDITAR</th>
                      </thead>
                      <tbody>
                        @foreach($usuarios as $usuario)
                        @if ($usuario->GD_id>0)
                        <tr>
                          <td class="text-center">{{$usuario->NOMUSU.' '.$usuario->APEUSU}}</td>
                          
                            @if ($usuario->cargo)
                                <td class="text-center">{{$usuario->cargo->NOMCAR}}</td>
                            @else
                                <td class="text-center">NO REGISTRADO O INACTIVO</td>
                            @endif
                          <td class="text-center">{{ $usuario->rol->NOMBRE }}</td>
                            @if ($usuario->estado==1)
                                    <td class="text-center">
                                      <span class="badge badge-success">
                                        Activo
                                      </span>
                                    </td>
                                  @else
                                    <td class="text-center">
                                      <span class="badge badge-warning">
                                        Inactivo
                                      </span>
                                    </td>
                                  @endif
                                  <td>
                                    <a href="{{route('usuarios.editar', $usuario->id)}}">
                                      <button class="btn btn-primary btn-xs">
                                        <i class="fas fa-user-edit"></i>
                                      </button>
                                    </a>
                                </td>
                          </tr>
                        @else
                          @php
                              $usu = $usuario->medicoHonorario();
                          @endphp
                          @if ($usu)
                          <tr>
                            <td class="text-center">
                                {{ $usu->NOMBRE }}
                          </td>
                          <td class="text-center">MÉDICO - HONORARARIO</td>
                              <td class="text-center text-uppercase">{{ $usuario->rol->nombre }}</td>
                                @if ($usuario->estado==1)
                                <td class="text-center">
                                  <span class="badge badge-success">
                                    Activo
                                  </span>
                                </td>
                              @else
                                <td class="text-center">
                                  <span class="badge badge-warning">
                                    Inactivo
                                  </span>
                                </td>
                                @endif
                                <td>
                                  <a href="{{route('usuarios.editar', $usuario->id)}}">
                                    <button class="btn btn-primary btn-xs">
                                      <i class="fas fa-user-edit"></i>
                                    </button>
                                  </a>
                                </td>
                            </tr>  
                            @endif
                      @endif
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </section>
      </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
  </div><!-- /row -->
</section>
</section>
@stop
