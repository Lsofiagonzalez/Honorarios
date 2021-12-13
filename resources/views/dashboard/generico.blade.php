@extends('componentes.navbar')
@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card alert-success">
                <div class="card-header">
                    <h3 class="text-uppercase"> <strong>BIENVENIDO AL MÓDULO DE HONORARIOS</strong> </h3>
                </div>
                <div class="card-body">
                    <span>Hola, en este momento no cuentas con un rol asignado dentro del aplicativo,
                        por favor contacte al área de sistemas para que le sea asignado uno.
                    </span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div>
                        <p>Atentamente,</p>
                        <p>Administrador, {{config('app.name')}}.</p>
                    </div>
                    {{-- <a href="{{ route('dashboard') }}" class="btn btn-success">Volver a la página principal</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection