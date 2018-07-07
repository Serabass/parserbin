<?php

namespace Parserbin\Console\Commands;

use Illuminate\Console\Command;
use Parserbin\User;

class CreateAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:admin {--password= : Password for admin user} {--email= : Email for admin user} {--name= : Name for admin user}';

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
        $password = $this->option('password');
        $email = $this->option('email');
        $name = $this->option('name');
        $user = new User();

        $user->name = isset($name) ? $name : 'Serabass';
        $user->email = isset($email) ? $email : 'serabass565@gmail.com';
        $user->password = bcrypt($password);
        $user->remember_token = str_random(10);
        $user->is_admin = 1;
        $user->save();
    }
}
