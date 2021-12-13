{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
@extends('componentes.footer')

@section('TituloPagina', 'Usuarios')

@section('content')
    <div class="container  mx-auto">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="text-uppercase">Editar Rol Usuario</h3>
                            <span>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-primary btn-lg">
                                <i class="fa fa-arrow-circle-left text-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('usuarios.actualizar-rol',$usuario)}}" method="post">
                            @csrf
                            @if ($usuario->GD_id > 0)
                                @php
                                    $user =  $usuario->usuarioGD;
                                @endphp
                                <div class="form-group col-md-12">
                                    <label>Nombre: </label>
                                    <input class="form-control" type="text" name="nombre"
                                    value="{{ $user->NOMUSU.' '.$user->APEUSU}}" readonly>
                                </div>
                                <div class="form-group col-md-12 ">
                                    <label>Cargo: </label>
                                    <input class="form-control" type="text" name="cargo" 
                                    value="{{$user->cargo->NOMCAR}}" readonly>
                                </div>
                            @else
                                @php
                                    $user =  $usuario->medicoHonorario();
                                @endphp
                                <div class="form-group col-md-12">
                                    <label>Nombre: </label>
                                    <input class="form-control" type="text" name="nombre" 
                                     value="{{$user->NOMBRE}}" readonly>
                                </div>
                                <div class="form-group col-md-12 ">
                                    <label>Cargo: </label>
                                    <input class="form-control" type="text" name="cargo" 
                                    value="MÉDICO HONORARIO"readonly>
                                </div>
                            @endif

                            <div class="form-group col-md-12">
                                <label> Rol:</label>
                                <select class="form-control text-uppercase" name="rol_id" id="">
                                    @php
                                        $roles = App\Models\Rol::get();
                                    @endphp
                                    @foreach ($roles as $rol)
                                        <option @if ($usuario->rol_id==$rol->id)
                                            {{'selected'}}
                                        @endif value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
