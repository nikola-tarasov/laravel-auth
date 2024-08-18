@extends('layout\main')




@section('verify', 'login')


@section('content')
    <h1>Спасибо что зарегистрировались! Теперь нужно подтвертидь почту, перейдя по ссылке в письме</h1> <br>
    <h2>Если не пришло нажмите на эту <a href="{{route('verification.send')}}">ссылку</a></h2>
@endsection
