@extends('frontend.layouts.layouts')
@section('content')
<div class="container ">
    @if (session('success'))
        {{session('success')}}
    @endif
    <h3>Daxil Ol</h3>
    <form action="{{route('createlogin')}}" method="post">
        @csrf
        <input type="text" name="email" class="form-control w-25" placeholder="İstifadeçi e-Mailiniz"><br>
        <input type="password" name="password" class="form-control w-25" placeholder="İstifadeçi Şifreniz">
        Meni Xatırla <input type="checkbox" name="remember"><br>
        <button type="submit" class="btn btn-outline-warning">Daxil Ol</button><br>
    </form>

    <small>Şifreni Unutmusan ? <a href="#">daxil ol</a></small><br>


    <p>Hesabın Yoxdur ? <a href="{{route('register')}}">Qeyd Ol</a></p>
</div>
@endsection


