{!! Form::open( array('id'=>'frmDeleteTodasAgendas', 'url'=>'eventos/deleteAll') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="delAll">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" role='document'>
            <div class="modal-header pl-4">
                <span class="linhaMestra" class="modal-title" id="modal-title">Exclusão Completa de Agenda!</span>
            </div>
            <div class="modal-body pl-4">
                <div class="row col-md-12" id="intro">
                    Você tem certeza que deseja excluir todas as Agendas?
                </div>
                <div class="row col-md-12" id="description">
                <input name="id_geral" id="id_geral" value="" type="hidden"></input>                
                    Esse procedimento irá excluir todos os registros de Eventos dessa Agenda,
                    de todas as datas, posteriores à data atual!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-danger"    data-dismiss="modal" onClick="gravarAgenda('#frmDeleteTodasAgendas');">Excluir</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}