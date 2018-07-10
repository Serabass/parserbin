<?php

$factory->define(\Parserbin\Models\Script::class, function (Faker\Generator $faker) {
    return [
        'content'     => 'return input + input;',
        'parser_id'   => \Parserbin\Models\Parser::inRandomOrder()->first()->id,
        'language_id' => \Parserbin\Models\Language::inRandomOrder()->first()->id,
    ];
});
