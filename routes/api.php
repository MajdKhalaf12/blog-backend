<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\User;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //User
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //Post 
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);


    // Comments
    Route::get('/posts/{id}/comments', [PostController::class, 'index']);
    Route::post('/posts/{id}/comments', [PostController::class, 'store']);
    Route::put('/comments/{id}', [PostController::class, 'update']);
    Route::delete('/comments/{id}', [PostController::class, 'destroy']);

    // Like
    Route::post('/posts/{id}/likes', [PostController::class, 'likeOrUnlike']);
});