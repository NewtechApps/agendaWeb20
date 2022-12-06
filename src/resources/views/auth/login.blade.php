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
<div class="container-fluid" style="margin-top: 19vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded" style="width: 23rem;">
                <form method="POST" action="{{ route('login') }}">
                @csrf

                    <div class="card-header">Acesso / Login</div>
                    <div class="card-body pb-5">

                        <div class="form-row col-md-12 pl-5 pr-5">
                            <div class="col-md-12">
                            {!! Form::label("login","Usuário" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("login", null, ["class"=>"form-control", "autofocus", "onkeydown"=>"setFocus(event,'#password');" ]) !!}
                            
                            @if ($errors->has('login'))
                                <span colspan='12' style="color: red; padding-top: 0.25rem;">
                                {{ $errors->first('login') }}
                                </span>
                            @endif
                            </div>


                            <div class="col-md-12">
                            {!! Form::label("password", "Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password", ["class"=>"form-control", "onkeydown"=>"javascript:if(event.keyCode==13){ form.submit(); };" ]) !!}

                            @if ($errors->has('password'))
                                <span colspan='12' style="color: red; padding-top: 0.25rem;">
                                {{ $errors->first('password') }}
                                </span>
                            @endif
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-12 pl-5 pr-0">
                        <button type="submit" class="btn btn-sm btn-secondary" id="login-btn">Login</button>
                        <a class="btn btn-link" style="text-align: right;" href="{{ route('password.request') }}">{{ __('Esqueceu sua Senha?') }}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
