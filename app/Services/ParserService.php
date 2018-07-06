<?php

namespace Parserbin\Services;


use Parserbin\Models\Language;
use Parserbin\Models\Parser;
use Parserbin\Models\Script;

class ParserService
{
    public function show($hash)
    {
        return Parser::whereHash($hash)
            ->first()
            ->updateLastActivity();
    }

    public function update($data)
    {
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

        return $parser;
    }

    public function fork($hash)
    {
        return Parser::whereHash($hash)->fork();
    }
}
