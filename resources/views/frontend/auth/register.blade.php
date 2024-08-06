<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        @if (session('error'))
        <p>{{session('error')}}</p>
    @endif
        <form action="{{route('createuser')}}" method="post">
            @csrf
            <input type="text" name="username" value="{{old('username')}}" placeholder="İstifadeçi Adınız">
            <input type="text" name="email" placeholder="İstifadeçi e-Mailiniz">
            <input type="text" name="password" placeholder="İstifadeçi Şifreniz">
            <button type="submit">Qeyd Ol</button>
        </form>
        <p>Hesabın Var ? <a href="{{route('login')}}">Daxil Ol</a></p>
    </div>
</body>
</html>
