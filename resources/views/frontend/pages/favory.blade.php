@extends('frontend.layouts.layouts')
@section('content')
    @include('frontend.partials.crumb')
    <!-- Cart Start -->
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Məhsullar</th>
                                <th>Photo</th>
                                <th>Qiymət</th>
                                <th>Sebete</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach($favorites as $favory)
                            <tr>
                                    <td class="align-middle">{{$favory->products->name}}</td>
                                    <td class="align-middle">
                                        <img src="{{asset($favory->products->images)}}" alt="image" style="width: 50px; height: 50px;">
                                    </td>

                                    <td class="align-middle">{{$favory->products->price}}</td>
                                    <td>
                                        <form id="cart-form" method="POST"
                                        action="">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"
                                            onclick="return confirm(`Sebete Elave Olunsun mu ?`)" id="deleteBtn">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                    </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('deletefavory', ['id' => $favory->id, 'product_id' => $favory->product_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm(`Silinsin mi ?`)" id="deleteBtn">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                        </tbody>
                    </table>

            </div>

        </div>
    <!-- Cart End -->
@endsection
