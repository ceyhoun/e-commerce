@extends('frontend.layouts.layouts')
@section('content')

    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    @if ($subcategories && $subcategories->count() > 0)
                        <ol class="carousel-indicators">
                            @foreach ($subcategories as $index => $subcategory)
                            @if ($subcategory->products->count()>0)
                            <li data-target="#header-carousel" data-slide-to="{{$index}}" class="{{$index == 0 ? 'active' : ''}}"></li>
                            @endif
                            @endforeach

                        </ol>
                        <div class="carousel-inner">
                            @foreach ($subcategories as $index => $subcategory)
                                <div class="carousel-item position-relative {{ $index == 0 ? 'active' : '' }}"
                                    style="height: 430px;">
                                    <img class="position-absolute w-100 h-100" src="#" style="object-fit: cover;">
                                    <div
                                        class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                        <div class="p-3" style="max-width: 700px;">
                                            <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                                {{ $subcategory->name }}
                                            </h1>
                                            <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna
                                                amet lorem
                                                magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                            <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                                href="{{ route('shop', ['filtre' => $subcategory->slug]) }}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/offer-1.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">@lang('messages.quality product')</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">@lang('messages.free shipping')</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">@lang('messages.14-day return')</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">@lang('messages.24/7 support')</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->
    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">@lang('messages.categories')</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="{{ route('shop', ['parent' => $category->slug]) }}">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="{{ url("$category->image") }}" alt="">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{ $category->name }}</h6>
                                <small class="text-body">100 Products</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">@lang('messages.all products')</span></h2>
        <div class="row px-xl-5">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ url("$product->images") }}" alt="{{ $product->name }}">
                            <div class="product-action">

                                <a href="javascript:void(0);" tabindex="0" role="button" data-cart-id={{ $product->id }}
                                    class="btn btn-outline-dark btn-square btn-basket">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>

                                <a class="btn btn-outline-dark btn-square btn-fav" data-item-id="{{ $product->id }}"><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M10.08,7l1,1,3.44-3.45L11,1,10,2l1.8,1.8H2v1.4h9.82ZM5.86,9l-1-1L1.42,11.5,4.91,15l1-1L4.1,12.2H14V10.8H4.1Z">
                                        </path>
                                    </svg>
                                </a>

                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('detail', $product->slug) }}">{{ $product->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $product->price }} tl</h5>
                                <h6 class="text-muted ml-2"><del>123.00 tl</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <small class="fa fa-star text-primary mr-1"></small>
                                @endfor
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <!-- Products End -->
    <!--Sale Area-->
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Son Əlavə
                Olunanlar</span></h2>
        <div class="row px-xl-5">
            @foreach ($productsDesc as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ url("$item->images") }}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square btn-fav" data-item-id="{{ $product->id }}"
                                    href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('detail', $item->slug) }}">{{ $item->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $item->price }}tl</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->
    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">Referances</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @if (!empty($referances) && $referances->count() > 0)
                        @foreach ($referances as $referance)
                            <div class="bg-light p-4">
                                <img src="{{ url("$referance->image") }}" alt="" class="img-fluid">
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection
@section('contet')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.btn-fav').click(function(e) {
                    e.preventDefault();

                    let $this = $(this);
                    let itemId = $this.data('item-id');

                    $.ajax({
                        type: "POST",
                        url: `/fav/addfav/${itemId}`,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            item_id: itemId
                        },
                        dataType: "json",
                        success: function(response) {
                            showfavdata(response.name);
                            $this.find('i').removeClass('far').addClass('fas');
                        },
                        error: function(xhr, status, error) {
                            console.error('Hata oluştu:', error);
                            console.error('Sunucu yanıtı:', xhr.responseText);
                        }
                    });

                    function showfavdata(itemName) {
                        if (itemName) {
                            Swal.fire({
                                title: 'success',
                                text: itemName + ' eklendi.',
                                icon: 'success',
                            })
                        } else {
                            Swal.fire({
                                title: 'error',
                                text: 'favda',
                                icon: 'error',
                            })
                        }
                    }

                });

                $('.btn-basket').click(function(e) {
                    e.preventDefault();
                    let productId = $(this).data('cart-id')

                    $.ajax({
                        type: "GET",
                        url: `/cart/getproduct/${productId}`,
                        data: {
                            productId: productId

                        },
                        dataType: "json",
                        success: function(response) {
                            response.qty = 1;
                            showCartData(response);
                            //console.log(response);

                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error);

                        }
                    });

                    function showCartData(response) {
                        console.log(response);
                    }

                });

            });
        </script>
    @endpush
@endsection
