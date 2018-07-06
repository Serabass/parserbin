<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Parserbin\Models\Parser;
use Parserbin\Services\ParserService;

class ParserController extends Controller
{
    public function create()
    {
        return view('index', ['parserPage' => true]);
    }

    public function show($hash, ParserService $parserService)
    {
        return view('index', [
            'parser' => $parserService->show($hash),
            'parserPage' => true,
        ]);
    }

    public function update(ParserService $parserService)
    {
        $str = Input::get('data');
        $data = json_decode($str);
        $parser = $parserService->update($data);
        return redirect(route('parser', [
            'hash' => $parser->hash,
        ]));
    }

    public function fork($hash, ParserService $parserService)
    {
        /**
         * @var $new Parser
         */
        $new = $parserService->fork($hash);

        return redirect(route('parser', [
            'hash' => $new->hash
        ]));
    }
}
