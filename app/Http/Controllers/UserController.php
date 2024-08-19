<?php

namespace App\Http\Controllers;

use App\Models\User;
use Couchbase\View;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class UserController extends Controller
{
    public function create()
    {
        return view('user\login');
    }

    /**
     * метод проводит валидацию полей из формы Если проходит то перенпапрвялет на страницу dashboard иначе выводит ошибку
     * @param Request $request
     * @return RedirectResponse
     * @return array $email
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // можно использовать метод router() вместо intended()
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Неправильный логин или пароль!',
        ]);
    }


    /**
     *
     * метод валидации полей формы
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([

            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'=>['required', 'confirmed']

        ]);

//        записать в бд при помощи класса модели User и класса Request
//
//        $user = new User();
//
//        $user->name = $request->name;
//
//        $user->email = $request->email;
//
//        $user->password = $request->password;
//
//        $user->save();


        /**
         * запись в бд через статический метод после валидации массовым способом при помощи Request
         */
        $user = User::query()->create($request->all());

        /**
         * cоздаем событие после регистрации для отправки письма
         * @param передаем пользователя
         */
        event(new Registered($user));

        //аутентификация пользоватя для мидлваре
        Auth::login($user);

        /**
         * Перенаправляет пользователя на страницу с сообщением на подтверждения почты
         *
         * @returns View
         */
        return redirect()->route('verification.notice');


    }

    /**
     *
     * метод страницы зарегистрированого пользоватя (админка)
     *
     * @return View
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }



    public function register()
    {
        return view('user\register');
    }


    /**
     * разлогирование пользователя и переход на главную страницу
     * @return View
     *
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
