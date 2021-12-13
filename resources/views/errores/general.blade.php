{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')

@section('TituloPagina', 'Error')


@section('content')

<section id="main-content">
  <section class="wrapper">

	  <div id="login-page">
	  	<div class="container">
	  	
		    <form class="form-login" action="">
            <h2 class="form-login-heading bg-danger">ERROR {{ $codigo }}</h2>
            
		        <div class="login-wrap text-center">
              <div class="text-center align-middle mt-2 mb-3">
                  <!--<img class="m-2" width="80%" src="{{ asset( 'img/LogoCruz.png') }}"/>-->
              </div>
              <p>
              {{ $mensaje }}
              <br>
              <br>
              Gracias por tu comprensión.
              <br>
              <br>
              </p>

              <a href="{{ route('dashboard') }}" class="btn btn-danger">Volver a la página principal</a>

              <br>
              <br>
		        </div>		
		      </form>	  	
	  	
	  	</div>
    </div>
    
  </div>
</div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="{{ asset( 'jquery/3.2.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset( 'popper/1.12.3/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset( 'bootstrap/4.0.0-beta-2/js/bootstrap.min.js') }}"></script>  
    <!--<script type="text/javascript" src="{{ asset( 'scripts/general.js') }}"></script>  -->
    
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="{{ asset( 'jquery/plugin/jquery.backstretch.min.js') }}"></script>
    <script>
        $.backstretch("{{ asset('img/fondoCruzRoja.jpg') }}", {speed: 500});
    </script>
@stop
