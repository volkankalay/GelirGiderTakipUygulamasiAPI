<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


Route::prefix('v1')->group(function(){

  Route::post('login',          [ApiController::class, 'Login']);
  Route::post('register',       [ApiController::class, 'Register']);

    Route::middleware('auth:api')->group(function(){
      Route::post('user',       [ApiController::class, 'User']);
      Route::post('logout',     [ApiController::class, 'Logout']);


      Route::post('currencies', [ApiController::class, 'Currencies']);

      Route::prefix('categories')->group(function(){
        Route::post('/',        [ApiController::class, 'CategoryList']);
        Route::post('/store',   [ApiController::class, 'CategoryStore']);
        Route::post('/update',  [ApiController::class, 'CategoryUpdate']);
        Route::post('/delete',  [ApiController::class, 'CategoryDelete']);
      });

      Route::prefix('datas')->group(function(){
        Route::post('/',        [ApiController::class, 'DataList']);
        Route::post('/store',   [ApiController::class, 'DataStore']);
        Route::post('/update',  [ApiController::class, 'DataUpdate']);
        Route::post('/delete',  [ApiController::class, 'DataDelete']);
      });


    });
});
