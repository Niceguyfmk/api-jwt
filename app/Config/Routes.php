<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


//Open Routes -> don't need token value
$routes->post("/auth/register", "API\AuthorController::registerAuthor");
$routes->post("/auth/login", "API\AuthorController::loginAuthor"); //valid token value generated

//Protected API Routes
$routes->group("author", ["namespace" => "App\Controllers\API", "filter" => "jwt_auth"], function($routes){

    //Author Routes
    $routes->get("profile", "AuthorController::authorProfile");
    $routes->get("logout", "AuthorController::logout");

    //Book Routes
    $routes->post("add-book", "BookController::createBook");
    $routes->get("list-book", "BookController::authorBooks");
    $routes->get("delete-book/(:num)", "BookController::deleteAuthorBook/$1");

});
