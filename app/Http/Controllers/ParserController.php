<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Parserbin\Models\Language;
use Parserbin\Models\Parser;
use Parserbin\Models\Script;

class ParserController extends Controller
{
    public function create()
    {
        return view('index', ['parserPage' => true]);
    }

    public function show($hash)
    {
        $parser = Parser::whereHash($hash)->first();

        return view('index', [
            'parser'     => $parser,
            'parserPage' => true
        ]);
    }

    public function update(Request $request)
    {
        $str = Input::get('data');
        $data = json_decode($str);

        $parser = new Parser();
        $parser->hash = Parser::generateFreeHash();
        $parser->title = $data->title;
        $parser->input = $data->input;
        $parser->save();

        $script = new Script();
        $script->language()->associate(Language::default());
        $script->parser()->associate($parser);
        $script->content = $data->script;
        $script->save();

        return redirect(route('parser', [
            'hash' => $parser->hash,
        ]));
    }
}
