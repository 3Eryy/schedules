<?php

use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// LANDING PAGE
Route::get('/', function () {
    return view('welcome');
});

// LOGIN PAGE
Route::get('/user/login', [LoginController::class, 'index']);

// DASHBOARD USER
Route::get('/user/dashboard', [DashboardUserController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);