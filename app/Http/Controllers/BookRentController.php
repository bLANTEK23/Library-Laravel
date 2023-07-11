<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\RentLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    function index()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = Book::all();
        return view ('book-rent', ['users' => $users, 'books' => $books]);
    }

    function store(Request $request) 
    {
        $request['rent_date'] = Carbon::now()->toDateString();
        $request['renturn_date'] = Carbon::now()->addDay(3)->toDateString();
        
        $book = Book::findOrFail($request->book_id)->only('status');

        if($book['status'] != 'in stock') {
            Session::flash('message', 'Cannot rent, the book is not available'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect('book-rent');
        } else {
            $count = RentLogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count();
            
            if($count >= 3) {
                Session::flash('message', 'Cannot rent, user has reach limit of book'); 
                Session::flash('alert-class', 'alert-danger'); 
                return redirect('book-rent');
            } else {
                try {
                     DB::beginTransaction();
                    //proses insert to rent_log table
                    RentLogs::create($request->all());
                    //process update book table
                    $book = Book::findOrFail($request->book_id);
                    $book->status = 'not available';
                    $book->save();
                    DB::commit();
    
                    Session::flash('message', 'Rent Book success'); 
                    Session::flash('alert-class', 'alert-success'); 
                    return redirect('book-rent');
                } catch (\Throwable $th) {
                    DB::rollBack();
                }

            }
        }
    }

    function returnBook()  
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get();
        $books = Book::all();
        return view('return-book', ['users' => $users, 'books' => $books]);
    }

    function saveReturnBook(request $request) 
    {
        // user & buku yang dipilih untuk di return benar, maka berhasil return book
        //user & buku yang dipilih untukdi return salah, maka muncul error notice

        $rent = RentLogs::where('user_id', $request->user_id)->where('book_id', $request->book_id)->where('actual_return_date',  null);
        $rentData = $rent->first();
        $countData = $rent->count();
        
        if ($countData == 1) {
            $rentData->actual_return_date = Carbon::now()->toDateString();
            $rentData->save();

            Session::flash('message', 'The book is returned successfully'); 
            Session::flash('alert-class', 'alert-success'); 
            return redirect('book-return');
        }
        else {
            Session::flash('message', 'There is error in process'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect('book-return');
        }
    }
}
