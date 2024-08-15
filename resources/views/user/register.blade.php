@extends('layout\main')




@section('title', 'register')


@section('content')
    <div class="row justify-content-center">
        <div class="col-4 ">
            <form>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Login</label>
                    <input name="name" type="text" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password confirm</label>
                    <input  name="password_confirmation" class="form-control" id="exampleInputPassword1">
                </div>
                <button name="password" type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a href="{{route('login')}}">Alredy register?</a>
            </form>
        </div>
    </div>
@endsection
