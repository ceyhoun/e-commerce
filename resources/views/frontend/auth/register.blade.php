@extends('frontend.layouts.layouts')
@section('content')
    <div class="container">
        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif
        <h3>Qeyd Ol</h3>
        <form action="{{ route('createuser') }}" method="post">
            @csrf
            <input type="text" name="username" class="form-control w-25"  value="{{ old('username') }}" placeholder="İstifadeçi Adınız"><br>
            <input type="text" name="email"  class="form-control w-25"  placeholder="İstifadeçi e-Mailiniz"><br>
            <input type="text" name="password" class="form-control w-25"  placeholder="İstifadeçi Şifreniz"><br>
            <button type="submit" class="btn btn-outline-warning">Qeyd Ol</button>
        </form>
        <p>Hesabın Var ? <a href="{{ route('login') }}">Daxil Ol</a></p>
    </div>
@endsection
