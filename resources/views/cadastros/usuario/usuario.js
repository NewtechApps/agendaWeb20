window.insertUsuario = function(){

    var $id = null;
    $('#frmUsuario')[0].reset();
    $('#empresas tbody tr').remove();

    $('#crudModal #idUsuario').val('');
    $('#crudModal #modal-title').text("Inserir Usuário");
    $('#crudModal #erros').html('');

    carregaEmpresas($id);
    $('#crudModal').modal('show');
}

window.updateUsuario = function(usuario){

    $id = usuario.id_usuario;
    resetForm('#frmUsuario');

    $('#empresas tbody tr').remove();
    carregaEmpresas($id);

    $('#crudModal #modal-title').html("Alterar Usuário: "+$id+" - "+usuario.nome);
    $('#crudModal #erros').html('');


    $('#crudModal #id_usuario').val($id);
    $('#crudModal #nome').val(usuario.nome);
    $('#crudModal #email').val(usuario.email);
    $('#crudModal #status').val(usuario.status);
    $('#crudModal #id_empresa').val(usuario.id_empresa);
    $('#crudModal #login').val(usuario.login);
    $('#crudModal #telefone').val(usuario.telefone);
    $('#crudModal #id_perfil').val(usuario.id_perfil);
    $('#crudModal #codEstado').val(usuario.idEstado);
    $('#crudModal #data_nascimento').val(usuario.data_nascimento);
    $('#crudModal #id_linha_produto').val(usuario.id_linha_produto);
    $('#crudModal #especialidade').val(usuario.especialidade);
    $('#crudModal #notificacao_agenda').val(usuario.notificacao_agenda);
    
    buscarCidades('#crudModal #codEstado', '#crudModal #codMunicipio', usuario.idCidade)
    $('#crudModal').modal('show');
}

window.salvarUsuario = function(){

    $.ajax({
        url: "usuario/store",
        type: 'POST',
        dataType:'json',            
        data: $('#frmUsuario').serialize(),
        
        success: function(response){
            if(response.code=='200'){   
                $('#crudModal').modal('hide');
                location.reload();
            } else {
                $.each(response.erros, function (index) {
                    $('#crudModal #erros').html(response.erros[index]);
                    return false;
                });
            }
        },

        error: function() {
        window.location.href = '/';
        },
    });

}



window.carregaEmpresas = function(userId){

    $.ajax({
        url: 'usuario/empresas/'+userId,
        type: 'get',
        dataType: 'json',
        success: function(response){
    
            for(var i=0; i<response.length; i++){
            
                var email = response[i].email!=null ? response[i].email : "";
                var selectedSim = response[i].status=="0" ? 'selected' : '';
                var selectedNao = response[i].status=="1" ? 'selected' : '';
    
                newRow =  '<tr>';
                newRow += '<td>'+response[i].razao_social+'</td>';
                newRow += '<td><input  name="arr_email[]"   id="arr_email'+response[i].id_empresa+'"   value="'+email+'" type="email"  class="form-control inputrow"></input>';
                newRow += '<td><select name="arr_status[]"  id="arr_status'+response[i].id_empresa+'"  value="'+response[i].status+'"  class="form-control selectrow"><option value="0" '+selectedSim+'>Sim</option><option value="1" '+selectedNao+'>Não</option></select>';
                newRow += '    <input  name="arr_empresa[]" id="arr_empresa'+response[i].id_empresa+'" value="'+response[i].id_empresa+'" type="hidden"></input>';
                newRow += '</td></tr>';
                $('#empresas tbody').append(newRow);    
            }
        },
    
        error: function(error) {
        window.location.href = '/';
        },
    });
        
}

window.preencherEmail = function($modo) {

    if($modo=="update"){
        $("input[name='u_arr_empresa[]']").each(function(){
            i=$(this).val();
            codEmpresa = $("#u_arr_empresa"+i).val();
            if( codEmpresa==$('#u_id_empresa').val() ){
                $("#u_arr_email"+i).val( $('#u_email').val() );
            }
        });
    } else {
        $("input[name='i_arr_empresa[]']").each(function(){
            i=$(this).val();
            codEmpresa = $("#i_arr_empresa"+i).val();
            if( codEmpresa==$('#i_id_empresa').val() ){
                $("#i_arr_email"+i).val( $('#i_email').val() );
            }
        });
    }
}
