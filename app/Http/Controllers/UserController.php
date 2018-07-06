<?php

namespace Parserbin\Http\Controllers;

use Parserbin\User;

class UserController extends Controller
{
    public function me()
    {
        return view('user.me', [
            'me' => User::me(),
        ]);
    }

    public function parsers()
    {
        return view('user.parsers', [
            'me' => User::me()
        ]);
    }

    public function show($username) {

        $user = User::whereName($username)->first();

        return view('user.me', [
            'me' => $user
        ]);
    }
}
