<?php

use App\Http\Controllers\Api\TodoController;
use Illuminate\Support\Facades\Route;

// @todo remove
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/todo/items', [TodoController::class, 'list']);
