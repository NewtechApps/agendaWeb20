<div class="modal fade" data-backdrop="false" id="modalAgenda">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title"></span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">

                    {!! Form::open( array('id'=>'frmAgenda', 'url'=>'eventos/create') ) !!}
                    {{ csrf_field() }}

                    <div class="form-row col-md-12 pl-0 pr-0">
                        <div class="form-row col-md-7 pl-0 pr-1">

                            <div class="col-md-12">
                            <input name="id_geral"  id="id_geral"  value="" type="hidden"></input>
                            <input name="id_evento" id="id_evento" value="" type="hidden"></input>
                            {!! Form::label("title", "Título/Descrição", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("title",  null,     ["class"=>"form-control", "maxLength=255", "onkeydown"=>"setFocus(event,'#id_usuario');" ]) !!}
                            </div>


                            <div class="col-md-12">
                            {!! Form::label("id_usuario", "Usuário", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("id_usuario", $usuariosCombo, null, ['placeholder'=>'Selecione o Usuário',
                                "class"=>"form-select", "onkeydown"=>"setFocus(event,'#status');" ]) !!}
                            </div>

                            <div class="col-md-5">
                            {!! Form::label("status","Status?",["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select('status', ['1'=>'Confirmado','0'=>'A Confirmar'], "1", ['class'=>'form-select', "onkeydown"=>"setFocus(event,'#tipo_trabalho');" ]) !!}
                            </div>

                            <div class="col-md-7">
                            {!! Form::label("tipo_trabalho", "Tipo de Agenda", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("tipo_trabalho", $tipoAgendaCombo, null, ['placeholder'=>'Selecione o Tipo',
                                "class"=>"form-select", "onkeydown"=>"setFocus(event,'#empresa');" ]) !!}
                            </div>

                            <div class="col-md-5">
                            {!! Form::label("empresa", "Empresa", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("empresa", $empresasCombo, null, ['placeholder'=>'Selecione Empresa',
                                "class"=>"form-select", "onkeydown"=>"setFocus(event,'#tipo_periodo');" ]) !!}
                            </div>


                            <div class="col-md-7">
                            {!! Form::label("tipo_periodo", "Tipo de Período", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("tipo_periodo", ["0"=>"Integral", "1"=>"Part-Time: Manhã", "3"=>"Part-Time: Tarde", "2"=>"Extra"], "0",
                                ["class"=>"form-select fa", "onkeydown"=>"setFocus(event,'#confirm-btn');" ]) !!}
                            <!--label for="tipo_periodo" class="col-form-label pl-0">Tipo Período</label>
                            <select id="tipo_periodo" class="fa fa-solid selectpicker">
                            @foreach (["0"=>["\uf111","Integral"], "1"=>["\uf042","Part-Time: Manhã"], "3"=>["\uf042","Part-Time: Tarde"], "2"=>["\uf06a","Extra"]] as $value=>$label)
                                <option value="{{ $value }}" class="fa fa-solid">{{ json_decode('"'.$label[0].'"') }} &nbsp; {{ $label[1] }}</option>
                            @endforeach
                            </select-->
                            </div>

                            <div class="col-md-7">
                            {!! Form::label("tipo_alocacao", "Tipo de Alocação", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("tipo_alocacao", ["0"=>"Presencial", "1"=>"Remota"], "0",
                                ["class"=>"form-select fa", "onkeydown"=>"setFocus(event,'#confirm-btn');" ]) !!}
                            <!--label for="tipo_alocacao" class="col-form-label pl-0">Tipo Alocação</label>
                            <select id="tipo_alocacao" class="selectpicker fa fa-solid">
                            @foreach (["0"=>["\uf109","Presencial"], "1"=>["\ue4e5","Remota"]] as $value=>$label)
                                <option value="{{ $value }}" class="fa fa-solid">{{ json_decode('"'.$label[0].'"') }} &nbsp;&nbsp; {{ $label[1] }}</option>
                            @endforeach
                            </select-->
                            </div>


                            <div class="col-md-10">
                                {!! Form::label("datas", "Seleção de Datas", ["class"=>"col-form-label pl-0"]) !!}
                                <br>
                                <div class="row pt-1">
                                    <div class="col-md-6">
                                        <label class="radio">
                                            <input type="radio" name="data_selecao" id="radio1" value="2" checked
                                             onChange="selecaoDatas(2);"> Intervalo</input>
                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="radio inline">
                                        <input type="radio" name="data_selecao" id="radio2" value="1"
                                        onChange="selecaoDatas(999);"> Múltiplas Datas</input>
                                        </label>
                                    </div>
                                </div>
                            </div>




                        </div>



                        <div class="form-row col-md-5 pt-0 pr-0">
                            <div class="col-md-12">
                            {!! Form::label("datas", "Datas Selecionadas", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("datas",  null,     ["class"=>"form-control", "readonly"]) !!}
                            </div>
                            <div id="datepicker" class="col-md-12 pt-1"></div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>

            <div class="modal-footer">
                <span colspan='10' id='erros' style="color: red; font-weight: bold; padding-right: 2rem;"></span>
                <button type="button" class="btn btn-sm btn-dark"      id="del-all-btn"  href="#delAll" data-toggle="modal">Excluir Todos</button>
                <button type="button" class="btn btn-sm btn-danger"    id="delete-btn"   href="#delete" data-toggle="modal">Excluir</button>
                <button type="button" class="btn btn-sm btn-secondary" id="cancel-btn"   onClick="fecharAgenda();" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-success"   id="confirm-btn"  onClick="gravarAgenda('#frmAgenda');">Salvar</button>
            </div>
        </div>
    </div>
</div>


