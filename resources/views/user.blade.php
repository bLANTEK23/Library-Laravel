@extends('layouts.mainlayout')

@section('title' , 'Users')

@section('content')
<h1>User List</h1>

<div class="mt-5 d-flex justify-content-end">
    <a href="/user-banned" class="btn btn-secondary me-3">View Banned User</a>
    <a href="/registered-users" class="btn btn-primary"> New Register User</a>
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
            @foreach ($users as $item)
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
                        <a href="/user-ban/{{$item->slug}}">Ban User</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection