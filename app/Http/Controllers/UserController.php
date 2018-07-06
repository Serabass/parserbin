<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Parserbin\User;

class UserController extends Controller
{
    private $me;

    public function __construct()
    {
        $this->me = User::me();
    }

    public function me()
    {
        return view('user.me', [
            'me' => $this->me,
        ]);
    }

    public function parsers()
    {
        return view('user.parsers', [
            'me' => $this->me
        ]);
    }
}
