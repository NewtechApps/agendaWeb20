{!! Form::open( array('id'=>'frm_delAgenda', 'action'=>'eventosController@delete') ) !!}
{{ csrf_field() }}
{{ method_field('DELETE') }}

<div class="modal fade" id="delete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" role='document'>
            <div class="modal-header pl-4">
                <span class="linhaMestra" class="modal-title" id="modal-title">Exclusão de Registro!</span>
            </div>
            <div class="modal-body pl-4">
                <div class="row col-md-12" id="intro">
                    Você tem certeza que deseja excluir o registro?
                </div>
                <div class="row col-md-12" id="description">
                <input name="id_evento"  id="id_evento" value="" type="hidden"></input>                
                    Esse procedimento irá excluir todos os registros de Eventos de todas as datas, ou intervalos de datas selecionadas!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-danger"    data-dismiss="modal" onClick="$('#frm_delAgenda').submit()">Excluir</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}