@php
    if (!isset($parserPage)) {
        $parserPage = false;
    }

$i = 0;
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
<div class="position-ref top full-height">
    <div>
        <label for="parser-title">
            <h3>{{ isset($parser) ? $parser->title : '' }}
                <a href="{{ $parser->url() }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </h3>
        </label>

        @if (isset($parser) && $parser->isChild())
            Forked from: <a href="{{$parser->parent->url()}}">
                {{ $parser->parent->hash }}
            </a>

        @endif

        @if (isset($parser) && $parser->hasForks())
            Forks: {{ $parser->forks->count() }}
        @endif

        @if (isset($parser->userId))
            Author: <a href="{{ $parser->user->url() }}">{{ $parser->user->name }}</a>
        @endif
    </div>
    <div class="input block">
        <h4>Input</h4>
        <textarea id="input" class="codemirror"
                  data-mode="plain">{{ isset($parser) ? $parser->input : 'Hello!' }}</textarea>
    </div>
    <div class="scripts block" style="float: left;">
        <h4>Script <span id="execTime"></span></h4>
        @if (isset($parser))
            @foreach ($parser->scripts()->get() as $script)
                <textarea name="script[{{$i}}]" class="codemirror script" data-mode="javascript" data-id="{{$i}}"
                          cols="50"
                          rows="20">{{ $script->content }}</textarea>
                @php $i++; @endphp
            @endforeach
        @else
            <textarea name="script" class="codemirror script" data-mode="javascript" data-id="0" cols="50"
                      rows="20">return input + input;</textarea>
        @endif

    </div>
    <div class="output block">
        <h4>Output
            <span class="push-right">
                <button id="evaluate">Evaluate</button>
                <label for="auto-update">
                    <input type="checkbox" id="auto-update">
                    Auto update
                </label>
            </span>
        </h4>

        <textarea id="output" name="script" class="codemirror" data-mode="plain"></textarea>
    </div>
    <form action="{{ route('update-parser') }}" id="saveform" method="post">
        <input type="hidden" name="data"/>
        {{ csrf_field() }}
    </form>
</div>
</body>
</html>
