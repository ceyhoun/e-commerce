<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ url('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ url('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ url('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/3.2.4/svg.min.js"
        integrity="sha512-ovlWyhrYXr3HEkGJI5YPXIFYIbHEKs2yfemKVVIIQe9U74tXyTuVdzMlvZlw/0X5lnIDRgtVlckrkeuCrDpq4Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (Opsiyonel) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <style>
 .star-rating {
    display: inline-flex;
    direction: rtl; /* Sağdan sola sıralama */
    font-size: 2rem;
}

.star-rating input[type="radio"] {
    display: none;
}

.star-rating label {
    color: #d3d3d3; /* Varsayılan gri renk */
    cursor: pointer;
    transition: color 0.3s;
}

.star-rating input[type="radio"]:checked ~ label {
    color: #f5c518; /* Seçili yıldızlar için sarı renk */
}

.star-rating input[type="radio"]:checked ~ label ~ label {
    color: #f5c518; /* Seçili yıldız ve sağındaki yıldızlar sarı olacak */
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f5c518; /* Hover durumunda yıldızlar sarı olur */
}


    </style>
</head>

<body>

    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ url('lib/easing/easing.min.js') }}"></script>
    <script src="{{ url('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ url('mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ url('mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ url('js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
