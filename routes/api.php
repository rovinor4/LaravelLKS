<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix("user")->group(function(){
    Route::middleware("guest")->group(function(){
        Route::post('/login',[UserController::class,"index"]);
        Route::post('/store',[UserController::class,"store"]);
    });
    
    Route::middleware("auth.api")->group(function(){
        Route::post('/show/{user:remember_token}',[UserController::class,"show"]);
        Route::post('/update/{user:remember_token}',[UserController::class,"update"]);
        Route::post('/destroy/{user:remember_token}',[UserController::class,"destroy"]);
    });
});

Route::prefix("news")->group(function(){
        Route::post("/all",[NewsController::class,"index"]);
})->middleware("auth.api");