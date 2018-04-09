<?php

namespace Parserbin\Console\Commands;

use Illuminate\Console\Command;
use Parserbin\User;

class SandboxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::create([
            'name'     => 'Serabass',
            'email'    => 'is_everything@mail.ru',
            'password' => bcrypt('secret'),
        ]);
    }
}
