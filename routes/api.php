<?php

use App\Http\Controllers\AccountActivationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChangeNumberController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PasswordResetController;

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
Route::get("/user/profile/{id}", [UserController::class, "viewProfile"]);
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
Route::get("/ads/category/{category}/{sort}", [AdsController::class, "getByCategory"]);
Route::get("/ad/{id}", [AdsController::class, "refreshAd"]);
Route::get("/ads/{id}", [AdsController::class, "view"]);
Route::post("/ad", [AdsController::class, "create"]);
Route::delete("/ad/{id}", [AdsController::class, "delete"]);
Route::put("/ad/{id}", [AdsController::class, "update"]);
Route::get("/ads/search/{value}/{category}/{sort}", [AdsController::class, "searchProducts"]);
Route::get("/ads/related/{category}/{id}", [AdsController::class, "getRelatedProducts"]);

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
Route::delete("/unfollow/{userID}/{followerID}", [FollowersController::class, "unFollow"]);
Route::post("/follow", [FollowersController::class, "follow"]);



//forgot password
Route::get("/account/{number}/{email}", [PasswordResetController::class, "checkAccount"]);
Route::post("/reset", [PasswordResetController::class, "sendCode"]);
Route::get("/verify/{phone}/{code}", [PasswordResetController::class, "verifyCode"]);
Route::put("/resend/{phone}/{code}/{message}", [PasswordResetController::class, "resendCode"]);
Route::put("/password/{phone}/{password}", [PasswordResetController::class, "newPassword"]);


//account activation
Route::post("/activate", [AccountActivationController::class, "sendActivationCode"]);
Route::put("/activate/resend/{phone}/{code}/{message}", [AccountActivationController::class, "resendCode"]);
Route::get("/activation/verify/{phone}/{code}", [AccountActivationController::class, "verifyCode"]);

Route::put("/change/phone/{id}/{phone}", [ChangeNumberController::class, "changeNumber"]);


//orders
Route::get("/orders/placed/{id}", [OrdersController::class, "PlacedOrders"]);
Route::get("/orders/received/{id}", [OrdersController::class, "receivedOrders"]);
Route::post("/order", [OrdersController::class, "newOrder"]);
Route::post("/order/details", [OrdersController::class, "orderDetails"]);
