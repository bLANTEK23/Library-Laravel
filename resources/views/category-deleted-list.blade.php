@extends('layouts.mainlayout')

@section('title', 'Deleted Category')

@section('content')
    <h1> Deleted Category List</h1>

    <div class="mt-5 d-flex justify-content-end">
        <a href="/categories" class="btn btn-primary">Back</a>
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
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deletedCategories as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="category-restore/{{$item->slug}}">Restore</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
