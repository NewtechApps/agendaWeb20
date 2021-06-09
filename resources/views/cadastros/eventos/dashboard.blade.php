@extends('layouts.layoutDashboard')
@section('page-title',  'Dashboard - Capacidade x Demanda')
@section('header-name', 'Dashboard - Capacidade x Demanda')


@section('content')
{!! Form::open(['method'=>'get', 'url'=>'eventos/dashboard' ]) !!}
<div class="container-fluid pt-3 pb-2">

    <!-- Informações Gerais -->
    <div class="row mb-1"> 
        <div class="col-md-9 border border-dark rounded pb-0 pr-0 pl-0 mb-2" style='background-color: #f8fafc;'>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 31px">
                <div class="collapse navbar-collapse"  id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <li class="whiteTitle">Informações Gerais</li> 
                    </ul>
                </div>
            </nav>

            <div id="list">
                <div class="row pb-3">

                    <div class="col-md-3">
                    {!! Form::label("dataInicial","Data Inicial", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::date("dataInicial", request('dataInicial') ?? now()->firstOfMonth()->startOfWeek() ,["class"=>"form-control", "autofocus", "onkeydown"=>"setFocus(event,'#dataFinal');" ]) !!}
                    </div>

                    <div class="col-md-3">

                        {!! Form::label("dataFinal","Data Final", ["class"=>"col-form-label pl-0"]) !!}
                        <div class="input-group">
                            {!! Form::date("dataFinal", request('dataFinal') ?? now()->endOfMonth()->endOfWeek() ,["class"=>"form-control", "onkeydown"=>"javascript:if(event.keyCode==13){ $('#search').click(); };" ]) !!}
                            <div class="input-group-append">
                            <button type="submit" class="btn btn-sm btn-light" title="Pesquisar" id="search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>  
                    </div>

                    <div class="col-md-6 text-right">
                        <div class="form-row col-md-12">
                        {!! Form::label("totalRecursos", "Total de Recursos: ".$usuarios->count(),  ["class"=>"col-form-label col-md-6"]) !!}
                        {!! Form::label("totalHoras",    "Total de Horas: ".$usuarios->count()*160, ["class"=>"col-form-label col-md-6"]) !!}
                        </div>

                        <div class="form-row col-md-12">
                        {!! Form::label("percAlocacao",  "% Alocação: ",     ["class"=>"col-form-label col-md-6"]) !!}
                        {!! Form::label("totalAlocadas", "Horas Alocadas: ", ["class"=>"col-form-label col-md-6"]) !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3 border border-dark rounded pb-0 pr-0 pl-0 mb-3" style='background-color: #f8fafc;'>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 30px">
                <div class="collapse navbar-collapse"  id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <li class="whiteTitle">Alocação Geral</li> 
                    </ul>
                </div>
            </nav>
        </div>
    </div>



    <!-- Carousel -->
    <div class="col-md-12 border border-dark rounded pb-0 mb-3">
        <div id="semanal" class="carousel slide" data-interval="false">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#777"></rect></svg>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#777"></rect></svg>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#777"></rect></svg>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                    </div>
                </div>
            </div>

            <a class="carousel-control-prev" role="button" href="#semanal" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" role="button" href="#semanal" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</div>


<footer><nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 29px;"></nav></footer>
<script type='text/javascript'>

</script>    
{!! Form::close() !!}
@endsection
