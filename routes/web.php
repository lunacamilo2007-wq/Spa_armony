<?php

use App\Http\Controllers\ServiciosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masajistasController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('masajistas', masajistasController::class);

Route::resource('servicios', ServiciosController::class);

