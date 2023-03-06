<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Models\Rating;
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
    Route::middleware("guest")->group(function(){
        Route::post("/show/{news:slug}",[NewsController::class,"show"]);
        Route::post("/all",[NewsController::class,"index"]);
    });        

    
    Route::middleware(["auth.api","auth.isAdmin"])->group(function(){
        Route::post("/store",[NewsController::class,"store"]);
        Route::post("/destroy/{news:slug}",[NewsController::class,"destroy"]);
    });
});

Route::prefix("rating")->group(function(){
    
    Route::post("/{news:slug}/all",[RatingController::class,"index"]);
    Route::post("/store",[RatingController::class,"store"]);
    Route::post("/show/{rating:news_id}",[RatingController::class,"show"]);
    Route::post("/destroy/{rating}",[RatingController::class,"destroy"]);

})->middleware("auth.api");