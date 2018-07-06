@php
    if (!isset($parserPage)) {
        $parserPage = false;
    }

/**
 * @var $parser \Parserbin\Models\Parser
 */
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if ($parserPage)
        <meta name="parser-hash" content="{{ isset($parser) ? $parser->hash : '' }}">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots"
          content="{{ ($parserPage && isset($parser)) ? ($parser->indexable ? 'index' : 'noindex') : 'noindex' }}, follow"/>
    <title>{parserbin} - Parse everything!</title>

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/codemirror/lib/codemirror.js"></script>
    <script src="/bower_components/codemirror/mode/javascript/javascript.js"></script>
    <script src="/bower_components/underscore/underscore-min.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link href="/bower_components/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css">
    <link href="/css/styles.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet"
          type="text/css">

    <link rel="shortcut icon" href="/images/favicon.png"/>

    <script src="/js/editor.js"></script>
</head>
<body>
<a href="https://github.com/Serabass/parserbin" target="_blank">
    <img style="position: fixed; top: 0; right: 0; border: 0; z-index: 999;"
         src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png" alt="Fork me on GitHub">
</a>
<div class="toolbar">
    <div class="buttons">
        <a href="/" class="logo-link">
            <img src="/images/logo.png" alt="{parserbin}" class="logo"/>
        </a>
        <button id="new">New parser</button>
        @if ($parserPage)
            <button id="save">Save</button>
            @if (isset($parser))
                <button id="fork">Fork</button>
            @endif
            <button id="toggle-code">Toggle Code</button>
            <a id="bookmarklet"
               href="javascript:~function () {var text = getSelection().toString(); if (!text) return; window.open('{{\Illuminate\Support\Facades\URL::to('')}}#' + encodeURI(text))}();"
            >Save bookmarklet</a>
        @endif
    </div>
    <div class="powered">
        powered by <a href="http://serabass.net" target="_blank">
            Serabass
        </a>
    </div>

    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                {{--<a href="{{ route('me.index') }}">Me</a>--}}
                <a href="{{route('me.index')}}">My profile</a>
                <a href="#" id="logout">Logout</a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    {{ csrf_field() }}
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    @endif

</div>
<div class="position-ref full-height">
    @yield('content')
</div>
</body>
</html>
