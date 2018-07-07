<?php

use Illuminate\Database\Seeder;

class ScriptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Parserbin\Models\Script::truncate();
        factory(\Parserbin\Models\Script::class, 50)->create();
    }
}
