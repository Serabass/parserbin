<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Parserbin\User;

class UserController extends Controller
{
    public function me()
    {
        $me = User::whereId(Auth::id())->first();

        return view('user.me', [
            'me' => $me,
        ]);
    }

    public function parsers()
    {
        $me = User::with('parsers')->whereId(Auth::id())->first();

        return view('user.parsers', [
            'me' => $me,
        ]);
    }
}
