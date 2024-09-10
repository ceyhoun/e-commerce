@extends('frontend.layouts.layouts')
@section('content')
    @include('frontend.partials.crumb')
    <div class="container">
        <div class="row">
        <div class="col-12">
            <div class="row product-list">
                @if (isset($message))
                    <p>{{ $message }}</p>
                @else
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('detail', [$product->slug]) }}">{{ $product->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $product->price }}AZN</h5>
                                        <h6 class="text-muted ml-2"><del>$6</del></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star mr-1"></small>
                                        <small>90</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
