<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Book;

class BookController extends Controller
{
    public function __invoke(): View
    {
        $callable = new Book();

        return $callable->getBooks();
    }
}
