<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api as Controllers;
use App\Http\Middleware\Authenticated;

Route::prefix('/auth')->name('auth.')->controller(Controllers\AuthController::class)->group(function() {
    
    Route::post('/register', 'register')->name('register');

    Route::post('/login', 'login')->name('login');

});

Route::prefix('/categories')->name('categories.')->middleware('auth:api')->controller(Controllers\ProductController::class)->group(function() {

    Route::get('/','categoryList')->name('categoryList');

    Route::get('/{id}','categoryShow')->name('categoryShow');

});