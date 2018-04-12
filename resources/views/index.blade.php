@extends('general')
@php
    use Parserbin\Models\Parser;
        /**
         * @var $parser Parser
         **/
    $i = 0;
@endphp
@section('content')
    <div>
        <label for="parser-title">
            Title:
            <input type="text" id="parser-title" placeholder="My awesome parser"
                   value="{{ isset($parser) ? $parser->title : '' }}">
        </label>
    </div>
    <div class="input block">
        <h4>Input</h4>
        <pre contenteditable="true" readonly="" id="input">{{ isset($parser) ? $parser->input : 'Hello!' }}</pre>
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
        <h4>Output
            <span class="push-right">
                <button id="evaluate">Evaluate</button>
                <label for="auto-update">
                    <input type="checkbox" id="auto-update">
                    Auto update
                </label>
            </span>
        </h4>

        <pre contenteditable="true" id="output" readonly=""></pre>
    </div>
    <form action="{{ route('update-parser') }}" id="saveform" method="post">
        <input type="hidden" name="data"/>
        {{ csrf_field() }}
    </form>
@endsection
