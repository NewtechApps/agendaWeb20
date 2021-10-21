{!! Form::open( array('id'=>'frmUsuario') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="crudModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Alterar Usuário</span>
            </div>

            <div class="modal-body pb-0">
                <div class="form-row border border-dark rounded col-md-12 pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="col-md-6">
                    <input name="id_usuario"  id="id_usuario" value="" type="hidden"></input>                
                    {!! Form::label("nome", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("nome",  null,   ["class"=>"form-control", "autofocus", "onkeydown"=>"setFocus(event,'#crudModal #telefone');" ]) !!}
                    </div>

                    <div class="col-md-2">
                    {!! Form::label("telefone", "Telefone", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("telefone",  null,       ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#crudModal #data_nascimento');" ]) !!}
                    </div>

                    <div class="col-md-2">
                    {!! Form::label("data_nascimento","Data Nasc.", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::date("data_nascimento", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#crudModal #status');" ]) !!}
                    </div>

                    <div class="col-md-2">
                    {!! Form::label("status","Status?",["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select('status', ['0'=>'Ativo','1'=>'Inativo'], "0", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#crudModal #login');" ]) !!}
                    </div>

                    <div class="col-md-2">
                    {!! Form::label("login", "Login", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("login",     null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#crudModal #id_empresa');" ]) !!}
                    </div>

                    <div class="col-md-2">
                    {!! Form::label("id_empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select("id_empresa", $empresasCombo, null, ['placeholder'=>'Selecione a Empresa', 
                        "class"=>"form-control", "onkeydown"=>"setFocus(event,'#crudModal #email');" ]) !!}
                    </div>

                    <div class="col-md-4">
                    {!! Form::label("email", "E-mail Principal", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::email("email",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#crudModal #notificacao_agenda');",
                        "onfocusout"=>"preencherEmail('update');" ]) !!}
                    </div>


                    <div class="col-md-2">
                    {!! Form::label("notificacao_agenda", "Notifica Agenda", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select("notificacao_agenda", ['S'=>'Sim','N'=>'Não'], "S", ["class"=>"form-control", 
                        "onkeydown"=>"setFocus(event,'#crudModal #id_perfil');" ]) !!}
                    </div>


                    <div class="col-md-2">
                    {!! Form::label("id_perfil",  "Perfil", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select("id_perfil", $perfisCombo, null, ['placeholder'=>'Selecione o Perfil', 
                        "class"=>"form-control", "onkeydown"=>"setFocus(event,'#crudModal #id_linha_produto');" ]) !!}
                    </div>

                    <div class="col-md-3">
                    {!! Form::label("id_linha_produto", "Linha de Serviço/Atuação", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select("id_linha_produto", $tipoServicoCombo, null, ['placeholder'=>'Selecione a Linha de Serviço', 
                        "class"=>"form-control", "onkeydown"=>"setFocus(event,'#especialidade');" ]) !!}
                    </div>

                    <div class="col-md-4">
                    {!! Form::label("especialidade", "Especialidade", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("especialidade",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event, '#crudModal #codEstado');" ]) !!}
                    </div>

                    <div class="col-md-2">
                    {!! Form::label("codEstado","UF",["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select('codEstado', $estados->pluck('nome','sigla'), null, 
                        ['placeholder' => 'Selecione o Estado', 'class'=>'form-control',
                        "onchange"=>"buscarCidades('#crudModal #codEstado', '#crudModal #codMunicipio')", 
                        "onkeydown"=>"setFocus(event,'#codMunicipio');" ]) !!}
                    </div>

                    <div class="col-md-3">
                    {!! Form::label("codMunicipio","Cidade",["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::select('codMunicipio', [], null, ['class'=>'form-control', 'placeholder' => 'Selecione a Cidade',
                        "onkeydown"=>"setFocus(event,'#update-conf-btn');" ]) !!}
                    </div>


                </div>  


                <div class="row">
                    <div class="col-md-12 border border-dark rounded pl-0 pr-0 pt-0 pb-0">
                        <table id="empresas" class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Empresa</th>
                                <th>E-mail</th>
                                <th style="width: 80px;">Status</th>
                            </tr>
                            </thead>

                            <tbody>     
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>

            <div class="modal-footer">
                <span colspan='10' id='erros' style="color: red; font-weight: bold; padding-right: 2rem;"></span>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick="salvarUsuario();">Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
