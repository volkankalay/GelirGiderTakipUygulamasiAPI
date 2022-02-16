<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;


Route::prefix('v1')->group(function(){

  Route::post('login',          [ApiController::class, 'Login']);
  Route::post('register',       [ApiController::class, 'Register']);

    Route::middleware('auth:api')->group(function(){

      Route::get('user',       [ApiController::class, 'User']);
      Route::post('logout',     [ApiController::class, 'Logout']);


      Route::get('currencies', [ApiController::class, 'Currencies']);

      Route::resource('/category', CategoryController::class);
      Route::resource('/expense', ExpenseController::class);


    });
});
