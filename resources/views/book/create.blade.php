@extends('layouts.master')

@section('title', 'Add a new book');

@section('head')
    <link href="/css/books/create.css" type='text/css' rel='stylesheet'>
@endsection


@section('content')
    <h1>Add a new book</h1>
    <form method="post" action="/books">
        {{ csrf_field() }}
        <label for="f_title">Title: </label>
        <input id="f_title" type="text" name="title" value="{{ old('title') }}">
        <input type="submit" name="submit" value="Add new book">

        @if(count($errors) > 0)
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        @endif

    </form>
@endsection


@section('body')
    <script src="/js/books/create.js"></script>
@endsection
