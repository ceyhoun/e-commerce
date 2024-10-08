@extends('frontend.layouts.layouts')
@section('content')
@include('frontend.partials.crumb')
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">
            Employee</span></h2>
    <div class="row px-xl-5">
        @if (! empty($employies) && $employies->count() > 0)
        @foreach ($employies as $employee)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{url("$employee->image")}}" alt="">
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate"
                            href="">{{$employee->name ?? 'yox'}} {{$employee->surname ?? 'yox'}}</a>

                        <h5 class="text-muted ml-2">{{$employee->role ?? 'yox'}}</h5>
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
            @endif
    </div>
</div>
@endsection
