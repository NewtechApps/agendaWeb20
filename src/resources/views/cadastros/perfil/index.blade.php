@extends('layouts.header')

@section('header-name','Perfil de Usuário')
@section('content')
<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="col-md-12 border border-dark rounded pb-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd">Código</a></th>
                    <th><a class="linktd">Nome</a></th>
                    <th><a class="linktd">Descrição</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($perfil as $perfis)
                    <tr>
                        <td>{{ $perfis->id_perfil }}</td>
                        <td>{{ $perfis->nome }}</td>
                        <td>{{ $perfis->descricao }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_perfil_{{ $perfis->id_perfil }}" action="{{ url('perfilUsuario/delete') }}" method="post">

                            <input name="id_perfil" id="id_perfil" value="{{ $perfis->id_perfil }}" type="hidden"></input>                
                            <a class='fas fa-edit'   title="Alterar" href="#update" data-toggle="modal" data-perfil   ="{{ $perfis->id_perfil }}" 
                                                                                                        data-nome     ="{{ $perfis->nome }}"
                                                                                                        data-descricao="{{ $perfis->descricao }}"
                                                                                                        ></a>

                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $perfis->id_perfil }}"
                                                                                                        data-descricao="{{ $perfis->nome }}"></a>
                        </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
</div> 

@include('layouts.footer')
@include('cadastros.perfil.insert')
@include('cadastros.perfil.update')

<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
    $('#insert').on('shown.bs.modal', function(e) {
        $('#i_nome').focus();
    });


    $('#delete').on('shown.bs.modal', function(e) {
        var codigo   = $(e.relatedTarget).data("codigo");
        var descricao= $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Perfil de Usuário: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_perfil_"+codigo+"').submit()");
    });   
});


function markAllRotinas() {
    $("input[name='codRotina[]']").each(function(){
        i = this.parentNode.parentNode.rowIndex;
        $("#checkSel"+i).prop("checked", !document.getElementById("checkSel"+i).checked);
    });
    selRotinas();
}

function selRotinas() {

    $("input[name='codRotina[]']").each(function(){
        i = this.parentNode.parentNode.rowIndex;
        if(document.getElementById("checkSel"+i).checked==true){
            $("#idSelect"+i).val("1");
        } else {
            $("#idSelect"+i).val("0");
        }
    });
}

</script>
@endsection
