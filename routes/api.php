<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PropertyController;


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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/***ROUTES ACCESSIBLE WITHOUT AUTHENTICATION* */
      // User registration
      Route::post('/register', [RegisterController::class,"register"]);
      // User authentication
      Route::post('/login', [LoginController::class,"login"]);
      // Send reset password email
      Route::post('/password/email', [ForgotPasswordController::class, "sendResetLinkEmail"]);
      // Reset password user
      Route::post('/password/reset', [ResetPasswordController::class,"reset"]);

      Route::get('/properties', [PropertyController::class,"index"]);
      Route::get('/properties/show', [PropertyController::class,"show"]);
      Route::post('/properties', [PropertyController::class,"create"]);


      /***ROUTES ACCESSIBLE WITH AUTHENTICATION* */
Route::middleware('auth:sanctum')->group(function () {
    // Get all users
      Route::get("/users", [UserController::class, "index"]);
      // Logout user
      Route::post('/logout', [LoginController::class,"logout"]);
      // Delete user account
      Route::delete('/users', [UserController::class,"deleteAccount"]);
   
    });
