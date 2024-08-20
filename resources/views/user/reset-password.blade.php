@extends('layout\main')




@section('title', 'register')


@section('content')
    <div class="row justify-content-center">
        <h1>Сброс пароля</h1>
        <div class="col-4 ">
            <form action="{{route('password.update')}}" method="post" >
                @csrf

                {{--обязательный скрытый input для токена--}}
                <input type="hidden" name="token" value="{{$token}}">

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

                <button  type="submit" class="btn btn-primary">Send reset</button>

            </form>
        </div>
    </div>
@endsection
