@extends('user.layout')

@section('me.content')
    <div>
        {{ $me->email }}
    </div>
@endsection
