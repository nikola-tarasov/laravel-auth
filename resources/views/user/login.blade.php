@extends('layout\main')




@section('title', 'login')


@section('content')
    <h1>Login</h1> <br>
    <div class="row justify-content-center">
        <div class="col-4 ">
            <form action="{{route('authenticate')}}" method="post" >
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Login</label>
                    <input name="name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password"  class="form-control" id="password">
                </div>
                <button  type="submit" class="btn btn-primary">Войти</button>
                <a href="{{route('password.request')}}">Забыли пароль?</a>
            </form>
        </div>
    </div>

@endsection

