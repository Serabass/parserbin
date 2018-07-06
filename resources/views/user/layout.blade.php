@extends('general')

@section('content')
    <div class="links profile-links">
        {{--<a href="{{ route('me.index') }}">Me</a>--}}
        <a href="{{$me->url()}}">Common</a>
        <a href="{{route('user.parsers', ['username' => $me->name])}}">My parsers</a>
    </div>

    <div class="profile-content">
        @yield('me.content')
    </div>
@endsection
