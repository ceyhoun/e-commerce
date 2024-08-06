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
                            <li class="breadcrumb-item"><a href="{{route('panel')}}">Home</a></li>
                            <li class="breadcrumb-item active">General Form</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md">
                        <div class="card card-info w-50">
                            <div class="card-header">
                                <h3 class="card-title">Yeni Məhsul Əlavə Et</h3>
                            </div>
                            <form action="{{ route('addproducts') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <!-- Diğer ürün alanları -->
                                    <div class="form-group">
                                        <label for="productnameid">Məhsulun Adı</label>
                                        <input type="text" name="productname" class="form-control" id="productnameid" placeholder="Məhsulun Adı">
                                    </div>
                                    <div class="form-group">
                                        <label for="productsubcategoriesid">Məhsulun Aid Olduğu Kateqoriya</label>
                                        <select name="subcategoryid" id="productsubcategoriesid" class="form-control">
                                            <option value="seçin" selected>Seçin</option>
                                        @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="productpriceid">Məhsulun Qiyməti</label>
                                        <input type="number" name="productprice" class="form-control" id="productpriceid" placeholder="Məhsulun Qiyməti">
                                    </div>
                                    <div class="form-group">
                                        <label for="productqtyeid">Məhsulun Anbar Miqdarı</label>
                                        <input type="number" name="qty" class="form-control" id="productqtyeid" placeholder="Məhsulun Anbar Miqdarı">
                                    </div>
                                    <div class="form-group">
                                        <label for="productdescid">Məhsul Haqqında</label>
                                        <input type="text" name="productdesc" class="form-control" id="productdescid" placeholder="Məhsul Haqqında">
                                    </div>

                                    <div class="form-group">
                                        <label for="productsizeid">Məhsulun Şəkli</label>
                                        <input name="productimg" type="file">
                                    </div>
                                    <br>

                                    Məhsulun Ölçüsü :
                                    <div class="form-check form-check-inline">
                                        @foreach ($sizes as $index => $size)
                                            <input class="form-check-input mx-1" type="checkbox" name="productsize[]" id="productsize-{{$index}}" value="{{$size->id}}">
                                            <label class="form-check-label" for="productsize-{{$index}}"><b>{{$size->name}}</b></label>
                                        @endforeach
                                    </div>
                                    <br>

                                    Məhsulun Rəngi :
                                    <div class="form-check form-check-inline">
                                        @foreach ($colors as $index => $color)
                                            <input class="form-check-input mx-1" type="checkbox" name="productcolor[]" id="productcolor-{{$index}}" value="{{$color->id}}">
                                            <label class="form-check-label" for="productcolor-{{$index}}"><b>{{$color->name}}</b></label>
                                        @endforeach
                                    </div>
                                    <br>

                                    <p>Miqdar Müəyyən Etmə:</p>
                                    @foreach ($sizes as $size)
                                    @foreach ($colors as $color)
                                    <div class="form-group">
                                        <label for="quantity-{{ $size->id }}-{{ $color->id }}">
                                            {{ $size->name }} - {{ $color->name }}
                                        </label>
                                        <input type="number" name="productqty[{{ $size->id }}][{{ $color->id }}]" id="quantity-{{ $size->id }}-{{ $color->id }}" value="0">
                                    </div>
                                    @endforeach
                                    @endforeach




                                    <div class="form-check">
                                        <input type="checkbox" name="productcheck" class="form-check-input" id="productcheckid">
                                        <label class="form-check-label" for="productcheckid">Məhsulun Statusu</label>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info">Məhsulu əlavə edin</button>
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

