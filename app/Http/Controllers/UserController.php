<?php

namespace App\Http\Controllers;

use App\Models\User;
use Couchbase\View;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;


class UserController extends Controller
{
    public function create()
    {
        return view('user\login');
    }

    /**
     * метод проводит валидацию полей из формы Если проходит то перенпапрвялет на страницу dashboard иначе выводит
     * ошибку
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
     * @return view
     *
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * метод проверяет почту на валидность по методу post
     * @param Request $request
     * @return RedirectResponse
     */
    public function forgotPasswordStore (Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordUpdate (Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


//
}
