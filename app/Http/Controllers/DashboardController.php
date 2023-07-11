<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $BookCount = Book::count();
        $CategoryCount = Category::count();
        $UserCount = User::count();
        return view('dashboard', ['book_count' => $BookCount, 'category_count' => $CategoryCount, 'user_count' => $UserCount]);
    }
}
