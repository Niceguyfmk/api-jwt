<?php

namespace App\Controllers\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Phase3\BookModel;


class BookController extends ResourceController
{
    protected $modelName = BookModel::class;
    protected $format = "json"; 

    //Add Book
    // [POST] -> Protected Method -> Valid Token value to access it 
    // author_id, name, publication, cost
    public function createBook(){

    }

    //List Books
    // [GET] -> Protected Method -> Valid Token value to access it 
    // author_id
    public function authorBooks(){

    }

    //Delete a Book
    // [DELETE] -> Protected Method -> Valid Token value to access it 
    // author_id
    public function deleteAuthorBook($book_id){

    }
}
