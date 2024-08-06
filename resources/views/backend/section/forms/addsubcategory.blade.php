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
                                <h3 class="card-title">Yeni Alt Kataqoriya Əlavə Et</h3>
                            </div>
                            <form action="{{ route('addsubcategory') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="subcategorytitle">Alt Kataqoriya Başlığı</label>
                                        <input type="text" name="subcategoryname" class="form-control" id="subcategoryıd"
                                            placeholder="Kataqoriya Başlığı">
                                    </div>

                                    <div class="form-group">
                                        <label for="topcategory">Aid Olduğu Üst Kataqoriya</label>
                                    <select name="category_id" class="form-control" id="topcategory">
                                        <option value="">Seçin</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                    <div class="form-check">
                                        <input type="checkbox" name="subcategorycheck" class="form-check-input"
                                            id="subcategorystatus">
                                        <label class="form-check-label" for="subcategorystatus">Statusu</label>
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
