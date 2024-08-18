<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::get('dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');

Route::get('login', [\App\Http\Controllers\UserController::class, 'create'])->name('login');

Route::post('register', [\App\Http\Controllers\UserController::class, 'store'])->name('store.register');

Route::get('register', [\App\Http\Controllers\UserController::class, 'register'])->name('register');


//маршрут обработки отправки на подтверждения
Route::get('email-verify', function () {
    return view('user.verify-email');
})->middleware('auth')->name('verification.notice');

//обработчик емайла
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');


//если пользователю не пришло ссылка на почту
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');

//маршрут разлогирования
Route::get('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');


