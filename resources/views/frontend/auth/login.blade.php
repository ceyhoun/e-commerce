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
        @if (session('success'))
            {{session('success')}}
        @endif
        <form action="{{route('createlogin')}}" method="post">
            @csrf
            <input type="text" name="email" placeholder="İstifadeçi e-Mailiniz">
            <input type="password" name="password" placeholder="İstifadeçi Şifreniz">
            <button type="submit">Qeyd Ol</button>
        </form>

        <p>Hesabın Yoxdur ? <a href="{{route('register')}}">Qeyd Ol</a></p>
    </div>
</body>
</html>
