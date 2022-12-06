@extends('layouts.header')
@section('header')
    
    {!! Form::open(['method'=>'get']) !!}
    <nav class="navbar navbar-expand-sm navbar-light bg-light">    
        <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto font-weight-bold pl-2">
                <li><span class="linhaMestra">Linha de Atuação</span></li>                
            </ul>

            <form class="form-inline my-2 my-lg-2">
            <ul class="navbar-nav input-group input-group-sm col-md-6">
                {!! Form::label("status" , "Status",["class"=>"col-form-label col-md-2 offset-md-2 text-right"]) !!}
                {!! Form::select('status', ['0'=>'Ativos', '1'=>'Inativos', '2'=>'Ambos'], request('status') ? request('status') :'0', 
                    ['class'=>'form-control col-md-2', 
                    'style'=>"border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;", 
                    "onchange"=>"$('#search_btn').click();" ]) !!}
                <div class="input-group-append col-md-6 pr-0">

                    <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                    placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                    <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                    <input type="hidden" value="{{request('field')}}" id="field" name="field"/>
                    <input type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
                </div>
            </ul>
            </form>
        </div>
    </nav>
    {!! Form::close() !!}

@include('layouts.delete')
@endsection


@section('content')
<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="col-md-12 border border-dark rounded pb-0 pl-0 pr-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('id_linha_produto');">Código</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('descricao');">Descrição</a></th>
                    <th class="text-right">Status</th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($tiposServico as $tipo)
                    <tr>
                        <td>{{ $tipo->id_linha_produto }}</td>
                        <td>{{ $tipo->descricao }}</td>
                        <td class="text-right">{{ $tipo->status=='1' ? "Inativo" : "Ativo" }}</td>
                        <td class="text-right" style="vertical-align: middle">

                            <form id="frm_del_tipoServico_{{ $tipo->id_linha_produto }}" method="post">

                                {{ csrf_field() }}
                                <input name="id_linha_produto" id="id_linha_produto" value="{{ $tipo->id_linha_produto }}" type="hidden"></input>                
                                <input name="status"           id="status"           value="{{ $tipo->status }}"           type="hidden"></input>                

                                <a class="{{ $tipo->status=='0' ? 'fas fa-thumbs-down' : 'fas fa-thumbs-up' }}"
                                   title="{{ $tipo->status=='0' ? 'Inativar' : 'Ativar' }}" href="#" onclick="excluirTipo( 'status', {{json_encode($tipo)}} );"></a>
                                <a class='fas fa-eraser' title="Deletar"  href="#" onclick="excluirTipo( 'delete', {{json_encode($tipo)}} );"></a>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
    </div> 
</div> 

@include('layouts.footer')
@include('cadastros.tipoServico.insert')


<script type='text/javascript'>
    
    $(document).ready(function(){
        $('#search').focus();
        $('#insert').on('shown.bs.modal', function(e) {
            $('#insert').find("#descricao").focus();
        });
    });


    function excluirTipo(action, tipo){

        if(action=='delete'){

            $('#frm_del_tipoServico_'+tipo.id_linha_produto).attr('action', "{{ url('tipoServico/delete') }}") 

            $('#delete').find("#delete-btn").html('Excluir');
            $('#delete').find("#modal-title").html('Exclusão de Registro!');
            $('#delete').find("#intro").html('Você tem certeza que deseja excluir o registro?');

        } else {

            $('#frm_del_tipoServico_'+tipo.id_linha_produto).attr('action', "{{ url('tipoServico/status') }}") 

            if(tipo.status==0){

                $('#delete').find("#delete-btn").html('Inativar');
                $('#delete').find("#modal-title").html('Inativação de Registro!');
                $('#delete').find("#intro").html('Você tem certeza que deseja inativar o registro?');
            } else {
                $('#delete').find("#delete-btn").html('Ativar');
                $('#delete').find("#modal-title").html('Ativação de Registro!');
                $('#delete').find("#intro").html('Você tem certeza que deseja ativar o registro?');
            }
        }

        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_tipoServico_"+tipo.id_linha_produto+"').submit()");
        $('#delete').find("#description").html('Linha de Atuação: '+tipo.id_linha_produto+' - '+tipo.descricao);
        $('#delete').modal('show');
    };   


</script>
@endsection
