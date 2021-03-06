<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Parserbin\Models\Parser;
use Parserbin\Services\ParserService;
use Parserbin\User;

class ParserController extends Controller
{
    public function create()
    {
        return view('index', ['parserPage' => true]);
    }

    public function show($hash, ParserService $parserService)
    {
        $parser = $parserService->show($hash);

        if ($parser->user) {
            return redirect(route('user.parser', [
                'user' => $parser->user->name,
                'hash' => $parser->hash,
            ]));
        }

        if (!$parser) {
            return abort(404); // Or redirect 'home'
        }

        $parser->updateLastActivity();

        return view('index', [
            'parser'     => $parser,
            'parserPage' => true,
        ]);
    }

    public function showByUser($username, $hash, ParserService $parserService)
    {
        $user = User::whereName($username)->first();

        if (!$user) {
            return redirect('home');
        }

        return view('index', [
            'parser'     => $parserService->showByUser($user, $hash),
            'parserPage' => true,
        ]);
    }

    public function embed($hash, ParserService $parserService)
    {
        $parser = $parserService->show($hash);

        if (!$parser) {
            return abort(404); // Or redirect 'home'
        }

        $parser->updateLastActivity();

        return view('embed', [
            'parser'     => $parser,
            'parserPage' => true,
        ]);
    }

    public function update(ParserService $parserService)
    {
        $str = Input::get('data');
        $data = json_decode($str);
        $hash = isset($data->hash) ? $data->hash : null;
        if ($hash && auth()->check()) {
            $parser = $parserService->update($hash, $data);
        } else {
            $parser = $parserService->create($data);
        }

        return redirect($parser->url());
    }

    public function fork($hash, ParserService $parserService)
    {
        /**
         * @var Parser
         */
        $new = $parserService->fork($hash);

        return redirect(route('parser.index', [
            'hash' => $new->hash,
        ]));
    }

    public function getSharedParser($hash, ParserService $parserService)
    {
        $parser = $parserService->show($hash);
        $parser->load(['scripts', 'user']);

        return $parser;
    }
}
