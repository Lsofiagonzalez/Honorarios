@extends('plantillas.basica')
@extends('componentes.navbar')
@extends('componentes.footer')

@section('TituloPagina', 'Accesos')

@section('content')

<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12" >

                @if(Session::has('success_message'))
                <article class="alert alert-success">
                    {{ Session::get('success_message') }}
                </article>
                @endif
                @if(Session::has('error_message'))
                <article class="alert alert-danger">
                    {{ Session::get('error_message') }} <br>
                </article>
                @endif
                <div class="form-panel">
                    <div>
                        <div class="text-left col-md-6">
                            <h3>
                                <span>
                                    <i class="fa fa-angle-right"></i> 
                                    CREACION DE USUARIOS
                                    <br>
                                </span>
                            </h3>
                        </div>
                        <div class="text-right col-md-6">
                            <h1 style="font-size: 35px;">
                                
                            </h1>
                        </div>
                    </div>                    
                    <div class="form-horizontal style-form">
                        <img style= "margin-left:15%; margin-right:15%" src="http://192.168.2.242/biotic/public/imagenes/LogoHospital.jpg" width="800px" height="200px" align="center"><br>
                        <div class="form-group"><br><br>
                            <h3 style= "margin-left:3%; margin-right:3%" >Ingrese el numero de documento del usuario que desea crear, para realizar la validación 
                                y verificar los sistemas en que se debe crear. </h3>                           
                        </div>
                    </div>
                    <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%"  id="ver" name="ver" method="POST" action="{{ route('usuarios.validar') }}">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <div class="form-group 
                    @if($errors->has('numero_doc'))
                        {{ 'has-error' }}
                    @endif">
                        <label class="col-sm-2 col-sm-2 control-label">Numero de documento del usuario </label> 
                        <div class="col-sm-10">                                   
                            <input class="form-control" type="number" name="numero_doc" id="numero_doc" value=""></input>
                        </div>                       
                    </div>                  
                    <div class="text-center">
                        <button type="submit" class="btn btn-theme04">Validar</button>
                    </div>
                    </form>
                </div><!-- /content-panel --> 
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>
</section>
@stop
