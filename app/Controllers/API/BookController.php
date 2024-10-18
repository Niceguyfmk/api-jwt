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
        $validationRules = [
            "name" => [
                "rules" => "required" 
            ],
            "cost" => [
                "rules" => "required" 
            ]
        ];

        if(!$this->validate($validationRules)){

            return $this->respond([
                "status" => false,
                "message" => "Please provide the required fields",
                "errors" => $this->validator->getErrors()
            ]);
        }

        //Save book
        $tokenInformation = $this->request->userData; 
        $userId = $tokenInformation['user']->id;
        $bookData = [
            "author_id" => $userId,
            "name"=> $this->request->getVar("name"),
            "publication" => $this->request->getVar("publication"),
            "cost" => $this->request->getVar("cost")
        ];

        if($this->model->newBook($bookData)){

            return $this->respond([
                "status" => true,
                "message" => "Book created successfully"
            ]);
        }else{

            return $this->respond([
                "status" => false,
                "message" => "Failed to create Book"
            ]);
        }
    }

    //List Books
    // [GET] -> Protected Method -> Valid Token value to access it 
    // author_id
    public function authorBooks(){
        $tokenInformation = $this->request->userData; 
        $userId = $tokenInformation['user']->id;

        $books = $this->model->findAuthorBooks("author_id", $userId);

        if($books){

            return $this->respond([
                "status" => true,
                "message" => "Books Found",
                "Books" => $books
            ]);
        }else{

            return $this->respond([
                "status" => false,
                "message" => "No Books Found"
            ]);
        }
        
    }

    //Delete a Book
    // [DELETE] -> Protected Method -> Valid Token value to access it 
    // author_id
    public function deleteAuthorBook($book_id){

    }
}
