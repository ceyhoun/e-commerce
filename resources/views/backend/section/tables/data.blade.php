@extends('backend.layouts.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Table</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Adı</th>
                            <th>Qiymeti</th>
                            <th>Kataqoriyası</th>
                            <th>Rengi</th>
                            <th>Ölçüsü</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showProduct as $product)
                            <tr>
                                <th>{{ $product->id }}</th>
                                <th>{{ $product->name }}</th>
                                <th>{{ $product->price }}</th>
                                <th>{{ $product->subcategory->name }}</th>
                                @php
                                    $uniqueColors = $product->colors->unique('name');
                                    $uniqueSizes = $product->sizes->unique('name');
                                @endphp
                                <td>
                                    @foreach ($uniqueColors as $color)
                                        <span>{{ $color->name }} ({{ $color->pivot->qty == 0 ? 'bitdi' : $color->pivot->qty }})</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($uniqueSizes as $size)
                                        <span>{{ $size->name }} ({{ $size->pivot->qty  == 0 ? 'bitdi' : $size->pivot->qty }})</span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>


    </div>
@endsection
