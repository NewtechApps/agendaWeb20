{!! Form::open( array('id'=>'frm_updEmpresa', 'action'=>'empresaController@update') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="update">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 80vw;">
        <div class="modal-content" role='document'>

            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Alterar Empresa</span>
            </div>
            
            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-4 pr-4 pt-1 pb-3 ml-0">

                <div class="col-md-6">
                <input name="u_id_empresa"  id="u_id_empresa" value="" type="hidden"></input>                
                {!! Form::label("u_razao_social","Razão Social",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_razao_social", null ,["class"=>"form-control", "maxLength=200", "onkeydown"=>"setFocus(event,'#u_nome_fantasia');" ]) !!}
                @if ($errors->has('u_razao_social'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_razao_social') }}
                    </span>
                @endif
                </div>

                <div class="col-md-6">
                {!! Form::label("u_nome_fantasia","Nome Fantasia",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('u_nome_fantasia', null, ["class"=>"form-control", "maxLength=200", "onkeydown"=>"setFocus(event,'#u_tipo_pessoa');" ]) !!}
                @if ($errors->has('u_nome_fantasia'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_nome_fantasia') }}
                    </span>
                @endif
                </div>

                <div class="col-md-2">
                {!! Form::label("u_tipo_pessoa","Tipo Empresa",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('u_tipo_pessoa', ["1"=>"Pessoa Física","2"=>"Pessoa Jurídica"],  null, 
                    ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#u_cpf_cnpj');" ]) !!}
                @if ($errors->has('u_tipo_pessoa'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_tipo_pessoa') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("u_cpf_cnpj","CPF/CNPJ",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_cpf_cnpj",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_endereco');" ]) !!}
                @if ($errors->has('u_cpf_cnpj'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_cpf_cnpj') }}
                    </span>
                @endif
                </div>

                <div class="col-md-7">
                {!! Form::label("u_endereco","Endereço",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_endereco", null, ["class"=>"form-control", "maxLength=100", "onkeydown"=>"setFocus(event,'#u_complemento');" ]) !!}
                @if ($errors->has('u_endereco'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_endereco') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("u_complemento","Complemento",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('u_complemento', null, ["class"=>"form-control", "maxLength=100", "onkeydown"=>"setFocus(event,'#u_estado');" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("u_estado","Estado/UF",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('u_estado', [], null, ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#u_municipio');" ]) !!}
                @if ($errors->has('u_estado'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_estado') }}
                    </span>
                @endif
                </div>

                <div class="col-md-4">
                {!! Form::label("u_municipio","Cidade", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('u_municipio', null, ['class'=>'form-control', "maxLength=30", "onkeydown"=>"setFocus(event,'#u_cep');" ]) !!}
                @if ($errors->has('u_municipio'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_municipio') }}
                    </span>
                @endif
                </div>

                <div class="col-md-2">
                {!! Form::label("u_cep","CEP",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_cep", null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_telefone_fixo');" ]) !!}
                @if ($errors->has('u_cep'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_cep') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("u_telefone_fixo","TelefoneFixo",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_telefone_fixo", null, ["class"=>"form-control", "maxLength=15", "onkeydown"=>"setFocus(event,'#u_telefone_celular');" ]) !!}
                @if ($errors->has('u_telefone_fixo'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_telefone_fixo') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("u_telefone_celular","Telefone Celular",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_telefone_celular" , null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#update-conf-btn');" ]) !!}
                @if ($errors->has('u_telefone_celular'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_telefone_celular') }}
                    </span>
                @endif
                </div>
            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="update-canc-btn" data-dismiss="modal" onclick='javascript:location.reload();'>Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="update-conf-btn" onclick='javascript:$("#frm_updEmpresa").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

