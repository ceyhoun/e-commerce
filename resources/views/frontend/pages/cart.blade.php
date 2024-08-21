@extends('frontend.layouts.layouts')
@section('content')
    @include('frontend.partials.crumb')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                @if (isset($userorders) && $userorders->count() > 0)
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Məhsullar</th>
                                <th>Photo</th>
                                <th>Qiymət</th>
                                <th>Say</th>
                                <th>Qiymet</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($userorders as $order)
                                <tr>
                                    <td class="align-middle">
                                        {{ $order->products->name }}
                                    </td>
                                    <td class="align-middle">
                                        <img src="{{ url($order->products->images) }}" alt="image" style="width: 30px;">
                                    </td>

                                    <td class="align-middle">{{ $order->products->price }}</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="number"
                                                class="form-control form-control-sm bg-secondary border-0 text-center"
                                                min="1" max="{{ $order->products->qty }}"
                                                value="{{ $order->product_qty }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ $order->product_qty * $order->products->price }}</td>
                                    <td>
                                        <form id="delete-form-{{ $order->id }}" method="POST"
                                            action="{{ route('itemDelete', ['id' => $order->id, 'product_id' => $order->product_id]) }}">
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
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>{{ $order->product_qty * $order->products->price }} AZN</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>

                            <h6 class="font-weight-medium">
                                {{ $order->product_qty * $order->products->price }}
                            </h6>



                        </div>

                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Ümumi</h5>
                            <h5 id="total"></h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Tesdiqle</button>
                    </div>
                </div>
            </div>
        @else
            <p>No items added to the cart</p>
            @endif
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('content')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                document.querySelectorAll('.btn-minus').forEach(button => {
                    button.addEventListener('click', function() {
                        let input = this.closest('.quantity').querySelector('input[type="number"]');
                        let value = parseInt(input.value) - 1;
                        if (value >= input.min) {
                            input.value = value;
                        }
                    });
                });

                document.querySelectorAll('.btn-plus').forEach(button => {
                    button.addEventListener('click', function() {
                        let input = this.closest('.quantity').querySelector('input[type="number"]');
                        let value = parseInt(input.value) + 1;
                        if (value <= input.max) {
                            input.value = value;
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
