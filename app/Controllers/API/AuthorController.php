<?php

namespace App\Controllers\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Phase3\AuthorModel;
use Firebase\JWT\JWT;


class AuthorController extends ResourceController
{
    protected $modelName = AuthorModel::class;
    protected $format = "json"; 

    //Register Method 
    // [POST] -> name, email, password, phone_no
    public function registerAuthor(){
        $validationRules = array(
            'name' => array(
                "rules" => "required|min_length[3]",
                "errors"=> array(
                    "required" => "Name is required",
                    "min_length" => "Name must be at least 3 characters long"
                )
            ),
            'email'=> array(
                "rules" => "required|min_length[10]|is_unique[authors.email]",
                "errors"=> array(
                    "required" => "Email is required",
                    "min_length" => "Email must be at least 10 characters long",
                    "is_unique"=> "Email already exists"
                )
            ),
            'password'=> array(
                "rules" => "required|min_length[3]|",
                "errors"=> array(
                    "required" => "Password is required",
                    "min_length" => "Password must be at least 3 characters long"
                )
            ),
        );

        if(!$this->validate($validationRules)){
            return $this->respond(array(
                "status" => false,
                "message" => "Form Submission failed",
                "errors" => $this->validator->getErrors()
            ));
        }

        //getPost()
        $AuthorData = [
            "name" => $this->request->getVar("name"),
            "email" => $this->request->getVar("email"), 
            "password" => password_hash($this->request->getVar("password"), PASSWORD_DEFAULT),
            "phone_no" => $this->request->getVar("phone_no")
        ];

        //Save Author 
        if($this->model->registerAuthor($AuthorData)){

            return $this->respond([
                "status" => true,
                "message" => "Author Registered Successfully"
            ]);
        }else{

            return $this->respond([
                "status" => false,
                "message" => "Failed to register Author"
            ]);
        }
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
