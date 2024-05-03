<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PanellController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

//Route to view home page
Route::get('/', [WelcomeController::class, 'index']);


Route::get('register', [AuthController::class, 'show_registration_form']);
Route::post('register', [AuthController::class, 'store_user']);

//Route for user to verify their tokens
Route::get('verification/{token}', [AuthController::class, 'verify_user']);

//Route to login user
Route::get('login', [AuthController::class, 'show_login_form']);
Route::post('login', [AuthController::class, 'login']);

//Reset password route
Route::get('reset', [AuthController::class, 'reset_password_form']);
Route::post('reset', [AuthController::class, 'reset_password']);

//Change password route
Route::get('reset-password/{token}', [AuthController::class, 'changePasswordForm']);
Route::post('reset-password/{token}', [AuthController::class, 'changePassword']);


//Log out user
Route::get('logout', [AuthController::class, 'logout']);


//Accessing the platform Athenticated
Route::group(['middleware' => 'authmiddleware'], function () {

  Route::get('panell', [PanellController::class, 'index']);
});
