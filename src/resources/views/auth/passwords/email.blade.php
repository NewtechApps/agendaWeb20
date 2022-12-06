@extends('layouts.padraoLogin')


@section('header')
<nav class="navbar navbar-expand-sm sticky-top navbar-dark bg-dark" style="min-height:37px;">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto pl-4">
            <li><span class="linhaMestra" style='color: white;'>Bem-vinda(o) à {{ env('APP_NAME')}}</span></li>                
        </ul>
    </div>
</nav>
@endsection


@section('content')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded">
                <form method="POST" action="{{ route('password.email') }}">
                @csrf

                    <div class="card-header">Recadastramento de Senha</div>
                    <div class="card-body pb-4">

                        <div class="form-row col-md-12 pl-3 pr-3">
                            <div class="col-md-12">
                            {{ __('Será enviado para o e-mail abaixo, um link para o cadastramento da sua nova senha.') }}
                            </div>

                            <div class="col-md-12 pt-2">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-12 pl-3 pr-3">
                        <button type="submit" class="btn btn-sm btn-secondary" style="width: 100px;">Enviar Senha</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
