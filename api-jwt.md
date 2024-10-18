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

/auth/register -> [POST] -> name, email, password, phone_no -> completed
/auth/login -> [POST] -> email, password (Token value - JWT) -> completed

/author/profile -> [GET] -> Protected Route -> completed
/author/logout -> [GET] -> Protected Route


Books API
/author/add-book -> [POST] -> {Protected Route} -> completed
/author/list-book -> [GET] -> {Protected Route} -> completed
/author/delete-book/{book_id} -> [DELETE] -> {Protected Route} -> completed


//Insert vs Save Method
Insert: This method is typically used to add a new record to the database. It usually requires the full data for the new record and does not modify existing records. If you try to use insert with an existing record (e.g., one that has a primary key already in the database), it will usually result in an error.

Save: This method is often more versatile. It can be used to either insert a new record or update an existing record, depending on whether the record already exists in the database. The save method usually checks if the primary key (or another unique identifier) is present; if it is, it updates the existing record, and if not, it inserts a new one.

