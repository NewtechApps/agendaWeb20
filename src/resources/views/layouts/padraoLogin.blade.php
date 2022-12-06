<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>{{ config('app.name') }} - Login</title> 

        <link rel='icon' href="{{ asset('images/favicon.png') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/padrao.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>

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
        @yield('header')
        @yield('content')
        @include('layouts.footer')

    </div>
</body>
</html>
