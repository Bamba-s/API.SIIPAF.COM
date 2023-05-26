<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyCtrllers\CreateController;
use App\Http\Controllers\PropertyCtrllers\UpdateController;
use App\Http\Controllers\Forms\ContactFormController;


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
     
   
      // Users authentication
      Route::post('/auth/register', [RegisterController::class,"register"]);
      Route::post('/auth/login', [LoginController::class,"login"]);
     Route::post('/password/email', [ForgotPasswordController::class, "sendResetLinkEmail"])->name('password.email');
     Route::post('/password/reset', [ResetPasswordController::class,"reset"])->name('password.update');
     Route::get('/password/reset/{token}',[ForgotPasswordController::class, "showResetForm"])->name('password.reset');
     ;

            /***ROUTES ACCESSIBLE WITH AUTHENTICATION* */
     //  Route::middleware('auth:sanctum')->group(function () {
          Route::get("/users", [UserController::class, "index"]);
          Route::put('/users/{id}', [UserController::class,"update"]);
          Route::post('/auth/logout', [LoginController::class,"logout"]);
          Route::delete('/users/{id}', [UserController::class,"destroy"]);
          Route::delete('/users', [UserController::class,"deleteAccount"]);

                //Property CRUD
          Route::get('/properties', [PropertyController::class,"index"]);
          Route::get('/properties/{id}', [PropertyController::class,"show"]);
          //Route::get('/properties', [PropertyController::class,"search"]);
          Route::post('/properties', [CreateController::class,"create"]);
          Route::put('/properties/{id}', [UpdateController::class,"update"]);
          Route::delete('/properties/{id}', [PropertyController::class,"delete"]);
          
      //   });

      // Contact form
      Route::post('/contact-form', [ContactFormController::class,"contact"]);
      Route::get('/contacts', [ContactFormController::class, 'listSubmissions']);
     
