@extends('componentes.navbar')
@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card alert-danger">
                <div class="card-header">
                    <h3 class="text-uppercase"> <strong>Error</strong> </h3>
                </div>
                <div class="card-body">
                    <h4>Hola, parece que no tienes los permisos adecuados para utilizar este recurso, 
                        si necesitas esta funcionalidad para desempeñar tu trabajo puedes comunicarte con el área de sistemas.
                    </h4>
                   
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div>
                        <p>Atentamente,</p>
                        <p>Administrador, {{config('app.name')}}.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-danger">Volver a la página principal</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection