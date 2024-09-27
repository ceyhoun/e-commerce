@extends('frontend.layouts.layouts')

@section('content')
    @include('frontend.partials.crumb')


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">


            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form id="filterPrice">
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all" data-min=""
                                data-max="">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1" data-min="0"
                                data-max="100">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                    </form>


                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        color</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form id="filterColor">
                        @if (!empty($colors) && $colors->count() > 0)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" checked id="color-all" name="color-all">
                                <label class="custom-control-label" for="color-all">All Color</label>
                                <span class="badge border font-weight-normal">{{ $allTotalColor }}</span>
                            </div>
                            @foreach ($colors as $color)
                                <div
                                    class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="color-{{ $color->id }}"
                                        name="color[]" value="{{ $color->name }}">
                                    <label class="custom-control-label"
                                        for="color-{{ $color->id }}">{{ $color->name }}</label>
                                    <span class="badge border font-weight-normal">{{ $color->totalColor }}</span>
                                </div>
                            @endforeach
                        @endif

                    </form>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        size</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form id="filterForm">
                        @if (!empty($sizes) && $sizes->count() > 0)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" checked id="size-all" name="size-all">
                                <label class="custom-control-label" for="size-all">All Size</label>
                                <span class="badge border font-weight-normal">{{ $allTotalSize }}</span>
                            </div>

                            @foreach ($sizes as $size)
                                <div
                                    class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="size-{{ $size->id }}"
                                        name="size[]" value="{{ $size->name }}">
                                    <label class="custom-control-label"
                                        for="size-{{ $size->id }}">{{ $size->name }}</label>
                                    <span class="badge border font-weight-normal">{{ $size->totalSize }}</span>
                                </div>
                            @endforeach
                        @endif


                    </form>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3 ">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light" id="table-grid" data-grid="grid"><i
                                        class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2" id="table-block" data-block="block"><i
                                        class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Ada Göre</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" id="dropdown-item1" href="javascript:void(0);"
                                            role="button" tabindex="0" data-asc="asc">A-Z</a>
                                        <a class="dropdown-item" id="dropdown-item2" href="javascript:void(0);"
                                            role="button" tabindex="0" data-desc="desc">Z-A</a>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Qiymete Göre</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0);" id="incremenet-data"
                                            tabindex="0" role="button" data-incremenet="price-increment">Artan</a>
                                        <a class="dropdown-item" href="javascripy:void(0);" id="decrement-data"
                                            tabindex="0" role="button" data-decrement="price-decrement">Azalan</a>
                                    </div>
                                </div>
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Kateqoriyalara göre</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if (!empty($subcategories) && $subcategories->count() > 0)
                                            @foreach ($subcategories as $subcategory)
                                                <a class="dropdown-item"
                                                    href="{{ route('shop', ['filtre' => $subcategory->slug]) }}">{{ $subcategory->name }}
                                                    ({{ $subcategory->products_count }})
                                                </a>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="row product-list">
                            @if (!empty($products) && $products->count() > 0)
                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                        <div class="product-item bg-light mb-4">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" src="{{ url("$product->images") }}"
                                                    alt="">
                                                <div class="product-action">
                                                    <a class="btn btn-outline-dark btn-square"
                                                        href="{{ route('getproduct', $product->id) }}"><i
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
                                                    href="{{ route('detail', $product->slug) }}">{{ $product->name }}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>{{ $product->price }} AZN</h5>
                                                    <h6 class="text-muted ml-2"><del>$6</del></h6>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <small class="fa fa-star mr-1 text-primary" ></small>
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

            @if (isset($products) && $products->count() > 1)
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
        <!-- Shop Product End -->
    </div>
    </div>
    <!-- Shop End -->
@endsection



