<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    $unixTimestamp = '1461067200';
    return [
        //
        'name' => $faker->name,
        'isbn' => $faker->randomDigitNotNull,
        'authors' => ["George R. R. Martin"],
        'number_of_pages' => $faker->randomDigitNotNull,
        'publisher' => $faker->name,
        'country' => $faker->country,
        'release_date' => $faker->date('Y-m-d', $unixTimestamp),
    ];
});
