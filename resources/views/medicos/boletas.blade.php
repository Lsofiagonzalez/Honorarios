@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-uppercase"> <strong>Boletas Generadas</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        FECHA ELABORACIÓN
                                    </th>
                                    <th>
                                        RADICADO
                                    </th>
                                    <th>
                                        ELABORADO POR
                                    </th>
                                    <th>
                                        ARCHIVO
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($boletas as $boleta)
                                        <tr>
                                            <td>{{ $boleta->id }}</td>
                                            <td>{{ $boleta->created_at }}</td>
                                            <td> 
                                                <h3 class="badge badge-success">
                                                    {{ $boleta->radicado }}
                                                </h3> 
                                            </td>
                                            <td>@php
                                                   $usuario = $boleta->autor->usuarioGD; 
                                                @endphp
                                                {{ $usuario->NOMUSU.' '.$usuario->APEUSU }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-info mr-2 btn-sm" href="{{ route('auxiliares.boleta-pdf',$boleta) }}" target="_blank" title="ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('auxiliares.descargar-boleta-pdf',$boleta) }}" target="_blank" title="descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
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