
@section('content')
  <section id="main-content">
    <section class="wrapper">
      <div class="row mt">
        <div class="col-md-12">

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
                  </span>
                </h3>
              </div>
              <div class="text-right col-md-6">
                <h1 style="font-size: 35px;">
                  <span>
                    <a href="{{ route('usuarios.ver') }}" class="text-theme03"><i class="fa fa-arrow-circle-left text-right"></i></a>
                  </span>
                </h1>
              </div>
            </div>
            <form class="form-horizontal style-form" style= "margin-left:3%; margin-right:3%"  id="continuar" name="continuar" method="POST" action="{{ route('usuarios.cargar') }}">
              <input type="hidden" name="_token" value="{{ Session::token() }}">
              <h3 style= "margin-left:3%; margin-right:3%" >La persona con el documento de identidad ingresado no se encontro
                en los registros de gestión documental, por lo tanto se solicita diligenciar la información de los siguientes
                campos para la creación del usuario.
                <br><br></h3>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">NOMBRE(S):</label>
                  <div class="col-sm-10
                  @if($errors->has('NOMUSU'))
                    {{ 'has-error' }}
                  @endif">
                  @if($errors->has('NOMUSU'))
                    <span class="control-label">
                      {{ $errors->first('NOMUSU') }} <br>
                    </span>
                  @endif
                  <input type="text" class="form-control" name="NOMUSU" value= "{{ old('NOMUSU') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">APELLIDO(S):</label>
                <div class="col-sm-10
                @if($errors->has('APEUSU'))
                  {{ 'has-error' }}
                @endif">
                @if($errors->has('APEUSU'))
                  <span class="control-label">
                    {{ $errors->first('APEUSU') }} <br>
                  </span>
                @endif
                <input type="text" class="form-control" name="APEUSU" value= "{{ old('APEUSU') }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-sm-2 control-label">TIPO DOCUMENTO </label>
              <div class="col-sm-4
              @if($errors->has('TIDUSU'))
                {{ 'has-error' }}
              @endif">
              @if($errors->has('TIDUSU'))
                <span class="control-label">
                  {{ $errors->first('TIDUSU') }} <br>
                </span>
              @endif
              <select class="form-control" name="TIDUSU" id="TIDUSU" aria-controls="dataTable"  >
                <option value=" ">--Selecione un tipo de documento--</option>
                @foreach(\App\Models\Parametro::orderBy('IDPARA')->where('IDTABL','=','3')->get() as $parametro)
                  <?php $auxiliar=$parametro->IDPARA ?>
                  <option value="{{ $parametro->IDPARA }}"
                    {{old('TIDUSU') == $auxiliar ? 'selected': ''}}
                    >{{ $parametro->ABRPAR }}
                  </option>
                @endforeach
              </select>
            </div>
            <label class="col-sm-2 col-sm-2 control-label">N° DOCUMENTO:</label>
            <div class="col-sm-4 @if($errors->has('CEDUSU'))
              {{ 'has-error' }}
            @endif">
            @if($errors->has('CEDUSU'))
              <span class="control-label">
                {{ $errors->first('CEDUSU') }} <br>
              </span>
            @endif
            <input type="number" class="form-control" name="CEDUSU" value= {{ $value }} >
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">GENERO:</label>
          <div class="col-sm-4  @if($errors->has('genero'))
            {{ 'has-error' }}
          @endif">
          @if($errors->has('genero'))
            <span class="control-label">
              {{ $errors->first('genero') }} <br>
            </span>
          @endif
          <select class="form-control" name="genero" id="genero" aria-controls="dataTable"  >
            <option value=" ">--Selecione una opcion--</option>
            @foreach(\App\Models\TipoGeneroKsar::orderBy('id_tipogenero')->get() as $genero)
              <?php $auxiliar=$genero->id_tipogenero ?>
              <option value="{{ $genero->id_tipogenero }}"
                {{old('genero') == $auxiliar ? 'selected': ''}}
                >{{ $genero->nombre_tipogenero }}
              </option>
            @endforeach
          </select>
        </div>
        <label class="col-sm-2 col-sm-2 control-label">RH:</label>
        <div class="col-sm-4
        @if($errors->has('rh'))
          {{ 'has-error' }}
        @endif">
        @if($errors->has('rh'))
          <span class="control-label">
            {{ $errors->first('rh') }} <br>
          </span>
        @endif
        <select class="form-control" name="rh" id="rh" aria-controls="dataTable"  >
          <option value=" ">--Selecione una opcion--</option>
          @foreach(\App\Models\Voluntariadorh::orderBy('rh_id')->get() as $rh)
            <?php $auxiliar=$rh->rh_id ?>
            <option value="{{ $rh->rh_id }}"
              {{old('rh') == $auxiliar ? 'selected': ''}}
              >{{ $rh->rh_tipo }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label">IDIOMA:</label>
      <div class="col-sm-4
      @if($errors->has('idioma'))
        {{ 'has-error' }}
      @endif">
      @if($errors->has('idioma'))
        <span class="control-label">
          {{ $errors->first('idioma') }} <br>
        </span>
      @endif
      <select class="form-control" name="idioma" id="idioma" aria-controls="dataTable"  >
        <option value=" ">--Selecione una opcion--</option>
        @foreach(\App\Models\TipoIdiomaKsar::orderBy('id_idioma')->get() as $idioma)
          <?php $auxiliar=$idioma->id_idioma ?>
          <option value="{{ $idioma->id_idioma }}"
            {{old('idioma') == $auxiliar ? 'selected': ''}}
            >{{ $idioma->nombre_idioma }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 col-sm-2 control-label">SECCIONAL:</label>
    <div class="col-sm-4
    @if($errors->has('seccional'))
      {{ 'has-error' }}
    @endif">
    @if($errors->has('seccional'))
      <span class="control-label">
        {{ $errors->first('seccional') }} <br>
      </span>
    @endif
    <select class="form-control" name="seccional" id="seccional" aria-controls="dataTable"  >
      <option value=" ">--Selecione una opcion--</option>
      @foreach(\App\Models\SeccionalKsar::orderBy('id_seccional')->get() as $seccional)
        <?php $auxiliar=$seccional->id_seccional ?>
        <option value="{{ $seccional->id_seccional }}"
          {{old('seccional') == $auxiliar ? 'selected': ''}}
          >{{ $seccional->nombre_seccional }}
        </option>
      @endforeach
    </select>
  </div>
  <label class="col-sm-2 col-sm-2 control-label">N° CARNET:</label>
  <div class="col-sm-4
  @if($errors->has('num_carnet'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('num_carnet'))
    <span class="control-label">
      {{ $errors->first('num_carnet') }} <br>
    </span>
  @endif
  <input type="text" class="form-control" name="num_carnet" id="num_carnet" value= "{{ old('num_carnet') }}">
</div>
</div>

<div class="form-group">
  <label class="col-sm-2 col-sm-2 control-label">CIUDAD:</label>
  <div class="col-sm-4
  @if($errors->has('ciudad'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('ciudad'))
    <span class="control-label">
      {{ $errors->first('ciudad') }} <br>
    </span>
  @endif
  <select class="form-control" name="ciudad" id="ciudad" aria-controls="dataTable"  >
    <option value=" ">--Selecione una ciudad--</option>
    @foreach(\App\Models\CiudadKsar::orderBy('nombre_ciudad')->get() as $ciudad)
      <?php $auxiliar=$ciudad->id_ciudad ?>
      <option value="{{ $ciudad->id_ciudad }}"
        {{old('ciudad') == $auxiliar ? 'selected': ''}}
        >{{ $ciudad->nombre_ciudad }}
      </option>
    @endforeach
  </select>
</div>
<label class="col-sm-2 col-sm-2 control-label">BARRIO:</label>
<div class="col-sm-4 @if($errors->has('barrio'))
  {{ 'has-error' }}
@endif">
@if($errors->has('barrio'))
  <span class="control-label">
    {{ $errors->first('barrio') }} <br>
  </span>
@endif
<input type="text" class="form-control" name="barrio" id="barrio" value= "{{ old('barrio') }}">
</div>
</div>
<div class="form-group">
  <label class="col-sm-2 col-sm-2 control-label">DIRECCIÓN:</label>
  <div class="col-sm-10
  @if($errors->has('direccion'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('direccion'))
    <span class="control-label">
      {{ $errors->first('direccion') }} <br>
    </span>
  @endif
  <input type="text" class="form-control" name="direccion" id="direccion" value= "{{ old('direccion') }}">
</div>
</div>
<div class="form-group">
  <label class="col-sm-2 col-sm-2 control-label">NUMERO CELULAR:</label>
  <div class="col-sm-4 @if($errors->has('celular'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('celular'))
    <span class="control-label">
      {{ $errors->first('celular') }} <br>
    </span>
  @endif
  <input type="number" class="form-control" name="celular" id="celular" value= "{{ old('celular') }}">
</div>
<label class="col-sm-2 col-sm-2 control-label">CORREO:</label>
<div class="col-sm-4 @if($errors->has('CORUSU'))
  {{ 'has-error' }}
@endif">
@if($errors->has('CORUSU'))
  <span class="control-label">
    {{ $errors->first('CORUSU') }} <br>
  </span>
@endif
<input type="text" class="form-control" name="CORUSU" id="CORUSU"value= "{{ old('CORUSU') }}">
</div>
</div>
<div class="form-group ">
  <label class="col-sm-2 col-sm-2 control-label">FECHA DE NACIMIENTO</label>
  <div class="col-sm-4 @if($errors->has('fechaNacimiento'))
    {{ 'has-error' }}
  @endif ">
  @if($errors->has('fechaNacimiento'))
    <span class="control-label">
      {{ $errors->first('fechaNacimiento') }} <br>
    </span>
  @endif
  <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="{{ old('fechaNacimiento') }}">
</div>
<label class="col-sm-2 col-sm-2 control-label">CARGO</label>
<div class="col-sm-4 @if($errors->has('IDCARG')) {{ 'has-error' }}
@endif">
@if($errors->has('IDCARG'))
  <span class="control-label">
    {{ $errors->first('IDCARG') }} <br>
  </span>
@endif
<select class="form-control" name="IDCARG" id="IDCARG">
  <option value=" ">--Selecione un cargo de la lista--</option>
  @foreach(\App\Models\cargo::orderBy('NOMCAR')->where('ESTADO','=',1)->get() as $cargo)
    <?php $auxiliar1=$cargo->IDCARG ?>
    <option value="{{ $cargo->IDCARG }}"
      {{old('IDCARG') == $auxiliar1 ? 'selected': ''}}
      >{{$cargo->NOMCAR}}
    </option>
  @endforeach
</select>
</div>
</div>
<div class="form-group">
  <label class="col-sm-2 col-sm-2 control-label">USUARIO:</label>
  <div class="col-sm-4 @if($errors->has('LOGUSU'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('LOGUSU'))
    <span class="control-label">
      {{ $errors->first('LOGUSU') }} <br>
    </span>
  @endif
  <input type="text" class="form-control" name="LOGUSU" id="LOGUSU" value="{{ old('LOGUSU') }}">
</div>
<label class="col-sm-2 col-sm-2 control-label">CONTRASEÑA</label>
<div class="col-sm-4 @if($errors->has('PASUSU'))
  {{ 'has-error' }}
@endif">
@if($errors->has('PASUSU'))
  <span class="control-label">
    {{ $errors->first('PASUSU') }} <br>
  </span>
@endif
<input type="password" class="form-control" name="PASUSU" id="PASUSU" value= "{{ old('PASUSU') }}">
</div>
</div>
<div class="form-group ">
  <label class="col-sm-2 col-sm-2 control-label">VIGENCIA CONTRASEÑA:</label>
  <div class="col-sm-4  @if($errors->has('DIAVIG'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('DIAVIG'))
    <span class="control-label">
      {{ $errors->first('DIAVIG') }} <br>
    </span>
  @endif
  <input type="number" class="form-control" name="DIAVIG"  id="DIAVIG" value="{{ old('DIAVIG') }}" >
</div>
<label class="col-sm-2 col-sm-2 control-label">AVISO VENCIMIENTO CONTRASEÑA</label>
<div class="col-sm-4 @if($errors->has('DAIAVI'))
  {{ 'has-error' }}
@endif">
@if($errors->has('DAIAVI'))
  <span class="control-label">
    {{ $errors->first('DAIAVI') }} <br>
  </span>
@endif
<input type="number" class="form-control" name="DAIAVI" id="DAIAVI" value="{{ old('DAIAVI') }}" >
</div>
</div>
<div class="form-group ">
  <label class="col-sm-2 col-sm-2 control-label">ESTADO:</label>
  <div class="col-sm-4">
    <h4>
      <span class="badge badge-success">
        Activo
      </span>
    </h4>
  </div>
  <label class="col-sm-2 col-sm-2 control-label">ROL BIOTIC</label>
  <div class="col-sm-4 @if($errors->has('rol_id'))
    {{ 'has-error' }}
  @endif">
  @if($errors->has('rol_id'))
    <span class="control-label">
      {{ $errors->first('rol_id') }} <br>
    </span>
  @endif
  <select class="form-control" name="rol_id" id="rol_id">
    <option value=" ">--Selecione un rol de la lista--</option>
    @foreach(\App\Models\Rol::where('estado', '=', 1)->get() as $rol)
      <?php $auxiliar2=$rol->id ?>
      <option value="{{$rol->id}}"
        {{old('rol_id') == $auxiliar2 ? 'selected': ''}}
        >{{$rol->nombre}}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="form-group">
  <div class="col-md-6">
    <div class="adjunto"  id="adjunto">
      <label for="adjuntar archivo">Foto de perfil</label>
      <input type='file' name='archivo[]' id='archivo' multiple=''>
    </div>
  </div>
</div> 
<div class="text-center">
  <button type="submit" class="btn btn-theme04">Continuar</button>
</div>
</form>
</div><!-- /content-panel -->

</div><!-- /col-md-12 -->
</div><!-- /row -->
</section>
</section>

@stop
