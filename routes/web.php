<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/geminiTest', function () {
    return view('geminiTest');
});

