@extends('layout\main')




@section('title', 'login')


@section('content')
    <div class="row justify-content-center">
        <div class="col-4 ">

            <h1>Введите вашу почту для получения ссылки сброса пароля</h1>

            <form action="{{route('password.email')}}" method="post" >
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email"  aria-describedby="emailHelp">
                    <div>
                        @error('email')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <button  type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

@endsection

