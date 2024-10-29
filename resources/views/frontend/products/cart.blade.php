@extends('frontend.master')
@section('title', 'Cart')
@push('style')
    <style>
        .invalid {
            color: #ff0000;
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <!-- page wapper-->
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
            @include('frontend.common.breadcrumb')
            <!-- ./breadcrumb -->
            <!-- page heading-->

            <h2 class="page-heading no-line" style="display: none;">
                <span class="page-heading-title2">Shopping Cart Summary</span>
            </h2>
            <!-- ../page heading-->
            <div class="row">
                <form action="{{ url('/confirm-order') }}" method="POST" id="phoneForms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-4 bg-white">
                        <div class="page-content page-order">

                            <div class="form-group">
                                <label for="Inputtext1">Name</label>
                                <input type="text" name="name" class="form-control" id="Inputtext1"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="form-group">
                                <label for="mobileNumber">Phone Number</label>
                                <input type="text" name="mobile" class="form-control" id="mobileNumber"
                                    placeholder="Enter your phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="Inputtext3">Address</label>
                                <textarea class="form-control" name="address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Inputtext3">Delivery Area</label>
                                <select class="form-control" name="shipping_method" id="shipping_method">
                                    <option value="">Please Select Delivery Area</option>
                                    @foreach ($shippingMethods as $item)
                                        <option value="{{ $item->id }}" data-charge="{{ $item->charge }}">
                                            {{ $item->title }} Charge: {{ $item->charge }}Tk
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">

                                <input type="checkbox" checked name="is_cash_on_delivery" id="is_cash_on_delivery">
                                <label for="is_cash_on_delivery">Cash on Delivery</label>
                                <span id="cash_on_delivery_charge"></span>

                                <input type="checkbox" name="online_payment" id="online_payment">
                                <label for="online_payment">Online Payment</label>
                                <span id="cash_on_delivery_charge"></span>
                            </div>


                            <div class="cart_navigation">
                                <button type="button" class="btn btn-success" id="ConfirmBtn">Confirm Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="page-content page-order">
                            <div class="heading-counter warning">Your shopping cart contains:
                                <span>{{ count($cart) }} Product</span>
                            </div>
                            <div class="order-detail-content table-responsive">
                                <table class="table table-bordered table-responsive cart_summary cart_table">
                                    <thead>
                                        <tr>
                                            <th class="cart_product">Product</th>
                                            <th>Description</th>
                                            <th>Unit price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th class="action"><i class="fa fa-trash-o"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($cart as $id => $item)
                                            <tr id="tr_{{ $item->rowId }}" class="removeCartTrLi">
                                                <td class="cart_product">
                                                    <a href="{{ url('product/' . $item->options->slug) }}">
                                                        <img src="{{ SM::sm_get_the_src($item->options->image, 100, 100) }}"
                                                            alt="{{ $item->name }}"></a>
                                                </td>
                                                <td class="cart_description">
                                                    <p class="product-name">
                                                        <a href="{{ url('product/' . $item->options->slug) }}"><strong>{{ $item->name }}</strong>
                                                        </a>
                                                    </p>
                                                    <br>
                                                    <small class="cart_ref">SKU : {{ $item->options->sku }}</small>
                                                    <br>
                                                    @if ($item->options->colorname != '')
                                                        <small>Color : {{ $item->options->colorname }}</small>
                                                        <br>
                                                    @endif
                                                    @if ($item->options->sizename != '')
                                                        <small>Size : {{ $item->options->sizename }}</small>
                                                    @endif
                                                </td>
                                                <td class="price"><span>{{ SM::currency_price_value($item->price) }}
                                                    </span>
                                                </td>
                                                <td class="qty">
                                                    <style>
                                                        .input-group-btn {
                                                            font-size: unset;
                                                        }
                                                    </style>
                                                    <div class="input-group">
                                                        <span id="" class="input-group-btn dec"
                                                            data-row_id="{{ $item->rowId }}"><i class="fa fa-minus"
                                                                aria-hidden="true"></i></span>
                                                        <input type="text" name="qty"
                                                            class="form-control input-sm qty-inc-dc"
                                                            id="{{ $item->rowId }}" value="{{ $item->qty }}">
                                                        <span class="input-group-btn inc" data-row_id="{{ $item->rowId }}"
                                                            id=""><i class="fa fa-plus"
                                                                aria-hidden="true"></i></span>
                                                    </div>
                                                </td>
                                                <td class="price">
                                                    <span>{{ SM::currency_price_value($item->price * $item->qty) }} </span>
                                                </td>
                                                <td class="action">
                                                    <a data-product_id="{{ $item->rowId }}"
                                                        class="remove_link removeToCart" title="Delete item"
                                                        href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <p class="product-name" style="color: red">No data found!</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" rowspan="3"></td>
                                            <td colspan="3">Sub Total</td>
                                            <td colspan="2">{{ SM::product_price(Cart::instance('cart')->subTotal()) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Tax</strong></td>
                                            <td colspan="2">
                                                <strong>{{ SM::product_price(Cart::instance('cart')->tax()) }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Delivery Charge</strong></td>
                                            <td colspan="2" id="delivery_charge">
                                                <strong>TK 0.00</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <input type="hidden" id="initial_total_price"
                                                value="{{ Cart::instance('cart')->total() }}">
                                            <input type="text" value="" name="grand_total" id="grand_total">
                                            <td colspan="5"><strong>Total</strong></td>
                                            <td colspan="2" id="total_price">
                                                <strong>{{ SM::product_price(Cart::instance('cart')->total()) }}</strong>
                                            </td>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                            <div class="checkout-buttons">
                                <div class="cart_navigation">
                                    <a class="prev-btn" href="{{ url('/shop') }}">Continue shopping</a>
                                </div>
                                {{-- <div class="cart_navigation">
                                    @if (Auth::check())
                                        <a class="next-btn" href="{{ url('/checkout') }}">Proceed to checkout</a>
                                    @else
                                        <a class="next-btn" data-toggle="modal" data-target="#loginModal"
                                            href="#">Proceed
                                            to
                                            checkout</a>
                                    @endif
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- OTP Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpModalLabel">OTP Verification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="otp">Enter OTP</label>
                        <input type="text" id="otp" class="form-control" placeholder="Enter OTP">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="otpSubmitBtn">Submit OTP</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ./page wapper-->
@endsection


@push('script')
    <script>
        $(document).ready(function() {

            $("#phoneForms").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    mobile: {
                        required: true,
                        minlength: 11
                    },
                    address: {
                        required: true,

                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Your name must be at least 3 characters long"
                    },
                    mobile: {
                        required: "Please enter your mobile number",
                        minlength: "Your email must be at least 11 characters long"
                    },
                    address: {
                        required: "Please enter your address",
                    }
                },
                submitHandler: function(form) {
                    alert("Form submitted successfully!");
                    form.submit();
                }
            });

            $('#ConfirmBtn').click(function() {
                var mobile = $('#mobileNumber').val();
                $.ajax({
                    url: '{{ route('check.authentication') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        mobile: mobile
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log("see", response.status);
                            $('#phoneForms').submit();
                        } else {
                            console.log("fff", response.status);
                            $('#otpModal').modal('show');
                        }
                    }
                })
            });

            $('#otpSubmitBtn').click(function() {
                var otp = $('#otp').val();
                $.ajax({
                    url: '{{ route('verify.otp') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        mobile: $('#mobileNumber').val(),
                        otp: otp
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#otpModal').modal('hide');
                            $('#phoneForms').submit();
                        } else {
                            alert('Invalid OTP, please try again.');
                        }
                    }
                });
            });

            $('#shipping_method').change(function() {
                var selectedOption = $('#shipping_method option:selected');
                var shippingCharge = parseFloat(selectedOption.data('charge')) || 0;
                var initialTotal = parseFloat($('#initial_total_price').val()) || 0;
                var newTotal = initialTotal + shippingCharge;

                $('#delivery_charge').html('<strong>TK ' + shippingCharge.toFixed(2) + '</strong>');
                $('#total_price').html('<strong>TK ' + newTotal.toFixed(2) + '</strong>');

                $('#grand_total').val(newTotal);
            });
        });
    </script>
@endpush
