@extends('layouts.master')


@section('title')
    View all Books
@endsection

@section('content')
    @foreach($books as $book)
        <h2>{{ $book->title }}</h2>
        <img src='{{ $book->cover }}'>
        <a href='/books/{{ $book->id }}/edit'>Edit</a>
    @endforeach
@endsection
