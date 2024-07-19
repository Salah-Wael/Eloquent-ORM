<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {

    $numbers = collect([1, 2, 3]);
    $greaterThanTwo = $numbers->filter(fn ($numbers) => $numbers > 2);

    dump($numbers);
    dump($greaterThanTwo);
});
