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
        \Parserbin\User::create([
            'name'           => 'Serabass',
            'email'          => 'serabass565@gmail.com',
            'password'       => bcrypt('secret'),
            'remember_token' => str_random(10),
        ]);
        factory(\Parserbin\User::class, 50)->create();
    }
}
