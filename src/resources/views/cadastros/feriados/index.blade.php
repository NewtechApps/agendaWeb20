@extends('layouts.header')

@section('header-name','Feriados')
@section('content')
<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="col-md-12 border border-dark rounded pb-0 pl-0 pr-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('data');">Data</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('descricao');">Descrição</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($feriados as $feriado)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($feriado->data)->format('d/m/Y') }}</td>
                        <td>{{ $feriado->descricao }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_feriado_{{ $feriado->id_feriado }}" action="{{ url('feriados/delete') }}" method="post">

                            <input name="id_feriado" id="id_feriado" value="{{ $feriado->id_feriado }}" type="hidden"></input>                
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $feriado->id_feriado }}"
                                                                                                        data-descricao="{{ $feriado->descricao }}"></a>
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
@include('cadastros.feriados.insert')

<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
    $('#insert').on('shown.bs.modal', function(e) {
        $('#insert').find("#data").focus();
    });


    $('#delete').on('show.bs.modal', function(e) {
        var codigo   = $(e.relatedTarget).data("codigo");
        var descricao= $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Feriado: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_feriado_"+codigo+"').submit()");
    });   
});
</script>
@endsection