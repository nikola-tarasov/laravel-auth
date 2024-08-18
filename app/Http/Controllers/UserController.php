<?php

namespace App\Http\Controllers;

use App\Models\User;
use Couchbase\View;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function create()
    {
        return view('user\login');
    }

    public function store(Request $request)
    {

        $request->validate([

            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'=>['required', 'confirmed']

        ]);


        /**
         * записать в бд при помощи класса модели User и класса Request
         */
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
        User::query()->create($request->all());


        /**
         * @returns View
         */
        return redirect('Login');


    }

    public function register()
    {
        return view('user\register');
    }
}
