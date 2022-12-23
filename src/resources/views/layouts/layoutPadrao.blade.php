<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{ config('app.name') }}</title>

        <link rel='icon' href="{{ asset('images/favicon.png') }}">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css'
            integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/'
            crossorigin='anonymous'>

        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
        <link  href="{{ asset('assets/fullCalendar/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/padrao.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Bootstrap -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

        <style>
            html, body {
                padding-bottom: 0rem;
                background-image: url("{{ asset('images/telafundo.png') }}");
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;

                background-size: cover;
                background-repeat: no-repeat;
                background-position: bottom;
                background-attachment: fixed;
            }
        </style>
    </head>

    <body>
    <div id="app">

        @include('layouts.menu')
        @include('layouts.infoone')
        @include('layouts.erros')

        @yield('header')
        @yield('content')
    </div>
</body>
</html>
