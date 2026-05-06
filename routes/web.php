<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\CLienteController;
use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\masajistasController;
use App\Http\Controllers\ServiciosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (public)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (require admin login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('masajistas', masajistasController::class);

    Route::resource('servicios', ServiciosController::class);

    Route::resource('habitaciones', HabitacionesController::class, ['parameters' => ['habitaciones' => 'habitacion']]);
    Route::patch('habitaciones/{habitacion}/toggle-estado', [HabitacionesController::class, 'toggleEstado'])->name('habitaciones.toggle-estado');

    Route::resource('clientes', CLienteController::class);

    Route::resource('citas', CitasController::class);
    Route::patch('citas/{cita}/cancel', [CitasController::class, 'cancel'])->name('citas.cancel');
    Route::patch('citas/{cita}/confirm', [CitasController::class, 'confirm'])->name('citas.confirm');
    Route::patch('citas/{cita}/finalize', [CitasController::class, 'finalize'])->name('citas.finalize');
});
