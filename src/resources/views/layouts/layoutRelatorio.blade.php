<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>{{ config('app.name') }}</title> 

        <link rel='icon' href="{{ asset('images/favicon.png') }}">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css' 
            integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/' 
            crossorigin='anonymous'>
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/padrao.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>

        <style>
            html, body {

                padding-bottom: 0rem;

                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
            }

        </style>   
    </head>

    <body>
    <div id="app">
        @yield('content')
    </div>
</body>
</html>
