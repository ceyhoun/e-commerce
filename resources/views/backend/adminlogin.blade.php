<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panele Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
        <div class="container-fluid">
            <div class="row my-md-5">
                <div class="col-md-6 my-md-5" >
                    <img src="{{asset('adminlogin.webp')}}" alt="">
                </div>
                <div class="col-md-6 my-md-5">
                    <div class="card card-success w-50">
                        <div class="card-header">
                            <h3 class="card-title">Yeni Kataqoriya Əlavə Et</h3>
                        </div>
                        <form action="{{route('adminloginauth')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control"
                                        placeholder="Admin İstifadeçi Adı">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="password" class="form-control"
                                        placeholder="Admin İstifadeçi Şifresi">
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Giriş Et</button>
                                </div>
                            </div>
                        </form>
                        @if (session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                    </div>

                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
