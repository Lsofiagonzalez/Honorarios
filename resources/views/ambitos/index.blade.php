@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-uppercase"> <strong>Ámbitos</strong> </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-uppercase text-center">
                                <thead>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        Opción
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($ambitos as $ambito)
                                        <tr>
                                            <td>{{ $ambito->id }}</td>
                                            <td>{{ $ambito->nombre }}</td>
                                            @if ($ambito->estado==1)
                                                <td>
                                                   <h3 class="badge badge-success">Activo</h3> 
                                                </td>
                                            @else
                                                <td>
                                                    <h3 class="badge badge-danger">Inactivo</h3> 
                                                </td>
                                            @endif
                                            <td>
                                                <form action="{{ route('ambito.cambiar-estado',$ambito) }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-warning" type="submit" title="cambiar estado">
                                                        <i class="fas fa-redo-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection