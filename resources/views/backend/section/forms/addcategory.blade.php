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
                <div class="row">
                    <div class="col-md">
                        <div class="card card-success w-50">
                            <div class="card-header">
                                <h3 class="card-title">Yeni Kataqoriya Əlavə Et</h3>
                            </div>
                            <form action="{{ route('addcategory') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="categoryıd">Kataqoriya Başlığı</label>
                                        <input type="text" name="categoryname" class="form-control" id="categoryıd"
                                            placeholder="Kataqoriya Başlığı">
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryphoto">Kataqoriya Şəkili</label>
                                        <input type="file" name="categoryimage" class="form-control" id="categoryphoto"
                                            placeholder="Kataqoriya Şəkili" multiple>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="categorycheck" class="form-check-input"
                                            id="categorystatus">
                                        <label class="form-check-label" for="categorystatus">Statusu</label>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Kataqoriyanı əlavə edin</button>
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



{{--

                                        <div class="form-group">
                                        <label for="topcategoryıd">Üst Kataqoriya Seçin</label>
                                        <select name="topcategoryname" id="topcategoryıd" class="form-control" >
                                            <option value="null" selected>Seçin</option>
                                            @foreach ($topcategories as $topcategory)
                                                <option value="{{$topcategory->name}}">{{$topcategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    --}}
