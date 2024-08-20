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

//маршрут для аутентифицированого и верифицированного пользователя по почте для вывода его на админку dashboard
Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');
});

/**
 *
 * маршрут обьединеный в группу middleware
 *1 отправка формы на скрипт входа
 *2 вывод вида формы
 *3 скрипт обработки формы регистрации
 *4 вывод вида формы регистрации
 */
Route::middleware('guest')->group(function (){

    //вывод путей по контроллерам

    Route::post('login', [\App\Http\Controllers\UserController::class, 'authenticate'])->name('authenticate');

    Route::get('login', [\App\Http\Controllers\UserController::class, 'create'])->name('login');

    Route::post('register', [\App\Http\Controllers\UserController::class, 'store'])->name('store.register');

    Route::get('register', [\App\Http\Controllers\UserController::class, 'register'])->name('register');



//  ВОССТАНОВЛЕНИЯ ЗАБЫТОГО ПАРОЛЯ
    //ссылка на вид на восстановление пароля
    Route::get('forgot-password', function () {
        return view('user.forgot-password');
    })->name('password.request');

    //обработчик проверки почты в бд
    Route::post('forgot-password', [\App\Http\Controllers\UserController::class,'forgotPasswordStore'])->name('password.email')->middleware('throttle:3,1');

    //ссылка на форму с почты с токеном для изменения пароля
    Route::get('/reset-password/{token}', function (string $token) {
        return view('user.reset-password',['token' => $token]);
    })->name('password.reset');

    //обработчик формы для изменения пароля
    Route::post('/reset-password', [\App\Http\Controllers\UserController::class, 'resetPasswordUpdate']
    )->name('password.update');

});



// маршрут объедененный в группу middleware для отправки письма на почту для потверждения пользователя
Route::middleware('auth')->group(function (){

    //маршрут обработки отправки на подтверждения
    Route::get('email-verify', function () {
        return view('user.verify-email');
    })->name('verification.notice');

    //обработчик емайла
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('dashboard');
    })->middleware(['signed'])->name('verification.verify');

    //если пользователю не пришло ссылка на почту
    Route::get('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:3,1'])->name('verification.send');

    //маршрут разлогирования
    Route::get('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');

});











