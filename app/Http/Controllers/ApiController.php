<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Book;

class ApiController extends Controller
{
    //

      public function getExternalBook(Request $request) {
        try {
            $client = new Client();
            $book = $client->get('https://www.anapioficeandfire.com/api/books?name='.$request->name);
            return response()->json([
                "status_code"=> $book->getStatusCode(),
                "status"=> "success",
                "data"=> json_decode($book->getBody()),
        ], $book->getStatusCode());
        
        }  catch (\Exception $ex) {
            return response()->json([
                "status_code"=> 500,
                "message" => "Server error"
            ], 500);
          }    
      }

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
                return response()->json([
                    "status_code"=> 200,
                    "status"=> "errror",
                    "message"=> $validator->messages(),
                ], 200);
            }
            $book = new Book;
            $book->name = $request->name;
            $book->isbn = $request->isbn;
            $book->authors = $request->authors;
            $book->number_of_pages = $request->number_of_pages;
            $book->publisher = $request->publisher;
            $book->country = $request->country;
            $book->release_date = $request->release_date;
            $book->save();
            
            return response()->json([
                "status_code"=> 201,
                "status"=> "success",
                "data"=> $book,
            ], 201);

          } catch (\Exception $ex) {
            return response()->json([
                "status_code"=> 500,
                "message" => "Server error"
            ], 500);
          }
      }

      public function getAllBooks(Request $request) {
        try {
            $country = $request->country;
            $publisher = $request->publisher;
            $release_date = $request->release_date;

            $books = Book::where('country', 'like', "%{$country}%")
                 ->where('publisher', 'like', "%{$publisher}%")
                 ->where('release_date', 'like', "%{$release_date}%")
                 ->get();

            return response()->json([
                "status_code"=> 200,
                "status"=> "success",
                "data"=> $books,
        ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                "status_code"=> 500,
                "message" => "Server error"
            ], 500);
          }
      }
  
  
      public function getBook($id) {
          try {
            if (Book::where('id', $id)->exists()) {
                $book = Book::where('id', $id)->get();
                return response()->json([
                    "status_code"=> 200,
                    "status"=> "success",
                    "data"=> $book,
                ], 200);
              } 
                return response()->json([
                  "status_code"=> 404,
                  "status"=> "success",
                  "message" => "Book not found"
                ], 404);
          } catch (\Exception $ex) {
            return response()->json([
                "status_code"=> 500,
                "message" => "Server error"
            ], 500);
          }
      }
  
      public function updateBook(Request $request, $id) {
          try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'isbn' => 'string|max:20',
                'authors' => 'array',
                'number_of_pages' => 'integer|min:1',
                'publisher' => 'string',
                'country' => 'string',
                'release_date' => 'date_format:Y-m-d',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status_code"=> 200,
                    "status"=> "errror",
                    "message"=> $validator->messages(),
                ], 200);
            }
            if (Book::where('id', $id)->exists()) {
                $book = Book::find($id);
                $book->name = is_null($request->name) ? $book->name : $request->name;
                $book->isbn = is_null($request->isbn) ? $book->isbn : $request->isbn;
                $book->authors = is_null($request->authors) ? $book->authors : $request->authors;
                $book->number_of_pages = is_null($request->number_of_pages) ? $book->number_of_pages : $request->number_of_pages;
                $book->publisher = is_null($request->publisher) ? $book->publisher : $request->publisher;
                $book->country = is_null($request->country) ? $book->country : $request->country;
                $book->release_date = is_null($request->release_date) ? $book->release_date : $request->release_date;
                $book->update();
    
                return response()->json([
                    "status_code"=> 200,
                    "status"=> "success",
                    "message" => "The book ".$book->name." was updated successfully",
                    "data"=> $book,
                ], 200);
                } 
                return response()->json([
                    "status_code"=> 404,
                    "status"=> "success",
                    "message" => "Book not found"
                ], 404);
              
          } catch (\Exception $ex) {
            return response()->json([
                "status_code"=> 500,
                "message" => "Server error"
            ], 500);
          }
      }
  
      public function deleteBook($id) {
        try {
            if(Book::where('id', $id)->exists()) {
                $book = Book::find($id);
                $book->delete();
                return response()->json([
                    "status_code"=> 204,
                    "status"=> "success",
                    "message" => "The book ".$book->name." was deleted successfully",
                    "data"=> [],
                ], 202);
              } 
                return response()->json([
                    "status_code"=> 404,
                    "status"=> "success",
                    "message" => "Book not found"
                ], 404);

        } catch (\Exception $ex) {
            return response()->json([
                "status_code"=> 500,
                "message" => "Server error"
            ], 500);
          }
      }
}
