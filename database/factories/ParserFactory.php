<?php

$factory->define(\Parserbin\Models\Parser::class, function (Faker\Generator $faker) {

    $parent = \Parserbin\Models\Parser::inRandomOrder()->first();

    return [
        'title' => $faker->text(40),
        'hash' => $faker->shuffleString('1234567890abcdef'),
        'user_id' => \Parserbin\User::inRandomOrder()->first()->id,
        'parent_id' => !empty($parent) ? $parent->id : null,
        'input' => $faker->text(400),
        'indexable' => $faker->boolean,
    ];
});
