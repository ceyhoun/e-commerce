@extends('frontend.layouts.layouts')
@section('content')
    @include('frontend.partials.crumb')
    <!-- Cart Start -->
    <div class="container">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Məhsullar</th>
                                <th>Photo</th>
                                <th>Qiymət</th>
                                <th>Say</th>
                                <th>Qiymet</th>
                                <th>Sebete</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($favorites as $order)
                                <tr>
                                    <td class="align-middle">
                                        {{ $order['name'] }}
                                    </td>
                                    <td class="align-middle">
                                        <img src="{{ url($order['images']) }}" alt="image" style="width: 50px; height: 50px;">
                                    </td>

                                    <td class="align-middle"></td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="number"
                                                class="form-control form-control-sm bg-secondary border-0 text-center"
                                                min="1" max=""
                                                value="">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle"></td>
                                    <td>
                                        <form id="delete-form" method="POST"
                                        action="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm(`Sebete Elave Olunsun mu ?`)" id="deleteBtn">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                    </td>
                                    <td>
                                        <form id="delete-form" method="POST"
                                            action="">
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
