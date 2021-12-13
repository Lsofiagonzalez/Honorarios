@extends('plantillas.basica')
@extends('componentes.navbar')
@extends('componentes.footer')

@section('TituloPagina', 'Usuarios')

@section('scripts')
  <script src="{{ asset('js/buscar.js')}}"></script>
@stop

@section('estilos')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/logs/index.css')}}">
@stop

@section('content')

  <section id="main-content">
    <section class="wrapper">
      <div class="row mt">
        <div class="col-md-12">
          <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i>Logs</h4>
            <div class="text-right col-12">
              <h1 style="font-size: 35px;">
                <span>
                  <a href="{{ route('dashboard') }}" class="text-theme03">
                    <i class="fa fa-arrow-circle-left text-right"></i>
                  </a>
                </span>
              </h1>
            </div>
            <!--*****************************************************************************************************************************
            Se solicita la busqueda que el usuario desea según los criterios
            *****************************************************************************************************************************-->
            <div class="container">
              <form action="{{ route('logs.buscar') }}" method="POST" style="margin-bottom:20px;">
                <div class="form-group">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="col-12 align-self-start">
                    <div class="form-group">
                      <label>Seleccione por el campo que desea buscar</label>
                      <select class="form-control" name='seleccion'>
                        <option value="1">Nombre de usuario</option>
                        <option value="2">Fecha</option>
                        <option value="3">Tabla</option>
                        <option value="4">Accion</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 align-self-end">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                  </div>
                </div>
              </form>
              <hr>
            </div><!--End container-->
            <!--*****************************************************************************************************************************
            Tabla para mostrar los los segun sea el caso que el usuario solicito
            *****************************************************************************************************************************-->
            <section id="unseen">
              <div class="container">
                <div class="row ">
                  <div class="col-12">
                    <div class="col-12" style="background-color:aqua">
                      <h1 style="font-size: 27px;">
                        <span>
                          <center>LISTADO DE LOGS</center>
                        </span>
                      </h1>
                    </div>
                    <table class="table table-striped table-advance table-hover table-condensed tabla-logs" style="margin-top:3%;">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">Id responsable</th>
                          <th scope="col" class="text-center">Usuario</th>
                          <th scope="col" class="text-center">Tabla</th>
                          <th scope="col" class="text-center">Accion</th>
                          <th scope="col" class="text-center">Creacion</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($mostrarlog as $log)
                          <tr>
                            <td class="text-center">{{ $log->responsable_id }}</td>
                            <td class="text-center">{{ $log->nombre_usuario }}</td>
                            <td class="text-center">{{ $log->nombre_tabla }}</td>
                            <td class="text-center">{{ $log->accion }}</td>
                            <td class="text-center">{{ substr($log->created_at,0,10) }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </section>
            <!--*****************************************************************************************************************************
            Tabla para mostrar los los segun sea el caso que el usuario solicito
            *****************************************************************************************************************************-->
          </div><!-- /content-panel -->
        </div><!-- /col-md-12 -->
      </div><!-- /row -->
    </section>
  </section>
@stop
