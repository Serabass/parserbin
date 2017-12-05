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
        }
    </style>

    <form action="" method="POST" id="parser-form">
        <div class="input block">
            <textarea name="input" id="input" cols="50" rows="50">{{ isset($parser) ? $parser->input : '' }}</textarea>
        </div>
        <div class="scripts block" style="float: left;">
            @if (isset($parser))
                @foreach ($parser->scripts()->get() as $script)
                    <textarea name="script[{{$i}}]" class="script" data-id="{{$i}}" cols="50"
                              rows="20">{{ $script->content }}</textarea>
                    @php $i++; @endphp
                @endforeach
            @else
                <textarea name="script[0]" class="script" data-id="0" cols="50"
                          rows="20"></textarea>
            @endif

        </div>
        <div class="output block">
            <textarea name="output" id="output" readonly cols="50" rows="50"></textarea>
        </div>
        <input id="evaluate" type="button" value="Evaluate" />
    </form>

    <script>
      $(function() {
        $('#evaluate').click(function(e) {
          e.preventDefault();
          var input = $('#input').val(),
            scripts = $('.script').map(function() {
              return $(this).val()
            }).toArray();

          scripts.reduce(function(val, script) {
            var fn = new Function('input', script);
            val = Promise.resolve(val);
            return val.then(fn);
          }, input).then(function(output) {
            $('#output').val(output);
          });
        });
      });
    </script>
@endsection
