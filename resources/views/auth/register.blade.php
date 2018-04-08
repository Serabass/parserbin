@extends('general')
@section('content')

    <div class="login-card">
        <h1>Register</h1><br>
        <form action="{{ route('register') }}" method="POST">
            {{ csrf_field() }}
            <input type="text" name="name" placeholder="Name" />
            <input type="text" name="email" placeholder="E-Mail" />
            <input type="password" name="password" placeholder="Password" />
            <input type="submit" name="login" class="login login-submit" value="Register">
        </form>

        <div class="login-help">
            <a href="{{ route('login') }}">I already have an account</a>
        </div>
    </div>

@endsection