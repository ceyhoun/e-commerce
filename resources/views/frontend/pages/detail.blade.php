@extends('frontend.layouts.layouts')

@section('content')
    @include('frontend.partials.crumb')


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row px-xl-5">
            @if ($singleProduct && $singleProduct->count() > 0)
                <div class="col-lg-5 mb-30">
                    <div id="product-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner bg-light">
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{ url("$singleProduct->images") }}"
                                    alt="{{ $singleProduct->name }}">
                            </div>
                        </div>
                        @if ($singleProduct->count() > 1)
                            <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                                <i class="fa fa-2x fa-angle-left text-dark"></i>
                            </a>
                            <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                                <i class="fa fa-2x fa-angle-right text-dark"></i>
                            </a>
                        @endif


                    </div>
                </div>
                <!--Sebet-->
                <div class="col-lg-7 h-auto mb-30">
                    <div class="h-100 bg-light p-30">
                        <form action="{{ route('additem', ['productId' => $singleProduct->id]) }}" method="post">
                            @csrf
                            <h3>{{ $singleProduct->name }}</h3>
                            <div class="d-flex mb-3">
                                <div class="text-primary mr-2">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star-half-alt"></small>
                                    <small class="far fa-star"></small>
                                </div>
                                <small class="pt-1">(99 Reviews)</small>
                            </div>
                            <h3 class="font-weight-semi-bold mb-4">{{ $singleProduct->price }} AZN</h3>
                            <p class="mb-4">{{ $singleProduct->description }}</p>
                            <!--number/size-->

                            @if ($singleProduct->isShoe())
                                <div class="d-flex mb-3">
                                    <strong class="text-dark mr-3">Numbers:</strong>
                                    @foreach ($singleProduct->shoes->unique('number') as $number)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="number-{{ $number->id }}"
                                                name="shoe_id" value="{{ $number->id }}"
                                                @if ($loop->first) checked @endif>
                                            <label class="form-check-label"
                                                for="number-{{ $number->id }}">{{ $number->number }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="d-flex mb-3">
                                    <strong class="text-dark mr-3">Sizes:</strong>
                                    @foreach ($singleProduct->sizes->unique('name') as $size)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="size-{{ $size->id }}"
                                                name="size_id" value="{{ $size->id }}"
                                                @if ($loop->first) checked @endif>
                                            <label class="form-check-label"
                                                for="size-{{ $size->id }}">{{ $size->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!--color-->
                            @if ($singleProduct->isShoe())
                                <div class="d-flex mb-4">
                                    <strong class="text-dark mr-3">Shoe Colors:</strong>
                                    @foreach ($singleProduct->shoe_colors as $color)
                                        <div class="form-radio form-radio-inline">
                                            <input class="form-radio-input" type="radio"
                                                id="shoe-color-{{ $color->id }}" name="color_id"
                                                value="{{ $color->id }}">
                                            <label class="form-radio-label"
                                                for="shoe-color-{{ $color->id }}">{{ $color->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="d-flex mb-4">
                                    <strong class="text-dark mr-3">Size Colors:</strong>
                                    @foreach ($singleProduct->size_colors as $color)
                                        <div class="form-radio form-radio-inline">
                                            <input class="form-radio-input" type="radio"
                                                id="size-color-{{ $color->id }}" name="color_id"
                                                value="{{ $color->id }}">
                                            <label class="form-radio-label"
                                                for="size-color-{{ $color->id }}">{{ $color->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!--stock-->


                            <p>Stokda :
                                @if ($singleProduct->isShoe())
                                    {{ $singleProduct->shoe_stock }}
                                @else
                                    {{ $singleProduct->size_stock }}
                                @endif
                            </p>


                            @if ($singleProduct->isShoe())
                                <div class="d-flex align-items-center mb-4 pt-2">
                                    @php
                                        $totalStock = $singleProduct->shoe_stock;
                                        $min = $totalStock < 1 ? 'disabled' : '';
                                    @endphp
                                    <div class="input-group quantity mr-3" style="width: 130px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-minus" id="qtyBtnMinus" type="button"
                                                {{ $min }}>
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>

                                        <input type="number" id="qtyInput" name="cartqty" min="1"
                                            max="{{ $totalStock }}"
                                            class="form-control bg-secondary border-0 text-center" value="1"
                                            {{ $min }}>
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-plus" id="qtyBtnPlus" type="button"
                                                {{ $min }}>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center mb-4 pt-2">
                                        @php
                                            $totalStock = $singleProduct->size_stock;
                                            $min = $totalStock < 1 ? 'disabled' : '';
                                        @endphp
                                        <div class="input-group quantity mr-3" style="width: 130px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary btn-minus" id="qtyBtnMinus" type="button"
                                                    {{ $min }}>
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>

                                            <input type="number" id="qtyInput" name="cartqty" min="1"
                                                max="{{ $totalStock }}"
                                                class="form-control bg-secondary border-0 text-center" value="1"
                                                {{ $min }}>
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary btn-plus" id="qtyBtnPlus" type="button"
                                                    {{ $min }}>
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                            @endif

                            <button class="btn btn-primary px-3" type="submit">
                                <i class="fa fa-shopping-cart mr-1"></i>
                                Səbətə Əlavə Et</button>
                        </form>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
        </div>
        <!--Sebet-->
        @endif
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Reviews (0)</a>
                    <a class="nav-item nav-link text-dark " data-toggle="tab" href="#tab-pane-2">Description</a>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade  " id="tab-pane-2">
                        <h4 class="mb-3">Product Description</h4>
                    </div>
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <div class="row">
                            @if (!empty($products) && $products->count() > 0)
                                <div class="col-md-6">
                                    @php
                                        $averageRating = number_format($averageRating, 1);
                                        $fullStars = floor($averageRating);
                                        $hasHalfStar = $averageRating - $fullStars >= 0.5;
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullStars)
                                            <i class="fas fa-star text-primary"></i>
                                        @elseif ($i == $fullStars + 1 && $hasHalfStar)
                                            <i class="fas fa-star-half-alt text-primary"></i>
                                        @else
                                            <i class="far fa-star text-primary"></i>
                                        @endif
                                    @endfor

                                    <h4 class="mb-4">{{ $productsCommentsCount }} review for "{{ $products->name }}"
                                    </h4>
                                    @foreach ($products->comments as $comment)
                                        <div class="media mb-4">
                                            <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                                style="width: 45px;">
                                            <div class="media-body">
                                                <h6>{{ $comment->name }}<small> -
                                                        <i>{{ $comment->created_at->format('d-M-Y / H:i') }}</i></small>
                                                </h6>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star{{ $i <= $comment->rating ? '' : '-o' }} text-primary"></i>
                                                @endfor

                                                <p>{{ $comment->message }}</p>

                                            </div>
                                            @if (Auth::check())
                                                <form action="{{ route('deletecomment', $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm(`Silinsin mi ?`)">Sil</button>
                                                </form>
                                                <button type="submit" class="btn btn-secondary btn-hidden"
                                                    data-hidden="{{ $comment->id }}">Gizle</button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <form method="POST" action="{{ route('comment', $singleProduct->id) }}">
                                    @csrf
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="star-rating">
                                            <div class="star-rating">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="star-{{ $i }}" name="rating"
                                                        value="{{ $i }}">
                                                    <label for="star-{{ $i }}">&#9733;</label>
                                                @endfor
                                            </div>


                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="messageid">Your Review *</label>
                                        <textarea id="messageid" cols="30" rows="5" name="message" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="nameid">Your Name *</label>
                                        <input type="text" class="form-control" name="name" id="nameid">
                                    </div>
                                    <div class="form-group">
                                        <label for="emailid">Your Email *</label>
                                        <input type="text" class="form-control" name="email" id="emailid">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Shop Detail End -->
    <!-- Products Start -->
    @if (!empty($likeProducts) && $likeProducts->count() > 0)
        <div class="container-fluid py-5">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Oxşar
                    Məhsullar</span></h2>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel">
                        @foreach ($likeProducts as $item)
                            <div class="product-item bg-light">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ url("$item->images") }}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="far fa-heart"></i></a>
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
                                        <h5>{{ $item->price }}</h5>
                                        <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>

                                        <small>(949)</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Products End -->
    @endif

@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('qtyBtnMinus').addEventListener('click', function(e) {
                e.preventDefault();
                var input = document.getElementById('qtyInput');
                if (input.value == 0 && input.value <= 0) {
                    input.value = 1;
                }
            });

            document.getElementById('qtyBtnPlus').addEventListener('click', function(e) {
                e.preventDefault();
                var input = document.getElementById('qtyInput');
                var max = parseInt(input.getAttribute('max'));
                if (input.value > max) {
                    input.value = max;
                }
            });
        });

    </script>
@endpush
