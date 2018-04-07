<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Parserbin - Parse everything!</title>

        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/codemirror/lib/codemirror.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="/bower_components/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css">
        <link href="/css/editor.css" rel="stylesheet" type="text/css">

        <script src="/js/editor.js"></script>
    </head>
    <body>
        <div class="toolbar">
            <button id="new">New</button>
            <button id="save">Save</button>
            <button id="evaluate">Eval</button>
            <button id="toggle-code">Toggle Code</button>
            <label for="auto-update">
                <input type="checkbox" id="auto-update">
                Auto update
            </label>
            <input type="text" id="parser-name">
        </div>
        <div class="position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            @yield('content')
        </div>
    </body>
</html>
