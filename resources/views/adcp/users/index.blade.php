@extends('template')

@section('main')
    <h2>Users</h2>

    <table class="table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->description !!}</td>
            <td><a href="{!! route('adcp.users.edit',$user->id) !!}">Edit</a></td>
        </tr>
    @endforeach
    </table>
@stop