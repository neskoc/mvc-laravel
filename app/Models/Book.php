<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $connection = 'sqlite';
    protected $table = 'book';
    protected $primaryKey = 'book_id';
    /**
     * Indicates if the model's ID is auto-incrementing.
    */
    public $incrementing = true;
    /**
     * Indicates if the model should be timestamped.
     * created_at and updated_at column must be present
    */
    public $timestamps = true;

    public function getBooks()
    {
        $data = [
            "header" => "Bookshelf",
            "books" => $this::all()
        ];

        return view("books", $data);
    }
}
