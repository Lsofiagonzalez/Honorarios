{{-- @extends('plantillas.basica') --}}
@extends('componentes.navbar')
{{-- @extends('componentes.footer') --}}
@section('TituloPagina', 'lista de chequeo')
@section('content')
  <script>
  function resaltar(e)
  {
    e.style.backgroundColor = "#EDF5FF";
  }
</script>
<section id="main-content">
  <section class="wrapper">
    <div class="row mt">
      <div class="col-md-12" >
        <div class="content-panel">
          <!--*********************************** CONTENIDO DE LA VISTA ***********************************************-->
          <div class="container">
            <div class="text-right col-12">
              <h1 style="font-size: 35px;">
                <span>
                  <a href="{{ route('dashboard') }}" class="text-theme03">
                    <i class="fa fa-arrow-circle-left text-right"></i>
                  </a>
                </span>
              </h1>
            </div>
            <div class="col-sm-12" style="background-color:aqua">
              <h1 style="font-size: 27px;">
                <span>
                  <center>Cargo: {{App\Models\cargo::ncargo($id)->NOMCAR}}</center>
                </span>
              </h1>
            </div>
            <form style= "margin-top:5%;" method="POST" action="{{ route('permisos.guardarmatriz') }}">
              <div class="form-group row">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <input type="hidden" name="idCargo" value="{{$id}}">
                <div class="col-12" style="background-color:aqua; margin-bottom:2%; margin-top:2%">
                  <h1 style="font-size: 20px;">
                    <span>
                      <center>ASIGNAR ALCANCES DEL CARGO</center>
                    </span>
                  </h1>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Dominio</label>
                      <select name="dominio" class="form-control" OnFocus="resaltar(this)" >
                      C:Consulta - R:Registro - I:Impresion - CA:Consulta Auditoria - A:Administrador - ST:Soporte Tecnico - IV:Invitado - N:Ninguno - UG:Usuario Generico
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Correo</label>
                    <select name="correo" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>SGD</label>
                    <select name="SGD" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Terminal Serve</label>
                    <select name="terminalServer" class="form-control" OnFocus="resaltar(this)" >
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Cirugia</label>
                    <select name="cirugia" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Gestion Salud</label>
                    <select name="gestionSalud" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>CCTV</label>
                    <select name="CCTV" class="form-control" OnFocus="resaltar(this)" >
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Accion Social</label>
                    <select name="accionSocial" class="form-control" >
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Intranets</label>
                    <select name="intranets" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Censo Beneficia</label>
                    <select name="censoBeneficia" class="form-control" OnFocus="resaltar(this)" >
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Siimed</label>
                    <select name="siimed" class="form-control" OnFocus="resaltar(this)" >
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Mannto Equipos</label>
                    <select name="manntoEquipos" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Pagina Web</label>
                    <select name="paginaWeb" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Control Vehiculos</label>
                    <select name="controlVehiculos" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Sistemas UNO</label>
                    <select name="sistemasUNO" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>RUAF</label>
                    <select name="RUAF" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>DGH-WINDG</label>
                    <select name="DGHWINDG" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>E-Salud</label>
                    <select name="Esalud" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>K-sar</label>
                    <select name="KSAR" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>SIV</label>
                    <select name="SIV" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Omega</label>
                    <select name="OMEGA" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Q10</label>
                    <select name="Q10" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Isoptimo</label>
                    <select name="isoptimo" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Reportes Atencion</label>
                    <select name="reportesAtencion" class="form-control" OnFocus="resaltar(this)">
                      <option value="">-------------</option>
                      <option value="C">C</option>
                      <option value="C+I">C+I</option>
                      <option value="C+R+I">C+R+I</option>
                      <option value="ST">ST</option>
                      <option value="A">A</option>
                      <option value="IV">IV</option>
                      <option value="N">N</option>
                      <option value="UG">UG</option>
                    </select>
                  </div>
                </div>
                <div class="col-12" style="margin-top:2%;">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
              </div>
            </form>
          </div>
          <!--********************************FIN DE CONTENIDO DE LA VISTA ***********************************************-->
        </div><!-- /col-md-12 -->
      </div><!-- /col-md-12 -->
    </div><!-- /row -->
  </section>
</section>
@stop
