@extends('layout\main')




@section('title', 'register')


@section('content')
    <div class="row justify-content-center">
        <div class="col-4 ">
            <form action="{{route('store.register')}}" method="post" >
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Login</label>
                    <input name="name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password"  class="form-control" id="password">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm password</label>
                    <input name="password_confirmation" type="password"  class="form-control" id="passwordp_confirmation">
                </div>

                <button  type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a href="{{route('login')}}">Alredy register?</a>
            </form>
        </div>
    </div>
@endsection
