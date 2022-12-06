@if(Session::get('erros')!='') 
    <script type='text/javascript'>
        $(document).ready(function(){
            $('#infoone').find("#description").html('{{ Session::get('erros') }}');
            $('#infoone').modal('show');
        });
    </script>
    {!! Session::put('erros',''); !!}
@endif

@if(Session::has('errors'))
<script type='text/javascript'>

    //console.log("{{ Session::get('errors') }}");
    $(document).ready(function(){
        var nomeModal = "{{ Session('id_modal') }}";
        $('#'+nomeModal).modal('show');
    });
</script>
@endif

