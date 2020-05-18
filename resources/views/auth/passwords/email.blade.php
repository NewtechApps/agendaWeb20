@include('layouts.padraoLogin')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded">
                <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="card-header">Enviar Nova Senha</div>
                    <div class="card-body pb-4">

                        <div class="form-row col-md-12 pl-3 pr-3">
                            <div class="col-md-12">
                            {{ __('Será enviado para o e-mail abaixo, um link para o cadastramento da sua nova senha.') }}
                            </div>

                            <div class="col-md-12 pt-2">
                            {!! Form::text("email", $usuario->email, ["class"=>"form-control pt", "readonly"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-4 offset-md-8 pl-0 pr-0">
                        <button type="submit" class="btn btn-sm btn-secondary" style="width: 100px;">Enviar Senha</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
