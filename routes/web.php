<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;


Route::get('/', function () {
    // Trae todos los usuarios
    $users = User::all();

    // Manda los datos a la vista
    return view('index', ['users' => $users]);
});





Route::get('/geminiTest', function () {
    return view('geminiTest');
});

