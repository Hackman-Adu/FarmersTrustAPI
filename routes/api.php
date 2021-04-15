<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FollowersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//routes for user
Route::get("/users", [UserController::class, "getAll"]);
Route::get("/user/{id}", [UserController::class, "view"]);
Route::post("/user", [UserController::class, "create"]);
Route::post("/user/login", [UserController::class, "login"]);
Route::put("/user/reset/{id}/{oldPassword}/{newPassword}", [UserController::class, "reset"]);
Route::put("/user/edit/{id}", [UserController::class, "editProfile"]);

Route::get("/carts/{id}", [CartController::class, "view"]);
Route::get("/carts", [CartController::class, "all"]);
Route::post("/cart", [CartController::class, "create"]);
Route::delete("/cart/{id}", [CartController::class, "delete"]);
Route::delete("/carts/{id}", [CartController::class, "deleteAll"]);

//routes for ads
Route::get("/ads", [AdsController::class, "all"]);
Route::get("/ad/{id}", [AdsController::class, "getAd"]);
Route::get("/ads/{id}", [AdsController::class, "view"]);
Route::post("/ad", [AdsController::class, "create"]);
Route::delete("/ad/{id}", [AdsController::class, "delete"]);
Route::put("/ad/{id}", [AdsController::class, "update"]);

//ad images
Route::post("/ad/images", [ImagesController::class, "create"]);

//review
Route::post("/review", [ReviewController::class, "create"]);
Route::get("/reviews", [ReviewController::class, "reviews"]);
Route::delete("/review/{id}", [ReviewController::class, "delete"]);
Route::get("/reviews/{id}", [ReviewController::class, "all"]);

//followers
Route::get("/followings/{id}", [FollowersController::class, "followings"]);
Route::get("/followers/{id}", [FollowersController::class, "followers"]);
