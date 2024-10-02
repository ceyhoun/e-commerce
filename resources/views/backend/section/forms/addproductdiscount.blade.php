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
                        @if (session('success'))
                        <div class="alert alert-success w-50">
                            {{session('success')}}
                        </div>
                        @endif
                        <div class="card card-success w-50">
                            <div class="card-header">
                                <h3 class="card-title">Endirim Kampaniyası Əlavə Et</h3>
                            </div>
                            <form action="{{route('addproductdiscount')}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="discountpercentid">Endirim Kampaniyası Seçin</label>
                                        <select name="discountpercent" class="form-control" id="discountpercentid">
                                            <option value="secin" selected>Seçin</option>
                                            @foreach ($salecampaigns as $campaign)
                                                <option value="{{$campaign->id}}" >{{$campaign->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="discountpercentid">Kataqoriya Seçin</label>
                                        <select name="discountpercent" class="form-control" id="discountpercentid">
                                            <option value="secin" selected>Seçin</option>
                                            @foreach ($categories as $category)
                                                <option value="secin" >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Kataqoriyaya Endirim əlavə edin</button>
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
