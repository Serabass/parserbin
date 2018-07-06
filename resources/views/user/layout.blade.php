@extends('general')

@section('content')
    <div class="links profile-links">
        {{--<a href="{{ route('me.index') }}">Me</a>--}}
        <a href="{{route('me.index')}}">Common</a>
        <a href="{{route('me.parsers')}}" id="logout">My parsers</a>
    </div>

    <div class="profile-content">
        @yield('me.content')
    </div>
@endsection
