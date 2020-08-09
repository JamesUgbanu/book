<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Book;

class ApiController extends Controller
{
    //Method to get book from an external book api
      public function getExternalBook(Request $request) {
        try {
            $client = new Client();
            $book = $client->get('https://www.anapioficeandfire.com/api/books?name='.$request->name);
            return $this->responseJson($book->getStatusCode(), "success", $books);     
        }  catch (\Exception $ex) {
            return $this->responseJson(500, "error", null, "Server error");
          }    
      }

      //Method to add a book
      public function addBook(Request $request) {
          try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'isbn' => 'required|string|max:20',
                'authors' => 'required|array',
                'number_of_pages' => 'required|integer|min:1',
                'publisher' => 'required|string',
                'country' => 'required|string',
                'release_date' => 'required|date_format:Y-m-d',
            ]);
            if ($validator->fails()) {
                return $this->responseJson(200, "error", null, $validator->messages());
            }
            $book = Book::create($request->all());
            return $this->responseJson(201, "success", $book);

          } catch (\Exception $ex) {
            return $this->responseJson(500, "error", null, "Server error");
          }
      }

      //Method to get all books
      public function getAllBooks(Request $request) {
        try {
            $country = $request->country;
            $publisher = $request->publisher;
            $release_date = $request->release_date;

            $books = Book::where('country', 'like', "%{$country}%")
                 ->where('publisher', 'like', "%{$publisher}%")
                 ->where('release_date', 'like', "%{$release_date}%")
                 ->get();
            return $this->responseJson(200, "success", $books);

        } catch (\Exception $ex) {
            return $this->responseJson(500, "error", null, "Server error");
          }
      }
  
      //Method to get book by id
      public function getBook($id) {
          try {
            if (Book::where('id', $id)->exists()) {
                $book = Book::where('id', $id)->get();
                return $this->responseJson(200, "success", $book);
              }

              return $this->responseJson(200, "success", null, "Book not found");

          } catch (\Exception $ex) {
            return $this->responseJson(500, "error", null, "Server error");
          }
      }
  
      //Method to get update a book by id
      public function updateBook(Request $request, $id) {
          try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'isbn' => 'string|max:20',
                'number_of_pages' => 'integer|min:1',
                'publisher' => 'string',
                'country' => 'string',
                'release_date' => 'date_format:Y-m-d',
            ]);
            if ($validator->fails()) {
                return $this->responseJson(200, "error", null, $validator->messages());
            }
            
            $book = Book::find($id);
            $book->update($request->all());

            if($book) {
                return $this->responseJson(200, "success",  $book, "The book ".$book->name." was updated successfully");
              
            }
            return $this->responseJson(200, "success",  null, "Book not found");
              
          } catch (\Exception $ex) {
            return $this->responseJson(500, "error", null, "Server error");
          }
      }
  
      //Method to delete a book by id
      public function deleteBook($id) {
        try {
            if(Book::where('id', $id)->exists()) {
                $book = Book::find($id);
                $book->delete();
                return $this->responseJson(204, "success",  [], "The book ".$book->name." was deleted successfully");
              }
              return $this->responseJson(200, "success",  null, "Book not found");

        } catch (\Exception $ex) {
            return $this->responseJson(500, "error", null, "Server error");
          }
      }

      //Helper method
      public function responseJson($status_code, $status, $data=null, $message=null) {
        return response()->json([
            "status_code"=> $status_code,
            "status" =>  $status,
            "data" => $data,
            "message" => $message,
        ], $status_code);
      }
}
