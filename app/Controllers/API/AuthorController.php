<?php

namespace App\Controllers\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Phase3\AuthorModel;
use Firebase\JWT\JWT;
use App\Models\TokenBlacklisted;

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
        $validationRules = array(
            "email" => array(
                "rules" => "required",
            ),
            "password" => array(
                "rules" => "required",
            )
        );

        if(!$this->validate($validationRules)){

            return $this->respond([
                "status"=> false,
                "message" => "All fields are required",
                "errors" => $this->validator->getErrors()
            ]);
        }

        // Check Author By Email
        $authorData = $this->model->where("email", $this->request->getVar("email"))->first();
        if($authorData){

            if(password_verify($this->request->getVar("password"), $authorData['password'])){

                //Author Exists
                $key = getenv("JWT_KEY");

                $payloadData = [
                    "iss" => "localhost",
                    "aud" => "localhost",
                    "iat" => time(),
                    "exp" => time() + 3600, //token value will be expired after current time addon of 1 hour
                    "user" => [
                        "id" => $authorData['id'],
                        "email" => $authorData["email"]
                    ]
                ];

                $token = JWT::encode($payloadData, $key, 'HS256');

                return $this->respond([
                    "status" => true,
                    "message" => "User logged in",
                    "token" => $token
                ]);
            }else{

                return $this->respond([
                    "status" => false,
                    "message" => "Login failed due to incorrect password"
                ]);
            }
        }else{

            return $this->respond([
                "status" => false,
                "message" => "Login failed due to incorrect Email Value"
            ]);
        }
    }

    //Profile Method
    // [GET] -> Protected Method -> Valid Token in req header
    public function authorProfile(){

        return $this->respond([
            "status" => true,
            "message" => "Author Profile Information",
            "data" => $this->request->userData
        ]);
    }

    //Logout Method
    // [GET] -> Protected Method -> Valid Token in req header
    public function logout(){

        $token = $this->request -> jwtToken;
        $tokenBlacklistedObject = new TokenBlacklisted();
        
        if($tokenBlacklistedObject ->insert(["token" => $token])){

            return $this->respond([
                "status" => true,
                "message" => "Author is logged out",
            ]);
        }else{
            
            return $this->respond([
                "status" => false,
                "message" => "failed to logged out",
            ]);
        }
    }

}   
