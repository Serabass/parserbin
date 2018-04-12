@extends('general')

@section('content')

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

@endsection
