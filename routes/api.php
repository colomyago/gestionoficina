<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;



Route::get('/gemini', [GeminiController::class, 'index']);
Route::post('/gemini', [GeminiController::class, 'chat']);