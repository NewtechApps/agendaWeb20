<div class="modal fade" id="delete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" role='document'>
            <div class="modal-header pl-4">
                <span class="linhaMestra" class="modal-title" id="modal-title">Exclusão de Agenda!</span>
            </div>
            <div class="modal-body pl-4">
                <div class="row col-md-12" id="intro">
                    Você tem certeza que deseja excluir o registro?
                </div>

                {!! Form::open( array('id'=>'frmDelAgenda', 'url'=>'eventos/delete') ) !!}
                {{ csrf_field() }}
                <div class="row col-md-12" id="description">
                <input name="id_evento"  id="id_evento" value="" type="hidden"></input>                
                    Esse procedimento irá excluir o registro desta Agenda!
                </div>
                {!! Form::close() !!}


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-danger"    data-dismiss="modal" onClick="gravarAgenda('#frmDelAgenda');">Excluir</button>
            </div>
        </div>
    </div>
</div>