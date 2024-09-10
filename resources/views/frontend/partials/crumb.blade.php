    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="/">Home</a>
                    @if (Request::is('shop'))
                    <a class="breadcrumb-item text-dark" href="{{ route('shop') }}">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                    @elseif (Request::is('employee'))
                    <a class="breadcrumb-item text-dark" href="{{ route('employee') }}">Employee</a>
                    <span class="breadcrumb-item active">Employee List</span>
                    @elseif (Request::is('cart'))
                    <a class="breadcrumb-item text-dark" href="{{ route('cart') }}">Cart</a>
                    <span class="breadcrumb-item active">Cart List</span>
                    @elseif (Request::is('favory'))
                    <a class="breadcrumb-item text-dark" href="{{ route('favory') }}">Favory</a>
                        <span class="breadcrumb-item active">Favory List</span>
                    @elseif (Request::is('contact'))
                    <a class="breadcrumb-item text-dark" href="{{ route('contact') }}">Contact</a>
                        <span class="breadcrumb-item active">Contact List</span>
                    @elseif (Request::is('detail/*'))
                    <a class="breadcrumb-item text-dark" href="{{ route('detail') }}">Detail</a>
                        <span class="breadcrumb-item active">Detail List</span>
                    @elseif (Request::is('search'))
                    <a class="breadcrumb-item text-dark" href="{{ route('search') }}">Search</a>
                    <span class="breadcrumb-item active">Search List</span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
