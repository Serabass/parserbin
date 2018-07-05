<?php

namespace Parserbin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Parserbin\Models\Language;
use Parserbin\Models\Parser;
use Parserbin\Models\Script;

class ParserController extends Controller
{
    public function create(Request $request)
    {
        return view('index', ['parserPage' => true]);
    }

    public function show($hash)
    {
        /**
         * @var $parser Parser
         */
        $parser = Parser::whereHash($hash)->first();

        $parser->lastActivity = Carbon::now();
        $parser->save();

        return view('index', [
            'parser' => $parser,
            'parserPage' => true,
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

    public function fork($hash)
    {
        /**
         * @var $parser Parser
         */
        $parser = Parser::whereHash($hash)->first();

        /**
         * @var $new Parser
         */
        $new = $parser->replicate();
        $new->hash = Parser::generateFreeHash();
        $new->parentId = $parser->id;
        $new->push();

        return redirect(route('parser', [
            'hash' => $new->hash
        ]));
    }
}
