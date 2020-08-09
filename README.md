# A Simple REST API CRUD With Laravel
Make REST API CRUD Laravel

## Installation

Just clone the project to anywhere in your computer.
cd to book

To install crud API laravel :
1. Add your database connection settings to .env. -> Example of mine <code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book
DB_USERNAME=root
DB_PASSWORD=</code>
2. Migrate database with <code>php artisan migrate</code> to create your database.
3. <code>php artisan serve</code> or <code>php artisan serve --port=8080</code> to run on port 8080
4. Add new book : http://localhost:8080/api/v1/books (POST)
7. View All books : http://localhost:8080/api/v1/books (GET) -> you can add query string to the endpoint <code>http://localhost:8080/api/v1/books?country=nigeria</code>
8. View a book : http://localhost:8080/api/v1/books/{id} (GET)
9. Update a book : http://localhost:8080/api/v1/books/{id} (PUT)
10. Delete book : http://localhost:8080/api/v1/books/{id} (DELETE)
10. View external book : http://localhost:8080/api/external-books (GET)
12. You can run test with <code>php artisan test</code>

## Testing with Postman

![alt text](https://github.com/JamesUgbanu/book/blob/master/postman%20test.PNG)

Any question? please send me email to jamesugbanu@gmail.com (https://crystalwebpro.com)
