@extends('general')

@section('content')
    @if(!$me->hasParsers())
        <p>
            You have not any parser. <a href="/">Create it now!</a>
        </p>
    @else
        <div class="parsers">
            @foreach ($me->parsers as $parser)
                <div class="parser">
                    <div class="title">
                        {{ $parser->title }}
                    </div>
                    @foreach($parser->scripts as $script)
                        <div class="code">
                            {{ $script->content }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
@endsection
