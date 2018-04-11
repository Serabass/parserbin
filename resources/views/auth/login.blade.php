@extends('general')
@section('content')

    <div class="login-card">
        <h1>Log In</h1><br>
        <form action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}
            <input type="text" name="email" placeholder="E-Mail">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" class="login login-submit" value="login">
        </form>

        @include('auth.social-icons')

        <div class="login-help">
            <a href="{{ route('register') }}">Register</a> • <a href="/password/reset">Forgot Password</a>
        </div>
    </div>

    <!-- <div id="error"><img src="https://dl.dropboxusercontent.com/u/23299152/Delete-icon.png" /> Your caps-lock is on.</div> -->

@endsection
