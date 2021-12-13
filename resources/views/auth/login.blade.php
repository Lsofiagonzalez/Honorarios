@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-danger">
                     <h3 class="text-uppercase text-white"> <strong> {{ __('Login ').config('app.name') }}</strong></h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('app.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Usuario GD') }}</label>

                            <div class="col-md-6 mx-auto">
                                {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                                <input id="nombre_usuario" type="text" class="form-control text-center {{ $errors->has('nombre_usuario') ? ' is-invalid' : '' }}" name="nombre_usuario" value="{{ old('nombre_usuario') }}" required autofocus>
                                        @if ($errors->has('nombre_usuario'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre_usuario') }}</strong>
                                            </span>
                                        @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-center">{{ __('Contraseña') }}</label>

                            <div class="col-md-6 mx-auto">
                                <input id="password" type="password" class="form-control  text-center @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-3">
                            <div class="col-md-4 mx-auto">
                                <button type="submit" class="btn btn-danger btn-lg btn-block">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> {{ __('Iniciar Sesión') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
