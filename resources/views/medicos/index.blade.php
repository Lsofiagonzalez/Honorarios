@extends('componentes.navbar')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-uppercase"> <strong>Soporte Generados</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center text-uppercase table-striped table-hover" id="dataTable">
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
                                        FECHA INICIO
                                    </th>
                                    <th>
                                        FECHA FINAL
                                    </th>
                                    <th>
                                        TOTAL
                                    </th>
                                    <th>
                                        ARCHIVO
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($soportes as $soporte)
                                        <tr>
                                            <td>{{ $soporte->id }}</td>
                                            <td>{{ $soporte->created_at }}</td>
                                            <td> 
                                                <h3 class="badge badge-success">
                                                    {{ $soporte->radicado }}
                                                </h3> 
                                            </td>
                                            <td>
                                                {{$soporte->fechaInicio }}
                                            </td>
                                            <td>
                                                {{$soporte->fechaFinal }}
                                            </td>
                                            <td>
                                                {{-- @php
                                                   $usuario = $soporte->autor->medicoHonorario(); 
                                                @endphp --}}
                                                $ {{number_format($soporte->total ,2,",",".")}}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-info mr-2 btn-sm" href="{{ route('medicos.soporte-pdf',$soporte) }}" target="_blank" title="ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('medicos.descargar-soporte-pdf',$soporte) }}" target="_blank" title="descargar">
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