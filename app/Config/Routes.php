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
$routes->group("author", ["namespace" => "App\Controllers\API"], function($routes){

    //Author Routes
    $routes->get("/auth/profile", "API\AuthorController::authorProfile");
    $routes->get("/auth/logout", "API\AuthorController::logout");

    //Book Routes
    $routes->get("add-book", "API\BookController::createBook");
    $routes->get("list-book", "API\BookController::authorBooks");
    $routes->get("delete-book/(:num)", "API\BookController::deleteAuthorBook/$1");

});
