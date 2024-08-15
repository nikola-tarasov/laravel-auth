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
       return dd($request->all());
    }

    public function register()
    {
        return view('user\register');
    }
}
