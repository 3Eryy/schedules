<?php

use Illuminate\Support\Facades\Route;

// LANDING PAGE
Route::get('/', function () {
    return view('welcome');
});