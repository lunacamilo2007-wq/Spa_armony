<?php

use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\CLienteController;
use App\Http\Controllers\CitasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\masajistasController;


Route::resource('masajistas', masajistasController::class);

Route::resource('servicios', ServiciosController::class);

Route::resource('clientes', CLienteController::class);

Route::resource('citas', CitasController::class);
Route::patch('citas/{cita}/cancel', [CitasController::class, 'cancel'])->name('citas.cancel');
Route::patch('citas/{cita}/confirm', [CitasController::class, 'confirm'])->name('citas.confirm');
Route::patch('citas/{cita}/finalize', [CitasController::class, 'finalize'])->name('citas.finalize');

Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
