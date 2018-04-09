<?php

namespace Parserbin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Parserbin\User;

class UserController extends Controller
{
    public function me()
    {
        $me = User::with('parsers')->whereId(Auth::id())->first();
        dump($me->parsers);
        die;
    }
}
