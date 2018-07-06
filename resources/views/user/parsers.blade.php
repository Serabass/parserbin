@php

/**
 * @var $parser \Parserbin\Models\Parser
 */

@endphp

@extends('user.layout')

@section('me.content')
    @if(!$me->hasParsers())
        <p>
            You have not any parser. <a href="/">Create it now!</a>
        </p>
    @else
        <div class="parsers">
            @foreach ($me->parsers as $parser)
                <div class="parser">
                    <div class="title">
                        <a href="{{$parser->url()}}">{{ $parser->title }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
