{!! Form::open( array('id'=>'frm_incEmpresa', 'action'=>'empresaController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal-lg"  style="max-width: 80vw;">
        <div class="modal-content" role='document'>

            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir nova Empresa</span>
            </div>

            <div class="modal-body">
            <div class="form-row required border border-dark rounded col-md-12 pl-4 pr-4 pt-1 pb-3 ml-0">

                <div class="col-md-6">
                {!! Form::label("i_razao_social","Razão Social",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_razao_social",  null ,["class"=>"form-control", "maxLength=200", "onkeydown"=>"setFocus(event,'#i_nome_fantasia');" ]) !!}
                @if ($errors->has('i_razao_social'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_razao_social') }}
                    </span>
                @endif
                </div>

                <div class="col-md-6">
                {!! Form::label("i_nome_fantasia","Nome Fantasia",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('i_nome_fantasia',  null, ["class"=>"form-control", "maxLength=200", "onkeydown"=>"setFocus(event,'#i_tipo_pessoa');" ]) !!}
                @if ($errors->has('i_nome_fantasia'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_nome_fantasia') }}
                    </span>
                @endif
                </div>

                <div class="col-md-2">
                {!! Form::label("i_tipo_pessoa","Tipo Empresa",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('i_tipo_pessoa', ["1"=>"Pessoa Física","2"=>"Pessoa Jurídica"],  null, 
                    ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#i_cpf_cnpj');" ]) !!}
                @if ($errors->has('i_tipo_pessoa'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_tipo_pessoa') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("i_cpf_cnpj","CPF/CNPJ",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_cpf_cnpj",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_endereco');" ]) !!}
                @if ($errors->has('i_cpf_cnpj'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_cpf_cnpj') }}
                    </span>
                @endif
                </div>

                <div class="col-md-7">
                {!! Form::label("i_endereco","Endereço",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_endereco", null, ["class"=>"form-control", "maxLength=100", "onkeydown"=>"setFocus(event,'#i_complemento');" ]) !!}
                @if ($errors->has('i_endereco'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_endereco') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("i_complemento","Complemento",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('i_complemento', null, ["class"=>"form-control", "maxLength=100", "onkeydown"=>"setFocus(event,'#i_estado');" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("i_estado","Estado/UF",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('i_estado', [], null, ['placeholder' => 'Selecione o Estado', 
                    'class'=>'form-control', "onkeydown"=>"setFocus(event,'#i_municipio');" ]) !!}
                @if ($errors->has('i_estado'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_estado') }}
                    </span>
                @endif
                </div>

                <div class="col-md-4">
                {!! Form::label("i_municipio","Cidade", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('i_municipio', null, ['class'=>'form-control', "maxLength=30", "onkeydown"=>"setFocus(event,'#i_cep');" ]) !!}
                @if ($errors->has('i_municipio'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_municipio') }}
                    </span>
                @endif
                </div>

                <div class="col-md-2">
                {!! Form::label("i_cep","CEP",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_cep", null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_telefone_fixo');" ]) !!}
                @if ($errors->has('i_cep'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_cep') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("i_telefone_fixo","TelefoneFixo",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_telefone_fixo", null, ["class"=>"form-control", "maxLength=15", "onkeydown"=>"setFocus(event,'#i_telefone_celular');" ]) !!}
                @if ($errors->has('i_telefone_fixo'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_telefone_fixo') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("i_telefone_celular","Telefone Celular",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_telefone_celular" , null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                @if ($errors->has('i_telefone_celular'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_telefone_celular') }}
                    </span>
                @endif
                </div>

            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal" onclick='javascript:location.reload();'>Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incEmpresa").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

