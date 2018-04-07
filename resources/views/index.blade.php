@extends('general')
@php
    use Parserbin\Models\Parser;
        /**
         * @var $parser Parser
         **/
    $i = 0;
@endphp
@section('content')

    <style>
        .block {
            float: left;
            width: 33%;
            height: 100%;
        }
    </style>

    <div class="input block">
        <h4>Input</h4>
        <textarea name="input" id="input" cols="50"
                  rows="50">{{ isset($parser) ? $parser->input : 'Hello!' }}</textarea>
    </div>
    <div class="scripts block" style="float: left;">
        <h4>Script</h4>
        @if (isset($parser))
            @foreach ($parser->scripts()->get() as $script)
                <textarea name="script[{{$i}}]" class="script" data-id="{{$i}}" cols="50"
                          rows="20">{{ $script->content }}</textarea>
                @php $i++; @endphp
            @endforeach
        @else
            <textarea name="script" class="script" data-id="0" cols="50"
                      rows="20">return input + input;</textarea>
        @endif

    </div>
    <div class="output block">
        <h4>Output</h4>
        <pre contenteditable="true" id="output" readonly=""></pre>
    </div>
    <input id="evaluate" type="button" value="Evaluate"/>

    <script>
    </script>
@endsection
