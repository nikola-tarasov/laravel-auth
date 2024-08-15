<?php

namespace App\Http\Controllers;

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

       return dd($request->all());
    }

    public function register()
    {
        return view('user\register');
    }
}
