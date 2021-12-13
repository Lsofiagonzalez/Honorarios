@extends('plantillas.basica')
@extends('componentes.navbar')
@extends('componentes.footer')

@section('TituloPagina', 'Usuarios')

@extends('usuarios.content')
@section('scripts')
    <script src="{{ asset('js/buscar.js')}}"></script>
@stop
@section('accion', 'Crear')