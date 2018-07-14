<?php

namespace Tests\Unit;

use Parserbin\Models\Parser;
use Parserbin\Services\ParserService;
use Tests\TestCase;

class ParserServiceTest extends TestCase
{
    /**
     * @var ParserService
     */
    protected $parserService;

    public function setUp()
    {
        parent::setUp();
        $this->parserService = app()->make(ParserService::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        /**
         * @var $randomParser Parser
         */
        $randomParser = Parser::inRandomOrder()->first();

        $parser = $this->parserService->show($randomParser->hash);
        $this->assertEquals($parser->hash, $randomParser->hash);
        $this->assertEquals($parser->parentId, $randomParser->parentId);
        $this->assertEquals($parser->url(), $randomParser->url());
        $this->assertEquals($parser->embedUrl(), $randomParser->embedUrl());
    }
}
