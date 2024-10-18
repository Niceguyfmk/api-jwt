System - Author & Books

To create a book, author has to sign in and then create a book.
 
Migration: 

Table names: author, books

Columns: 

Authors:  id (primary key), name, email, password, phone_no, created_at

Books: id, author_id(fk), name, publication, cost, created_at

Resource Controllers - Author Controller, Book Controller

Models -  AuthorModel, BookModel

Routes:

/auth/register -> [POST] -> name, email, password, phone_no
/auth/login -> [POST] -> email, password (Token value - JWT)

/author/profile -> [GET] -> Protected Route
/author/logout -> [GET] -> Protected Route


Books API
/author/add-book -> [POST] -> {Protected Route} -> name, publication, cost
/author/list-book -> [GET] -> {Protected Route} 
/author/delete-book/{book_id} -> [DELETE] -> {Protected Route} 


