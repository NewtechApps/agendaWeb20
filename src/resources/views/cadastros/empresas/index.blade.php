@extends('layouts.header')

@section('header-name','Empresas')
@section('content')
<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="row border border-dark rounded pb-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd">Código</a></th>
                    <th><a class="linktd">Razão Social</a></th>
                    <th><a class="linktd">Nome Fantasia</a></th>
                    <th><a class="linktd">CNPJ</a></th>
                    <th><a class="linktd">Telefone</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->id_empresa }}</td>
                        <td>{{ $empresa->razao_social }}</td>
                        <td>{{ $empresa->nome_fantasia }}</td>
                        <td>{{ $empresa->cpf_cnpj }}</td>
                        <td>{{ $empresa->telefone_fixo }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_empresa_{{ $empresa->id_empresa }}" action="{{ url('empresa/delete') }}" method="post">

                            <input name="id_empresa" id="id_empresa" value="{{ $empresa->id_empresa }}" type="hidden"></input>                
                            <a class='fas fa-edit' title="Alterar" href="#update" data-toggle="modal" 
                                                                                  data-codempresa     ="{{ $empresa->id_empresa }}"
                                                                                  data-razaosocial    ="{{ $empresa->razao_social }}"
                                                                                  data-nomefantasia   ="{{ $empresa->nome_fantasia }}"
                                                                                  data-tipopessoa     ="{{ $empresa->tipo_pessoa }}"
                                                                                  data-cpfcnpj        ="{{ $empresa->cpf_cnpj }}"
                                                                                  data-endereco       ="{{ $empresa->endereco }}"
                                                                                  data-complemento    ="{{ $empresa->complemento }}"
                                                                                  data-cep            ="{{ $empresa->cep }}"
                                                                                  data-telefonefixo   ="{{ $empresa->telefone_fixo }}"
                                                                                  data-telefonecelular="{{ $empresa->telefone_celular }}"
                                                                                  data-estado         ="{{ $empresa->estado }}"
                                                                                  data-municipio      ="{{ $empresa->municipio }}"
                                                                                  ></a>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $empresa->id_empresa }}"
                                                                                                        data-descricao="{{ $empresa->razao_social }}"></a>
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
@include('cadastros.empresas.insert')
@include('cadastros.empresas.update')



