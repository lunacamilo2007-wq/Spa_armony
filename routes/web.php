<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masajistasController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('masajistas', masajistasController::class);