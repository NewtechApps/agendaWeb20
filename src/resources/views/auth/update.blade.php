@extends('layouts.layoutPadrao')

@section('content')
{!! Form::open( array('id'=>'frm_upd_user', 'action'=>'usuarioController@updateUser') ) !!}
{{ csrf_field() }}
<div class="container-fluid" style="margin-top: 10vh;">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card border border-dark rounded">
   
                <div class="card-header">Perfil de Usuário</div>

                <div class="card-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                    <div class="form-row pl-3 pr-3">

                        <div class="col-md-8">
                        {!! Form::label("nome", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("nome",  old('nome') ?? Auth::user()->nome, ["class"=>"form-control", 
                            "maxLength=200", "onkeydown"=>"setFocus(event,'#telefone');"]) !!}
                        @if ($errors->has('nome'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('nome') }}
                            </span>
                        @endif
                        </div>


                        <div class="col-md-4">
                        {!! Form::label("login", "Login", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("login",  Auth::user()->login, ["class"=>"form-control", "readonly"]) !!}
                        </div>

                        <div class="col-md-12">
                        {!! Form::label("email", "E-mail", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("email",  old('email') ?? Auth::user()->email, ["class"=>"form-control", "readonly"]) !!}
                        </div>


                        <div class="col-md-7">
                        {!! Form::label("telefone", "Telefone", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("telefone", old('telefone') ?? Auth::user()->telefone, ["class"=>"form-control", 
                            "tabIndex"=>'-1', "onkeydown"=>"setFocus(event,'#notificacao_agenda');" ]) !!}
                        @if ($errors->has('telefone'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('telefone') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5">
                        {!! Form::label("notificacao_agenda", "Notifica Agenda", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("notificacao_agenda", ['S'=>'Sim','N'=>'Não'], old('notificacao_agenda') ?? Auth::user()->notificacao_agenda, 
                            ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#senha');" ]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("senha", "Nova Senha", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::password("senha", ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#senhaConfirm');" ]) !!}
                        @if ($errors->has('senha'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('senha') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("senhaConfirm", "Confirmação de Senha", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::password("senhaConfirm", ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                        @if ($errors->has('senhaConfirm'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('senhaConfirm') }}
                            </span>
                        @endif
                        </div>

                    </div>
                </div>
                </div>

               
                <div class="card-footer" style="background-color: white;">
                    <div class="row justify-content-end">
                    <button type="button" class="btn btn-sm btn-secondary mr-1" id="insert-canc-btn" onclick="window.location='{{ url("/home") }}' ">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-secondary"      id="insert-conf-btn" onclick='javascript:$("#frm_upd_user").submit();'>Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<script type='text/javascript'>
$(document).ready(function(){
    $('#telefone').mask('(00) 00000-0000');
    $('#nome').focus();
});
</script>
@endsection