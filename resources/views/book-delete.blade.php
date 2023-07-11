@extends('layouts.mainlayout')

@section('title', 'Delete Book')

@section('content')
    <h2>Are you sure to delete category {{$book->title}}</h2>
    <div class="mt-5">
        <a href="/book-destory/{{$book->slug}}" class="btn btn-danger me-3">Sure</a>
        <a href="/books" class="btn btn-info">Cancel</a>
    </div>
@endsection
