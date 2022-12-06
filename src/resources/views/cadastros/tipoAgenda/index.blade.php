@extends('layouts.layoutPadrao')
@section('header')

{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-sm navbar-light bg-light">    

    <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="insertModal()"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
        <li><span class="linhaMestra">Tipos de Agenda</span></li>                
        </ul>

        <ul class="navbar-nav input-group input-group-sm col-md-6">
            {!! Form::label("status" , "Status",["class"=>"col-form-label col-md-2 offset-md-2 text-right"]) !!}
            {!! Form::select('status', ['0'=>'Ativos', '1'=>'Inativos', '2'=>'Ambos'], request('status') ? request('status') :'0', 
                ['class'=>'form-control col-md-2', 'style'=>"border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;", 
                "onchange"=>"$('#search_btn').click();" ]) !!}
    
            <div class="input-group-append col-md-6 pr-0">
                <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" autofocus
                placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                <input type="hidden" value="{{request('field')}}" id="field" name="field"/>
                <input type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
            </div>
        </ul>
    </div>
</nav>
{!! Form::close() !!}
@endsection


@section('content')
<div class="container-fluid pb-2">
    <div id="main-table" class="table-responsive border border-dark rounded pb-0 pt-0 pr-0 pl-0" style='background: white'>
        <table class="table table-hover table-sm table-striped tablesorter mb-0">
            <thead class="thead-dark">
            <tr>
                <th><a class="linktd" href='#' onClick="tablesorter('id_trabalho');">Código</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('descricao');">Descrição</a></th>
                <th>Cor</th>
                <th class="text-right">Status</th>
                <th class="text-right"></th>
            </tr>
            </thead>

            <tbody>     
                @foreach($tiposAgenda as $trabalho)
                <tr>
                    <td>{{ $trabalho->id_trabalho }}</td>
                    <td>{{ $trabalho->descricao }}</td>
                    <td><div style="background-color: #{{ $trabalho->cor }}; padding: 10px;"></div></td>
                    <td class="text-right">{{ $trabalho->status=='1' ? "Inativo" : "Ativo" }}</td>
                    <td class="text-right pl-0 pr-1">

                        <a class='fas fa-edit'    title="Alterar" href="#" onclick="updateRegistro( {{ json_encode($trabalho) }});"></a> 
                        <form class='form-inline' style='display: inline-grid' id="frmDeleteTipoAgenda_{{ $trabalho->id_trabalho }}" action="{{ url('tipoAgenda/delete') }}" method="post">

                            {{ csrf_field() }}
                            <input name="id_trabalho" id="id_trabalho" value="{{ $trabalho->id_trabalho }}" type="hidden"></input>                
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-id_trabalho ="{{ $trabalho->id_trabalho }}"
                                                                                                        data-descricao="{{ $trabalho->descricao }}"></a>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div> 
</div> 

@include('cadastros.tipoAgenda.crud')
@include('layouts.delete')
@include('layouts.footer')


<script type='text/javascript'>

    $('#main-table').height((window.innerHeight*0.78)+"px");
    $('#crudModal').on('shown.bs.modal', function(e) { $('#crudModal').find("#descricao").focus(); });

    function insertModal(){
        $('#frmTipoAgenda')[0].reset();
        $('#crudModal #modal-title').text("Inserir Novo Tipo de Agenda");
        $('#crudModal #erros').html('');
        $('#crudModal').modal('show');
    }

    function updateRegistro(registro){
        $('#frmTipoAgenda')[0].reset();
        $('#crudModal #modal-title').html("Alterar Tipo de Agenda: "+registro.descricao);

        $('#crudModal #id_trabalho').val(registro.id_trabalho);
        $('#crudModal #descricao').val(registro.descricao);
        $('#crudModal #colorpicker').val('#'+registro.cor);
        $('#crudModal #status').val(registro.status);

        $('#crudModal #erros').html('');
        $('#crudModal').modal('show');
    }

    $('#delete').on('shown.bs.modal', function(e) {
        var id_trabalho = $(e.relatedTarget).data("id_trabalho");
        var descricao   = $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Tipo de Agenda: '+id_trabalho+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frmDeleteTipoAgenda_"+id_trabalho+"').submit()");
        $('#delete').modal('show');
    });   

</script>
@endsection