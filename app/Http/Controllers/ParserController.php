<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Parserbin\Models\Parser;

class ParserController extends Controller
{
    public function create()
    {
        return view('index');
    }

    public function show($hash)
    {
        $parser = Parser::whereHash($hash)->first();
        return view('index', [
            'parser' => $parser
        ]);
    }

    public function update(Request $request)
    {
        $str = Input::get('data');
        $obj = json_decode($str);

        dump($obj);
    }
}
