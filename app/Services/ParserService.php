<?php

namespace Parserbin\Services;


use Parserbin\Exceptions\ParserAccessDeniedException;
use Parserbin\Models\Language;
use Parserbin\Models\Parser;
use Parserbin\Models\Script;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class ParserService
{
    public function show($hash)
    {
        return Parser::whereHash($hash)
            ->first()
            ->updateLastActivity();
    }

    /**
     * @param $hash
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|null|object|Parser|static
     * @throws ParserAccessDeniedException
     */
    public function update($hash, $data)
    {
        $parser = Parser::whereHash($hash)->first();

        if (!$parser->is_mine)
            throw new ParserAccessDeniedException();

        $parser->title = $data->title;
        $parser->input = $data->input;
        $parser->scripts()->delete();
        $parser->save();

        $script = new Script();
        $script->language()->associate(Language::default());
        $script->parser()->associate($parser);
        $script->content = $data->script;
        $script->save();

        return $parser;
    }

    public function create($data)
    {
        $parser = new Parser();
        $parser->hash = Parser::generateFreeHash();
        $parser->title = $data->title;
        $parser->input = $data->input;

        if (auth()->check()) {
            $parser->user()->associate(auth()->user());
        }

        $parser->save();

        $script = new Script();
        $script->language()->associate(Language::default());
        $script->parser()->associate($parser);
        $script->content = $data->script;
        $script->save();

        return $parser;
    }

    public function fork($hash)
    {
        return Parser::whereHash($hash)->fork();
    }
}
