<?php

use Illuminate\Support\Facades\Route;

/**
 *
 * функция по методу get возвращает шаблон "welcom"
 *
 * @returns View
 *
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * вывод путей по контроллерам
 */
Route::get('login', [\App\Http\Controllers\UserController::class, 'create'])->name('login');

Route::post('register', [\App\Http\Controllers\UserController::class, 'store'])->name('store.register');

Route::get('register', [\App\Http\Controllers\UserController::class, 'register'])->name('register');



