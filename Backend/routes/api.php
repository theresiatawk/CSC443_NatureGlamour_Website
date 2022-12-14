<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
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
            Route::get("/login", 'redirect')->name('login');
            Route::post("/login", "login");
            Route::post("/signup", "register");
            Route::group(['middleware'=> 'auth:api'], function(){
                Route::post("/logout", "logout");
            });
        });
        Route::group(["prefix"=> "posts"], function(){
            Route::controller(PostController::class)->group(function () {
                Route::group(['middleware'=> 'auth:api'], function(){
                    Route::post("/add", "addPost");
                    Route::post("/delete", "deletePost");
                });
                Route::get("/","getPosts");
            });
        });
        Route::group(["prefix"=> "likes"], function(){
            Route::controller(LikeController::class)->group(function () {
                Route::group(['middleware'=> 'auth:api'], function(){
                    Route::post("/add", "addLike");
                    Route::post("/delete", "deleteLike");
                    Route::get("/check/{post_id}", "checkLike");
                });
                Route::get("/{post_id}","getLikes");
            });
        });
        Route::group(["prefix"=> "comments"], function(){
            Route::controller(CommentController::class)->group(function () {
                Route::group(['middleware'=> 'auth:api'], function(){
                    Route::post("/add", "addComment");
                    Route::get("/delete/{comment_id}", "deleteComment");
                });
                Route::get("/{post_id}","getComments");
            });
        });
        Route::group(["prefix"=> "spots"], function(){
            Route::controller(SpotController::class)->group(function () {
                Route::group(['middleware'=> 'auth:api'], function(){
                    Route::post("/add", "addSpot");
                    Route::get("/delete/{spot_id}", "deleteSpot");
                });
                Route::get("/{post_id}","getSpots");
            });
        });
    });
});