@section('content')
    @push('scripts')
        <script>
            $(document).ready(function() {
                //price
                $('#filterPrice input').change(function() {
                    applyFilterPrice();
                });

                function applyFilterPrice() {
                    var filters = [];

                    $('#filterPrice input:checked').each(function() {
                        var min = $(this).data('min');
                        var max = $(this).data('max');
                        if (min !== undefined && max !== undefined) {
                            filters.push('minprice=' + min + '&maxprice=' + max);
                        }
                    });

                    var formprice = filters.join('&');

                    $.ajax({
                        type: "GET",
                        url: "{{ 'shop' }}",
                        data: formprice,
                        dataType: "json",
                        success: function(response) {
                            showPriceList(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error);
                        }
                    });

                    function showPriceList(response) {
                        let pricelist = response.products;
                        let showpricelister = document.querySelector('.product-list');
                        showpricelister.innerHTML = "";

                        pricelist.forEach((item) => {
                            const pricelistercontent = `
                             <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${item.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${item.slug}">${item.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>$${item.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                            showpricelister.insertAdjacentHTML('beforeend', pricelistercontent);
                        })
                    }







                }
                //size
                $('#filterForm input').change(function() {
                    applyFilterSize();
                });

                function applyFilterSize() {
                    var formSize = $('#filterForm').serialize();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('shop') }}",
                        data: formSize,
                        success: function(response) {
                            //console.log(response.products);
                            showSizelist(response);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }

                function showSizelist(response) {

                    const productSize = response.products;
                    let productSizeList = document.querySelector('.product-list');
                    productSizeList.innerHTML = '';

                    productSize.forEach((item) => {
                        //console.log(item.name);


                        const productSizeContent = `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${item.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${item.slug}">${item.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>$${item.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        productSizeList.insertAdjacentHTML('beforeend', productSizeContent);
                    });
                }

                ///////////////////////

                //color

                $('#filterColor input').change(function() {
                    applyFilterColors();
                });

                function applyFilterColors() {
                    let formColor = $('#filterColor').serialize();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('shop') }}",
                        data: formColor,
                        dataType: "json",
                        success: function(response) {
                            showColorList(response);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }

                function showColorList(response) {
                    const productColor = response.products;
                    let productColorList = document.querySelector('.product-list');
                    productColorList.innerHTML = '';

                    productColor.forEach((items) => {
                        const productColorContent = `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${items.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${items.slug}">${items.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${items.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        productColorList.insertAdjacentHTML('beforeend', productColorContent);
                    })
                }

                //order A-Z for name
                $('#dropdown-item1').click(function(e) {
                    e.preventDefault();

                    let asc = $(this).data('asc');

                    $.ajax({
                        type: "GET",
                        url: "{{ route('shop') }}",
                        data: {
                            sort_asc: 'asc'
                        },
                        dataType: "json",
                        success: function(response) {
                            showOrderAsc(response);
                        }

                    });

                    function showOrderAsc(response) {
                        const ordersortasc = response.products;
                        let ordersortproductlist = document.querySelector('.product-list');
                        ordersortproductlist.innerHTML = "";

                        ordersortasc.forEach((items) => {
                            const productordersortasc = `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${items.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${items.slug}">${items.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${items.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                            ordersortproductlist.insertAdjacentHTML('beforeend', productordersortasc);
                        })
                    }
                });

                //order Z-A for name

                $('#dropdown-item2').click(function(e) {
                    e.preventDefault();

                    let desc = $(this).data('desc');

                    $.ajax({
                        type: "GET",
                        url: "{{ route('shop') }}",
                        data: {
                            sort_desc: 'desc'
                        },
                        dataType: "json",
                        success: function(response) {
                            showOrderDesc(response);
                        }
                    });

                    function showOrderDesc(response) {
                        const ordersortdesc = response.products;
                        let ordersortdescproductlist = document.querySelector('.product-list');

                        ordersortdescproductlist.innerHTML = "";

                        ordersortdesc.forEach((items) => {
                            const productordersortdesc = `  <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${items.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${items.slug}">${items.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${items.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            ordersortdescproductlist.insertAdjacentHTML('beforeend',
                                productordersortdesc);
                        })
                    }
                });

                //order +1 for price
                $('#incremenet-data').click(function(e) {
                    e.preventDefault();
                    $priceincremenet = $(this).data('price-increment');

                    $.ajax({
                        type: "GET",
                        url: "{{ 'shop' }}",
                        data: {
                            sort_price_increment: 'price-increment'
                        },
                        dataType: "json",
                        success: function(response) {
                            //console.log(response);
                            showPriceMinToMax(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error);
                        }
                    });

                    function showPriceMinToMax(data) {

                        const productprice = data.products;
                        let productpricelist = document.querySelector('.product-list');
                        productpricelist.innerHTML = "";

                        productprice.forEach((items) => {
                            const productordermintomax = `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${items.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${items.slug}">${items.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${items.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                            productpricelist.insertAdjacentHTML('beforeend', productordermintomax);

                        })


                    }
                });

                //order -1 for price

                $('#decrement-data').click(function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: "GET",
                        url: "{{ url('shop') }}", // URL'i doğru şekilde tanımlayın
                        data: {
                            sort_price_decrement: 'price-decrement',
                        },
                        dataType: "json",
                        success: function(response) {
                            showPriceMaxToMin(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error); // `error` değişkenini ekledik
                        }
                    });

                    function showPriceMaxToMin(data) {
                        const productpricem = data.products;
                        let productpricelistm = document.querySelector('.product-list');
                        productpricelistm.innerHTML = "";

                        productpricem.forEach((items) => {
                            const productorderm = `
                                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                        <div class="product-item bg-light mb-4">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" src="${items.images}" alt="">
                                                <div class="product-action">
                                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center py-4">
                                                <a class="h6 text-decoration-none text-truncate" href="/detail/${items.slug}">${items.name}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${items.price} AZN (MANAT)</h5>
                                                    <h6 class="text-muted ml-2"><del>$9</del></h6>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small>(90)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                            productpricelistm.insertAdjacentHTML('beforeend', productorderm);
                        });
                    }
                });
                //////////////////////
                $('#table-block').click(function(e) {
                    e.preventDefault();

                    let table_block = $(this).data('block');

                    $.ajax({
                        type: "GET",
                        url: "{{ 'shop' }}",
                        data: {
                            table_block: 'table_block'
                        },
                        dataType: "json",
                        success: function(response) {
                            dataBlockList(response)
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error);
                        }
                    });

                    function dataBlockList(response) {
                        const blockData = response.products;
                        let blockDataList = document.querySelector('.product-list');
                        blockDataList.innerHTML = "";

                        blockData.map((item) => {
                            const blockDataContent = `
                            <div class="container">
                            <div class="d-block">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${item.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${item.slug}">${item.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>$${item.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            `;
                            blockDataList.insertAdjacentHTML('beforeend', blockDataContent);

                        })
                    }
                });

                $('#table-grid').click(function(e) {
                    e.preventDefault();

                    let table_grid = $(this).data('grid');

                    $.ajax({
                        type: "GET",
                        url: "{{ 'shop' }}",
                        data: {
                            table_grid: 'table_grid'
                        },
                        dataType: "json",
                        success: function(response) {
                            dataGridList(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error);
                        }
                    });

                    function dataGridList(response) {
                        const gridData = response.products;
                        let gridDataList = document.querySelector('.product-list');
                        gridDataList.innerHTML = "";

                        gridData.forEach((item) => {
                            const gridDataContent = `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="${item.images}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="/detail/${item.slug}">${item.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>$${item.price} AZN (MANAT)</h5>
                                            <h6 class="text-muted ml-2"><del>$9</del></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(90)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                            gridDataList.insertAdjacentHTML('beforeend', gridDataContent);
                        })
                    }
                });
            });
        </script>
    @endpush
@endsection
