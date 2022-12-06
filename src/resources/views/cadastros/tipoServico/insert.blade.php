{!! Form::open( array('id'=>'frm_incTipoServico', 'action'=>'tipoServicoController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir Linha de Atuação</span>
            </div>

            <div class="modal-body">
            <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                <div class="form-row col-md-12">
                    <div class="col-md-12">
                    {!! Form::label("descricao", "Descrição", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("descricao",  null,        ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                    @if ($errors->has('descricao'))
                        <span colspan='12' style="color: red;">
                            {{ $errors->first('descricao') }}
                        </span>
                    @endif
                    </div>

                </div>  

            </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal" onclick='javascript:location.reload();'>Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incTipoServico").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
