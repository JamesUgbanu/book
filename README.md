# A Simple REST API CRUD With Laravel
Make REST API CRUD Laravel

To install crud API laravel :
1. You can change .env for connect database.
2. you can use migrate database first with <code>php artisan migrate</code> for import database tou your database.
3. <code>php artisan serve</code> or <code>php artisan serve --port=8080</code> to run on port 8080
4. Add new book : http://localhost:8080/api/v1/books (POST)
7. View All books : http://localhost:8080/api/v1/books (GET) -> you can add query string to the endpoint
<code>http://localhost:8080/api/v1/books?country=nigeria</code>
8. View a book : http://localhost:8080/api/v1/books/{id} (GET)
9. Update a book : http://localhost:8080/api/v1/books/{id} (PUT)
10. Delete book : http://localhost:8080/api/v1/books/{id} (DELETE)

Any question? please send me email to jamesugbanu@gmail.com (https://crystalwebpro.com)
