<?php

namespace App\Controllers\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Phase3\AuthorModel;

class AuthorController extends ResourceController
{
    protected $modelName = AuthorModel::class;
    protected $format = "json"; 

    //Register Method 
    // [POST] -> name, email, password, phone_no
    public function registerAuthor(){

    }

    //Login Method
    // [POST] -> email, password
    public function loginAuthor(){

    }

    //Profile Method
    // [GET] -> Protected Method -> Valid Token in req header
    public function authorProfile(){}

    //Logout Method
    // [GET] -> Protected Method -> Valid Token in req header
    public function logout(){}

}
