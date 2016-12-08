<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;
use App\Author;
use App\Tag;

use Session;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('book.index')->with(['books' => $books]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $this->validate($request, [
            'title'         => 'required|min:3',
            'published'     => 'required|min:4|numeric',
            'cover'         => 'required|url',
            'purchase_link' => 'required|url'

        ]);

        $book = new Book();
        $book->title         = $request->input('title');
        $book->published     = $request->input('published');
        $book->cover         = $request->input('cover');
        $book->purchase_link = $request->input('purchase_link');

        // add book to db
        $book->save();


        Session::flash('flash_message', 'Your book '.$book->title.' was added.');
        return redirect('/books');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $title
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('book.show')->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        // get authors
        $authors = Author::orderBy('last_name', 'ASC')->get();

        // get author info for dropdown
        $authors_for_dropdown = [];
        foreach ($authors as $author) {
            $authors_for_dropdown[$author->id] = $author->last_name;
        }

        // get tags
        $tags = Tag::orderBy('name', 'ASC')->get();
        $tags_for_checkboxes = [];
        foreach ($tags as $tag) {
            $tags_for_checkboxes[$tag->id] = $tag->name;
        }

        // just the tags for this book
        $tags_for_this_book = [];
        foreach ($book->tags as $tag) {
            $tags_for_this_book[] = $tag->name;
        }
        return view('book.edit')->with([
            'book' => $book,
            'authors_for_dropdown' => $authors_for_dropdown,
            'tags_for_checkboxes' => $tags_for_checkboxes,
            'tags_for_this_book'  => $tags_for_this_book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // validate
        $this->validate($request, [
            'title'         => 'required|min:3',
            'published'     => 'required|min:4|numeric',
            'cover'         => 'required|url',
            'purchase_link' => 'required|url'

        ]);

        $book = Book::find($request->id);
        $book->title         = $request->title;
        $book->cover         = $request->cover;
        $book->published     = $request->published;
        $book->author_id     = $request->author_id;
        $book->purchase_link = $request->purchase_link;

        $book->save();

        # If there were tags selected...
        if($request->tags) {
            $tags = $request->tags;
        }
        # If there were no tags selected (i.e. no tags in the request)
        # default to an empty array of tags
        else {
            $tags = [];
        }

        # Above if/else could be condensed down to this: $tags = ($request->tags) ?: [];

        # Sync tags
        $book->tags()->sync($tags);
        $book->save();

        Session::flash('flash_message', 'Your changes to '.$book->title.' were saved.');
        return redirect('/books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
