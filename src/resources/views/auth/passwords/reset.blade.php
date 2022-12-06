@include('layouts.padraoLogin')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded">
                <form method="POST" action="{{ route('password.update') }}">
                @csrf

                    <div class="card-header">{{ __('Recadastrar Senha') }}</div>
                    <div class="card-body pb-4">

                        <div class="form-row col-md-12 pl-5 pr-5">

                            <div class="col-md-12">
                            <input type="hidden" name="token" value="{{ $token }}">
                            {!! Form::label("email","E-Mail" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::email("email", "$email", ["class"=>"form-control", "readonly" ]) !!}
                            </div>

                            <div class="col-md-12">
                            {!! Form::label("password", "Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password", ["class"=>"form-control",  "required",  "autofocus", "onkeydown"=>"setFocus(event,'#password-confirm');" ]) !!}
                            </div>

                            <div class="col-md-12">
                            {!! Form::label("password-confirm", "Confirmação de Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password-confirm", ["class"=>"form-control", "required", "onkeydown"=>"javascript:if(event.keyCode==13){ form.submit(); };" ]) !!}
                            </div>

                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="col-md-12 pl-5 pr-5">
                        <button type="submit" class="btn btn-sm btn-secondary" style="width: 100px;">Recadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
