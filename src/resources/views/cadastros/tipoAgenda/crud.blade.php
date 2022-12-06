{!! Form::open( array('id'=>'frmTipoAgenda', 'action'=>'tipoAgendaController@store') ) !!}
<div class="modal fade" data-backdrop="false" id="crudModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title"></span>
            </div>

            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-5 pr-5 pt-1 pb-3 ml-0">
                        
                <div class="col-md-8">
                <input name="id_trabalho" id="id_trabalho" value="" type="hidden"></input>                
                {!! Form::label("descricao", "Descrição", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("descricao",  null,        ["class"=>"form-control", "maxLength=200", "onkeydown"=>"setFocus(event,'#crudModal #status');" ]) !!}
                </div>

                <div class="col-md-2">
                {!! Form::label("status","Status?",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('status', ['0'=>'Ativo','1'=>'Inativo'], "0", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#crudModal #colorpicker');" ]) !!}
                </div>

                <div class="col-md-2">
                {!! Form::label("colorpicker", "Cor", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::color("colorpicker",  null, ["class"=>"form-control", "style"=>"padding: 0px;", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                </div>

            </div>
            </div>
            
            <div class="modal-footer">
                <span colspan='10' id='erros' style="color: red; font-weight: bold; padding-right: 2rem;"></span>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick="gravarRegistro('#frmTipoAgenda');">Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