<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
    $('#i_tipo_pessoa').change(function(){
        $('#i_cpf_cnpj').val('');
        $('#i_cpf_cnpj').mask( $(this).val()=="1" ? '000.000.000-00' : '00.000.000/0000-00');
    });

    $('#u_tipo_pessoa').change(function(){
        $('#u_cpf_cnpj').val('');
        $('#u_cpf_cnpj').mask( $(this).val()=="1" ? '000.000.000-00' : '00.000.000/0000-00');
    });


    $('#insert').on('shown.bs.modal', function() {
        var modal = $(this);
        $('#i_telefone_fixo').mask('(00) 00000-0000');
        $('#i_telefone_celular').mask('(00) 00000-0000');
        $('#i_cep').mask('00000-000');
        $('#i_cpf_cnpj').mask('000.000.000-00');

        buscaEstados(null, modal.find('#i_estado'));
        $('#i_razao_social').focus(); 
    });


    $('#update').on('shown.bs.modal', function(e) {
        var codEmpresa   = "{{ old('u_id_empresa') }}"   ? "{{ old('u_id_empresa') }}"   : $(e.relatedTarget).data("codempresa");
        var razaoSocial  = "{{ old('u_razao_social') }}" ? "{{ old('u_razao_social') }}" : $(e.relatedTarget).data("razaosocial");
        var nomeFantasia = "{{ old('u_nome_fantasia') }}"? "{{ old('u_nome_fantasia') }}": $(e.relatedTarget).data("nomefantasia");
        
        var tipoPessoa   = "{{ old('u_tipo_pessoa') }}"  ? "{{ old('u_tipo_pessoa') }}"  : $(e.relatedTarget).data("tipopessoa");
        var cpfCnpj      = "{{ old('u_cpf_cnpj') }}"     ? "{{ old('u_cpf_cnpj') }}"     : $(e.relatedTarget).data("cpfcnpj");

        var endereco     = "{{ old('u_endereco') }}"     ? "{{ old('u_endereco') }}"     : $(e.relatedTarget).data("endereco");
        var complemento  = "{{ old('u_complemento') }}"  ? "{{ old('u_complemento') }}"  : $(e.relatedTarget).data("complemento");
        var cepEmpresa   = "{{ old('u_cep') }}"          ? "{{ old('u_cep') }}"          : $(e.relatedTarget).data("cep");
        var codEstado    = "{{ old('u_estado') }}"       ? "{{ old('u_estado') }}"       : $(e.relatedTarget).data("estado");
        var codMunicipio = "{{ old('u_municipio') }}"    ? "{{ old('u_municipio') }}"    : $(e.relatedTarget).data("municipio");

        var telefoneFixo    = "{{ old('u_telefone_fixo') }}"    ? "{{ old('u_telefone_fixo') }}"    : $(e.relatedTarget).data("telefonefixo");
        var telefoneCelular = "{{ old('u_telefone_celular') }}" ? "{{ old('u_telefone_celular') }}" : $(e.relatedTarget).data("telefonecelular");

        var modal = $(this);
        modal.find('#u_id_empresa').val(codEmpresa);
        modal.find('#u_razao_social').val(razaoSocial);
        modal.find('#u_nome_fantasia').val(nomeFantasia);
        modal.find('#u_tipo_pessoa').val(tipoPessoa);
        modal.find('#u_cpf_cnpj').val(cpfCnpj);

        modal.find('#u_endereco').val(endereco);
        modal.find('#u_complemento').val(complemento);
        modal.find('#u_municipio').val(codMunicipio);
        modal.find('#u_cep').val(cepEmpresa);
        modal.find('#u_telefone_fixo').val(telefoneFixo);
        modal.find('#u_telefone_celular').val(telefoneCelular);

        buscaEstados(codEstado, modal.find('#u_estado'));
        $('#u_telefone_fixo').mask('(00) 00000-0000');
        $('#u_telefone_celular').mask('(00) 00000-0000');
        $('#u_cep').mask('00000-000');
        $('#u_cpf_cnpj').mask( tipoPessoa=="1" ? '000.000.000-00' : '00.000.000/0000-00');
        $('#u_razao_social').focus(); 
    });



    $('#delete').on('shown.bs.modal', function(e) {
        var codigo    = $(e.relatedTarget).data("codigo");
        var descricao = $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Empresa: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_empresa_"+codigo+"').submit()");
    });


});



function buscaEstados(codEstado, idField) {
var estados = [
    ["AC",'Acre'],
    ["AL",'Alagoas'],
    ["AP",'Amapá'],
    ["AM",'Amazonas'],
    ["BA",'Bahia'],
    ["CE",'Ceará'],
    ["DF",'Distrito Federal'],
    ["ES",'Espírito Santo'],
    ["GO",'Goiás'],
    ["MA",'Maranhão'],
    ["MT",'Mato Grosso'],
    ["MS",'Mato Grosso do Sul'],
    ["MG",'Minas Gerais'],
    ["PA",'Pará'],
    ["PB",'Paraíba'],
    ["PR",'Paraná'],
    ["PE",'Pernambuco'],
    ["PI",'Piauí'],
    ["RJ",'Rio de Janeiro'],
    ["RN",'Rio Grande do Norte'],
    ["RS",'Rio Grande do Sul'],
    ["RO",'Rondônia'],
    ["RR",'Roraima'],
    ["SC",'Santa Catarina'],
    ["SP",'São Paulo'],
    ["SE",'Sergipe'],
    ["TO",'Tocantins']    
    ];

    for(var i=0; i<estados.length; i++){

        var id   = estados[i][0];
        var name = estados[i][1];
        var sel  = "";

        if(codEstado==id){
            sel = " selected";
        };
        
        var option = "<option value="+id+sel+">"+name+"</option>"; 
        $(idField).append(option); 
    }
} 

</script>
@endsection