@extends('layouts.master')


@section('title')
    Add Book
@stop


{{--
This `head` section will be yielded right before the closing </head> tag.
Use it to add specific things that *this* View needs in the head,
such as a page specific stylesheets.
--}}
@section('head')
    <link href="/css/books/create.css" type='text/css' rel='stylesheet'>
@stop


@section('content')
    <form method="post">
        <label for="f_title">Title: </label>
        <input id="f_title" type="text" name="title"><br>
        <label for="f_author">Author: </label>
        <input id="f_author" type="text" name="author">
    </form>
@stop


{{--
This `body` section will be yielded right before the closing </body> tag.
Use it to add specific things that *this* View needs at the end of the body,
such as a page specific JavaScript files.
--}}
@section('body')
    <script src="/js/books/create.js"></script>
@stop
