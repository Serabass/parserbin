<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Parserbin\User::truncate();
        factory(\Parserbin\User::class, 50)->create();
    }
}
