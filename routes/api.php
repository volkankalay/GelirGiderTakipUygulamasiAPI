<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


Route::prefix('v1')->group(function(){

  Route::post('login',    [ApiController::class, 'Login']);
  Route::post('register', [ApiController::class, 'Register']);

    Route::middleware('auth:api')->group(function(){

      Route::post('user', [ApiController::class, 'User']);



      Route::post('logout',    [ApiController::class, 'Logout']);
    });
});
