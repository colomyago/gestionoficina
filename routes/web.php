<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirigir al panel de administración de Filament
    return redirect('/admin');
});





Route::get('/geminiTest', function () {
    return view('geminiTest');
});

