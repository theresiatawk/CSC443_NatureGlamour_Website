<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(["prefix"=> "v0.1"], function(){
    Route::group(["prefix"=> "glamour"], function(){
        Route::controller(AuthController::class)->group(function () {
            Route::post("/login", "login");
            Route::post("/signup", "register");
            Route::post("/logout", "logout");
        });
        Route::group(["prefix"=> "posts"], function(){
            Route::controller(PostController::class)->group(function () {
                Route::post("/add", "addPost");
                Route::post("/delete", "deletePost");
                Route::get("/","getPosts");
            });
        });
        Route::group(["prefix"=> "likes"], function(){
            Route::controller(LikeController::class)->group(function () {
                Route::post("/add", "addLike");
                Route::post("/delete", "deleteLike");
                Route::get("/{post_id}","getLikes");
            });
        });
    });
});
