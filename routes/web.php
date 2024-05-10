<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolesPermissionController;
use GuzzleHttp\Middleware;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

  Route::get('dashboard', [DashboardController::class, 'index']);
  Route::get('dashboard/profile', [DashboardController::class, 'profile']);

  Route::get('dashboard/roles-and-permission', [RolesPermissionController::class, 'show']);
  Route::get('dashboard/add-permission', [RolesPermissionController::class, 'addPermissions']);
  Route::get('dashboard/create-role', [RolesPermissionController::class, 'createRole']);
  Route::post('dashboard/add-role', [RolesPermissionController::class, 'create']);
  Route::get('dashboard/edit-role/{id}', [RolesPermissionController::class, 'editRole']);
  Route::post('dashboard/update-role', [RolesPermissionController::class, 'updateRole']);
  Route::get('dashboard/delete-role/{id}', [RolesPermissionController::class, 'delete']);
});
