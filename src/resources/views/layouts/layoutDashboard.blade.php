<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>{{config('app.name') }} - @yield('page-title')</title> 

        <link rel='icon' href="{{ asset('images/favicon.png') }}">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css' crossorigin='anonymous'
            integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/'>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/padrao.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        
        <script src="{{ asset('js/app.js') }}"></script>
        <style> html, body { background-image: url( "{{ asset('images/telafundo.png') }}"); }</style>   
    </head>

    <body>
    <div id="app">
        
        <div class="d-none justify-content-center align-items-center" id="spinner-div">
            <div class="spinner-border text-light" role="status">
            <span class="sr-only">Loading...</span>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" style="padding-top:0.3rem; height: 40px; font-size: 1.1rem;">
            <div class="collapse navbar-collapse"  id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto font-weight-bold ">
                    <li><span style="color:white;">@yield('header-name')</span></li>                
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>
    </body>
</html>
