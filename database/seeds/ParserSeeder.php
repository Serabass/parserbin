<?php

use Illuminate\Database\Seeder;

class ParserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Parserbin\Models\Parser::truncate();
        factory(\Parserbin\Models\Parser::class, 50)->create();
    }
}
