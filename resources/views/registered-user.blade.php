@extends('layouts.mainlayout')

@section('title', 'Users')
@section('content')
<h1>New Registered User List</h1>

<div class="mt-5 d-flex justify-content-end">
    <a href="/Users" class="btn btn-primary">Approved User List</a>
</div>

<div class="mt-5">
    @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
    @endif
</div>

<div class="my-5">
    <table class="table">
        <thead>
            <tr>
                <th>No. </th>
                <th>Username</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registeredUsers as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->username}}</td>
                <td>
                   @if ($item->phone)
                        {{$item->phone}}
                   @else
                     -
                   @endif
                </td>
                <td>
                    <a href="/user-detail/{{$item->slug}}">detail</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection