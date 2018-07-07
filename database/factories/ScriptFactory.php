<?php

$factory->define(\Parserbin\Models\Script::class, function (Faker\Generator $faker) {
    return [
        'content' => 'return input + input;',
        'parserId' => \Parserbin\Models\Parser::inRandomOrder()->first()->id,
        'languageId' => \Parserbin\Models\Language::inRandomOrder()->first()->id,
    ];
});
