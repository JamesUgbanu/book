<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Book;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCreatedBookSuccessfully()
    {

        $data = [
            "name"=> "A Game of Thrones nice again",
            "isbn"=> "978-0553103540",
            "authors"=> ["George R. R. Martin"],
            "number_of_pages"=> "695",
            "publisher"=> "Bantam Books",
            "country"=> "United States",
            "release_date"=> "1990-02-02",
        ];
        $this->json('POST', 'api/v1/books', $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
            "status_code"=> 201,
            "status" =>  "success",
            ]);
    }

    public function testRetrieveBookSuccessfully()
    {

        factory(Book::class)->create([
            "name"=> "A Game of Thrones nice again",
            "isbn"=> "978-0553103540",
            "authors"=> ["George R. R. Martin"],
            "number_of_pages"=> "695",
            "publisher"=> "Bantam Books",
            "country"=> "United States",
            "release_date"=> "1990-02-02",
        ]);
        $this->json('GET', 'api/v1/books', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
            "status_code"=> 200,
            "status" =>  "success",
            ]);
    }

    public function testRetrieveExternalBookSuccessfully()
    {
        $this->json('GET', 'api/external-books', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
            "status_code"=> 200,
            "status" =>  "success",
            ]);
    }

    public function testUpdatedBookSuccessfully()
    {
        factory(Book::class)->create([
            "name"=> "A Game of Thrones nice again",
            "isbn"=> "978-0553103540",
            "authors"=> ["George R. R. Martin"],
            "number_of_pages"=> "695",
            "publisher"=> "Bantam Books",
            "country"=> "United States",
            "release_date"=> "1990-02-02",
        ]);

        $data = [
            "name"=> "A Game of Thrones nice again and again",
            "isbn"=> "978-0553103540",
            "authors"=> ["George R. R. Martin"],
            "number_of_pages"=> "695",
            "publisher"=> "Bantam Books",
            "country"=> "United States",
            "release_date"=> "1990-02-02",
        ];

        $this->json('PUT', 'api/v1/books/1', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
            "status_code"=> 200,
            "status" =>  "success",
            ]);
    }

    public function testDeleteBook()
    {
        factory(Book::class)->create([
            "name"=> "A Game of Thrones nice again",
            "isbn"=> "978-0553103540",
            "authors"=> ["George R. R. Martin"],
            "number_of_pages"=> "695",
            "publisher"=> "Bantam Books",
            "country"=> "United States",
            "release_date"=> "1990-02-02",
        ]);

        $this->json('DELETE', 'api/v1/books/1', [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
