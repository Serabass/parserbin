@extends('general')
@section('content')
    <form action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}
        <table>
            <tr>
                <td><input type="email" name="email" /> </td>
                <td><input type="password" name="password" /> </td>
                <td>
                    <input type="submit" value="Log in!">
                </td>
            </tr>
        </table>
    </form>
@endsection
