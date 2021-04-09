<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\CartController;

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
Route::post("/user/create", [UserController::class, "create"]);
Route::post("/user/login", [UserController::class, "login"]);
Route::put("/user/reset/{id}/{oldPassword}/{newPassword}", [UserController::class, "reset"]);
Route::put("/user/edit/{id}", [UserController::class, "editProfile"]);

Route::get("/cart/{id}", [CartController::class, "view"]);
Route::post("/cart", [CartController::class, "create"]);

//routes for ads
Route::get("/ads", [AdsController::class, "all"]);
Route::get("/ads/{id}", [AdsController::class, "view"]);
Route::post("/ad/create", [AdsController::class, "create"]);

//ad images
Route::post("/ad/images/create", [ImagesController::class, "create"]);
