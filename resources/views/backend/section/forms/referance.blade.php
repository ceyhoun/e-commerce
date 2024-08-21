@extends('backend.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2>Yeni </h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">General</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
                <div class="row">
                    <div class="col-md">
                        <div class="card card-success w-50">
                            <div class="card-header">
                                <h3 class="card-title">Yeni Partnyor Əlavə Et</h3>
                            </div>
                            <form action="{{route('addreferances')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="reffilenameid">Partnyor Başlığı</label>
                                        <input type="text" name="refname" class="form-control" id="reffilenameid"
                                            placeholder="Kataqoriya Adı">
                                    </div>
                                    <div class="form-group">
                                        <label for="reffileid">Partnyor Fotosu</label>
                                        <input type="file" name="reffile" class="form-control" id="reffileid"
                                            placeholder="Partnyor Fotosu">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="refstatus" class="form-check-input"
                                            id="refstatuscheck">
                                        <label class="form-check-label" for="refstatuscheck">Statusu</label>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Partnyoru əlavə edin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
