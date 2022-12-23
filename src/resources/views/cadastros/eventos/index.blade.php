@extends('layouts.layoutPadrao')
@section('content')
<script src="{{ asset('assets/fullCalendar/main.js') }}"></script>
<!--link  href="{{ asset('assets/fullCalendar/main.css') }}" rel="stylesheet"-->
<link  href="{{ asset('css/customCalendar.css') }}" rel="stylesheet">

<script src="{{ asset('assets/datepicker.js') }}"></script>
<script src="{{ asset('assets/MultipleDatesPicker/jquery-ui.multidatespicker.js') }}"></script>
<link  href="{{ asset('assets/MultipleDatesPicker/jquery-ui.multidatespicker.css') }}" rel="stylesheet">


<!-- Div para Spinner -->
<div class="d-none justify-content-center align-items-center" id="spinner-div">
    <div class="spinner-border text-light" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>



<div id="main" class="container-fluid pt-2 pb-3">
    <div class="row">

        @if(Auth::user()->id_perfil=='1')
            <div id="filtros" class="col-md-2 border border-dark rounded pt-3 pb-1" style='background: white'>

                {!! Form::open(['method'=>'get', 'id'=>'btnRelat', 'target'=>'_blank', 'action'=>'EventosController@relatorio']) !!}
                <div class="row">
                    <h5 class="fc-toolbar-title">Filtros</h5>
                </div>

                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-sm navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqTitulo').slideToggle();">por Título</a>
                                </li>
                                <li>
                                    <a id="moreTitle" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#"
                                    onclick="$('.pesqTitulo').slideToggle(function(){
                                             $('#moreTitle').html( $('.pesqTitulo').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqTitulo pl-1 pr-1 pt-1 pb-1" style="display:none">
                            <input id="search" class="form-control" name="search" type="text" placeholder="Pesquisar..."
                            onkeydown="javascript:if(event.keyCode==13){ callendarRender(); };" aria-label="Search"/>
                        </div>
                    </div>
                </div>


                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-sm navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqStatus').slideToggle();">por Status</a>
                                </li>
                                <li>
                                    <a id="moreStatus" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#"
                                    onclick="$('.pesqStatus').slideToggle(function(){
                                             $('#moreStatus').html( $('.pesqStatus').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqStatus pl-1 pr-1 pt-1 pb-1" style="display:none">
                            {!! Form::select('filterStatus', ['2'=>'Ambos', '1'=>'Confirmado', '0'=>'A Confirmar'], "2",
                                ['class'=>'form-control', "id"=>"filterStatus", "onchange"=>"callendarRender();" ]) !!}
                        </div>
                    </div>
                </div>


                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-sm navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqEmpresa').slideToggle();">por Empresa</a>
                                </li>
                                <li>
                                    <a id="moreEmpresa" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#"
                                    onclick="$('.pesqEmpresa').slideToggle(function(){
                                             $('#moreEmpresa').html( $('.pesqEmpresa').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqEmpresa pl-1 pr-1 pt-1 pb-1" style="display:none">
                            @foreach ($empresasCombo as $id_empresa=>$razao_social)
                                <div class="checkbox">
                                <input id="checkEmpresas" name="checkEmpresas[]" value="{{ $id_empresa }}" type="checkbox" onClick="callendarRender();"></input>
                                <label class="mb-0">{{ $razao_social }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="row pb-1" id="divPesqUsuario">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-sm navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqUsuario').slideToggle();">por Usuário</a>
                                </li>
                                <li>
                                    <a id="moreUsuario" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#"
                                    onclick="$('.pesqUsuario').slideToggle(function(){
                                             $('#moreUsuario').html( $('.pesqUsuario').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqUsuario pl-1 pr-1 pt-1 pb-1" style="display:none">
                            <input id="usuarios" class="form-control mb-2" name="usuarios" type="text" placeholder="Pesquisar..." onkeyup="filtrarUsuarios();" aria-label="Search"/>
                            @foreach ($usuariosCombo as $id_usuario=>$nome)
                                <div class="checkbox" id='divUsuarios' name='divUsuarios[]' value="{{ $id_usuario }}">
                                <input id="checkUsuarios" name="checkUsuarios[]" value="{{ $id_usuario }}" type="checkbox" onClick="callendarRender();">  {{ $nome }}</input>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-sm navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqTrabalho').slideToggle();">por Tipo</a>
                                </li>
                                <li>
                                    <a id="moreTrabalho" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#"
                                    onclick="$('.pesqTrabalho').slideToggle(function(){
                                             $('#moreTrabalho').html( $('.pesqTrabalho').is(':visible') ? '&#9650':'&#9660' );
                                             });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqTrabalho pl-1 pr-1 pt-1 pb-1" style="display:none">
                            @foreach ($tipoAgendaCombo as $id_trabalho=>$descricao)
                                <div class="checkbox">
                                <input id="checkTrabalhos" name="checkTrabalhos[]" value="{{ $id_trabalho }}" type="checkbox" onClick="callendarRender();"></input>
                                <label class="mb-0">{{ substr($descricao,0,21) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="dropdown-divider"></div>
                <div class="row pt-1">
                    <h5 class="fc-toolbar-title mb-0">Relatório</h5>
                </div>

                <div class="row">
                    <div class="col-md-12">
                    {!! Form::label("data_rel_ini","Data Inicial", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::date("data_rel_ini", now()->firstOfMonth() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#data_rel_fin');" ]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                    {!! Form::label("data_rel_fin","Data Final", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::date("data_rel_fin", now()->lastOfMonth() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#gerar-rel');" ]) !!}
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-12">
                    <a class="btn btn-sm btn-secondary" style="width: 100%;" id="gerar-rel" href="#" onClick='javascript:$("#btnRelat").submit();'>Gerar</a>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>

            <div id="agenda" class="col-md-10 border border-dark rounded pt-3 pb-1" style='background: white'>
                <div id="calendar">
                </div>
            </div>

        @else
            <div id="agenda" class="col-md-12 border border-dark rounded pr-3 pl-3 pt-3 pb-1" style='background: white;'>
                <div id="calendar" style="position: relative;">
                </div>
            </div>
        @endif
    </div>
</div>


@include('cadastros.eventos.modal')
@include('cadastros.eventos.delete')
@include('cadastros.eventos.delAll')

<script type='text/javascript'>

    $("#spinner-div").removeClass("d-flex").addClass("d-none");
    $(document).ready(function(){

        $('#btnRelat').bind("keypress", function(e) {
            if ((e.keyCode == 10)||(e.keyCode == 13)) {
                e.preventDefault();
            }
        });

        callendarRender();
        $('#datepicker').multiDatesPicker({

            dateFormat: "dd/mm/yy",
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],

            nextText: 'Proximo',
            prevText: 'Anterior',
            altField: '#datas',

            onSelect: function(selected,evnt) {

                var intervalo = $("#radio1").is(":checked");
                var multipla  = $("#radio2").is(":checked");
                var arrDatas  = $("#datas").val().split(',');
                var repetida  = false;

                if( intervalo && arrDatas.length>2 ){
                      return false;
                };
            }
        });


        $('#modalAgenda').on('shown.bs.modal', function(e) {

            if ($('#modalAgenda #id_evento').val()==''){
                $('#modalAgenda #modal-title').text("Inserir Evento");
                $('#modalAgenda #delete-btn').css('display','none');
                $('#datepicker').multiDatesPicker('resetDates', 'picked');
            };

            $('#modalAgenda').find("#title").focus();
        });

    });


    function selecaoDatas($maxPicks){
        $('#modalAgenda #datepicker').datepicker('setDate', 'today');
        $('#modalAgenda #datepicker').multiDatesPicker({ maxPicks: $maxPicks});
        $('#modalAgenda #datepicker').multiDatesPicker('resetDates', 'picked');
    };


    function callendarRender(){

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'dayGridMonth',
            contentHeight: 'auto',
            navLinks: true,
            locales: 'pt-BR',
            businessHours: true,
            displayEventTime: false,
            eventDisplay: 'block',

            buttonText: {
                today: "Hoje",
                month: "Mês",
                week: "Semana",
                day:  "Dia",
                list: "Lista Mês"
            },

            customButtons: {
                addAgenda: {
                    text: 'Novo Evento',
                    click: function() {
                        eventInsert();
                    }
                }
            },


            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'addAgenda dayGridMonth,dayGridWeek,dayGridDay,listMonth',
            },

            titleFormat: {
                year: 'numeric',
                month: 'long',
                day : 'numeric'
            },


            events: {
                url: "{{ route('loadEvents') }}",
                method: 'GET',
                extraParams: {
                    filterTitle:  $('#search').val(),
                    filterStatus: $('#filterStatus').val(),
                    filterUsuario: $("input[name='checkUsuarios[]']").map(
                                        function(){
                                            if ($(this).is(':checked')){
                                                return $(this).val();
                                            }
                                    }).get(),

                    filterEmpresa: $("input[name='checkEmpresas[]']").map(
                                        function(){
                                            if ($(this).is(':checked')){
                                                return $(this).val();
                                            }
                                    }).get(),

                    filterTrabalho: $("input[name='checkTrabalhos[]']").map(
                                        function(){
                                            if ($(this).is(':checked')){
                                                return $(this).val();
                                            }
                                    }).get(),
                },
                failure: function() {
                    window.location.href = '/';
                },
            },



            loading: function(isLoading) {

                if(isLoading){ $("#spinner-div").removeClass("d-none").addClass("d-flex"); }
                else{ $("#spinner-div").removeClass("d-flex").addClass("d-none"); }
            },

            eventClick: function(info) {

                if("{{Auth::user()->id_perfil}}"=='1'){

                    // Modal delete
                    $('#delete #id_evento').val( info.event.id );
                    $('#delAll #id_geral').val( info.event.extendedProps.id_geral );


                    // Modal update
                    resetForm('#frmAgenda');
                    $('#modalAgenda #erros').html('');
                    $('#datepicker').multiDatesPicker('resetDates', 'picked');

                    $('#modalAgenda #modal-title').text("Alterar Evento");
                    $('#modalAgenda #del-all-btn').css('display','inline-block');

                    $('#modalAgenda #id_evento').val( info.event.id );
                    $('#modalAgenda #id_geral').val( info.event.extendedProps.id_geral );

                    $('#modalAgenda #title').val( info.event.extendedProps.descricao );
                    $('#modalAgenda #status').val( info.event.extendedProps.status );
                    $('#modalAgenda #empresa').val( info.event.extendedProps.empresa );
                    $('#modalAgenda #id_usuario').val( info.event.extendedProps.usuario );
                    $('#modalAgenda #tipo_periodo').val( info.event.extendedProps.tipo_periodo);
                    $('#modalAgenda #tipo_trabalho').val( info.event.extendedProps.tipo_trabalho );
                    $('#modalAgenda #tipo_alocacao').val( info.event.extendedProps.tipo_alocacao );

                    $('#modalAgenda #delete-btn').css('display', info.event.extendedProps.tipo_data=='2' ? 'inline-block':'none');
                    $radio = (info.event.extendedProps.tipo_data=='1') ? '#modalAgenda #radio2' : '#modalAgenda #radio1';
                    $url   = (info.event.extendedProps.tipo_data=='2') ? '{{ env("APP_URL") }}/eventos/carregaIntervaloDatas/'+info.event.id :
                                                                         '{{ env("APP_URL") }}/eventos/carregaMultiplasDatas/'+info.event.extendedProps.id_geral;
                    $($radio).prop("checked", true);


                    $.ajax({
                        url: $url,
                        type: 'get',
                        dataType: 'json',
                        success: function(response){

                            if(response.length > 0){

                                if(response[0].tipo_data==2){

                                    dataIni = response[0].start.substr(8,2)+'/'+response[0].start.substr(5,2)+'/'+response[0].start.substr(0,4);
                                    dataFim = response[0].end.substr(8,2)+'/'+response[0].end.substr(5,2)+'/'+response[0].end.substr(0,4);

                                    $('#modalAgenda #datepicker').datepicker('setDate', dataFim );
                                    $('#modalAgenda #datepicker').multiDatesPicker({ addDates: [dataIni, dataFim] });
                                    $('#modalAgenda #datepicker').multiDatesPicker({ maxPicks: 2});

                                } else {

                                    dataIni = [];
                                    for(var i=0; i<response.length; i++){
                                        dataIni[i] = response[i].start.substr(8,2)+'/'+response[i].start.substr(5,2)+'/'+response[i].start.substr(0,4);
                                    }

                                    $('#modalAgenda #datepicker').datepicker('setDate', dataIni[response.length-1]);
                                    $('#modalAgenda #datepicker').multiDatesPicker({ addDates: dataIni });
                                    $('#modalAgenda #datepicker').multiDatesPicker({ maxPicks: 999});
                                }
                            }
                            $('#modalAgenda').modal('show');

                        },

                        error: function() {
                            window.location.href = '/';
                        },
                    });


                } else {
                    $('#infoone').find("#description").html("Opção indisponível para o seu perfil de usuário!");
                    $('#infoone').modal('show');
                }
            },

            eventDidMount: function(info) {

                var dia = Number(info.event.startStr.substr(8,2));
                var mes = Number(info.event.startStr.substr(5,2));
                var ano = Number(info.event.startStr.substr(0,4));
                dataInicial = dia+'/'+mes+'/'+ano;

                if(info.event.extendedProps.tipo_data==2){
                    var dia = Number(info.event.endStr.substr(8,2));
                    var mes = Number(info.event.endStr.substr(5,2));
                    var ano = Number(info.event.endStr.substr(0,4));
                    dataFinal = dia+'/'+mes+'/'+ano;
                } else {
                    dataFinal = dataInicial;
                }

                $(info.el).tooltip({
                    title: info.event.title+
                    '\n\n Período: '+info.event.extendedProps.periodo+
                    '\n Data Inicial: '+dataInicial+
                    '\n Data Final: '+dataFinal+
                    '\n\n Tipo: '+info.event.extendedProps.descTrabalho+
                    '\n Gestor: '+info.event.extendedProps.nomeGestor,

                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },

            dayCellDidMount: function (info) {

                var dia = info.el.dataset.date.substr(8,2);
                var feriados = {!! json_encode($feriados) !!};

                for(var i=0; i<feriados.length; i++){

                    if (feriados[i].data == info.el.dataset.date){

                        $(info.el).css("background", "rgb(215, 215, 215, 1)" );
                        $element = info.el.getElementsByClassName('fc-daygrid-day-number');

                        $($element)[0].innerText = '';
                        $($element)[0].innerText = feriados[i].descricao+' - '+dia;
                    }
                }
            },

            select: function(selectionInfo){
                eventInsert();
            },


            datesSet: function(dateInfo) {

                var dia = Number(dateInfo.startStr.substr(8,2));
                var mes = Number(dateInfo.startStr.substr(5,2));
                var ano = Number(dateInfo.startStr.substr(0,4));

                var diaStr = '';
                var mesStr = '';
                var anoStr = '';
                var dataIni= '';
                var dataFim= '';

                if (dia>1){
                    mes = mes+1;
                    if(mes>12){
                        mes=1;
                        ano++;
                    };
                }

                diaStr = '01';
                mesStr = mes.toString();
                anoStr = ano.toString();
                if(mes<10){
                    mesStr = '0'+mesStr;
                };


                dataIni = anoStr+'-'+mesStr+'-'+diaStr;
                mes31   = ['01','03','05','07','08','10','12'];

                if (mes31.includes(mesStr)){
                    diaStr='31';
                } else {
                    if (mesStr=='02'){
                        diaStr='28';
                    } else {
                        diaStr='30';
                    }
                }

                dataFim = anoStr+'-'+mesStr+'-'+diaStr;
                $('#data_rel_ini').val(dataIni);
                $('#data_rel_fin').val(dataFim);
            }
        });

        if("{{Auth::user()->id_perfil}}"=='1'){
            var dateIni = $('#data_rel_ini').val();
            calendar.gotoDate(dateIni);
        };

        calendar.render();
    };


    function eventInsert(){

        if("{{Auth::user()->id_perfil}}"=='1'){

            resetForm('#modalAgenda #frmAgenda');
            $('#modalAgenda #modal-title').text("Inserir Evento");
            $('#modalAgenda #delete-btn').css('display','none');
            $('#modalAgenda #del-all-btn').css('display','none');

            selecaoDatas(2);
            $('#modalAgenda #id_geral').val('');
            $('#modalAgenda #id_evento').val('');
            $('#modalAgenda').modal('show');

        } else {
            $('#infoone').find("#description").html("Opção indisponível para o seu perfil de usuário!");
            $('#infoone').modal('show');
        }
    };

    function gravarAgenda(form) {

        $.ajax({
            url:  $(form).attr('action'),
            data: $(form).serialize(),
            type: 'POST',

            success: function(response){
                if(response.code=='200'){
                    $('#modalAgenda').modal('hide');
                    callendarRender();
                } else {
                    $.each(response.erros, function (index) {
                        $('#modalAgenda #erros').css("color", 'red');
                        $('#modalAgenda #erros').html(response.erros[index]);
                        return false;
                    });
                }
            },

            error: function() {
                window.location.href = '/';
            },
        });
    }

    function fecharAgenda() {
        $('#modalAgenda').modal('hide');
    }

    function filtrarUsuarios() {

        $texto = $('#usuarios').val().toLowerCase();
        $("div[name='divUsuarios[]']").each(function(){

            var objDiv = $(this).css("display", "block");
            if($texto.length>=3){


                $nome = objDiv[0].innerText.trim().toLowerCase();
                if($nome.indexOf($texto)<0){
                    objDiv.css("display", "none");
                };


                var codUsuario = objDiv.attr('value');
                $("input[name='checkUsuarios[]']").map( function(){

                    if( $(this).attr('value')==codUsuario ) {
                        if ($(this).is(':checked')){
                            objDiv.css("display", "block");
                        };
                    };
                });
            };
        });
    }

</script>
@endsection
