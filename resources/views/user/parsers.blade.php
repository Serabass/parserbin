@php

/**
 * @var $parser \Parserbin\Models\Parser
 */

@endphp

@extends('user.layout')

@section('me.content')
    @if(!$me->has_parsers)
        <p>
            You have not any parser. <a href="/">Create it now!</a>
        </p>
    @else
        <div class="parsers">
            @foreach ($me->parsers as $parser)
                <div class="parser">
                    <div class="title">
                        <a href="{{$parser->url()}}">
                            @if (!empty($parser->title))
                            {{ $parser->title }}
                            @else
                                <i>[no title]</i>
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
