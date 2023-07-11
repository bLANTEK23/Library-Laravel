<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('book', ['books' => $books]);
    }

    public function add() 
    {
        $categories = Category::all();
        return view('book-add', ['categories' => $categories]);

    }

    public function store(request $request) 
    {
        $validated = $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'title'=> 'required|max:255'
        ]);

        $newName ='';
        if($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'-'.$extension;
            $request->file('image')->storeAs('cover', $newName);
        }

        $request['cover'] = $newName;

        $books = Book::create($request->all());
        $books->categories()->sync($request->categories);
        return redirect('books')->with('status', 'Book Added Seccessfuly');
    }

    function edit($slug) 
    {
        $book = Book::where('slug', $slug)->first();
        $categories = Category::all();
        return view('book-edit', ['categories' => $categories, 'book' => $book]);    
    }

    public function update(Request $request, $slug) 
    {
        $newName ='';
        if($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title.'-'.now()->timestamp.'-'.$extension;
            $request->file('image')->storeAs('cover', $newName);
            $request['cover'] = $newName;
        }

        
        $book = Book::where('slug', $slug)->first();
        $book->update($request->all());
        if($request->categories) {
            $book->categories()->sync($request->categories);

        }
        return redirect('books')->with('status', 'Book  Seccessfuly');
    }

    Public function delete($slug) 
    {
        $book = Book::where('slug', $slug)->first();
        return view('book-delete', ['book' => $book]);    
    }

    Public function destory($slug) 
    {
        $book = Book::where('slug', $slug)->first();
        $book->delete();
        return redirect('books')->with('status', 'book delete Success');
    }

    Public function deletedBook()
    {
        $deletedBook = Book::onlyTrashed()->get();
        return view ('book-deleted-list', ['deletedBook' => $deletedBook]);
    }

    function restore($slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->first();
        $book->restore();
        return redirect ('books')->with('status', 'Category restore Succes');
    }
}