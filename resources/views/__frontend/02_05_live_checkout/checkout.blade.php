@extends('frontend.master')
@section('content')
    @include('frontend.inc.css2')
    <?php
    $shipping_method_charge = Session::get('shipping_method.method_charge');
    $shipping_method_name = Session::get('shipping_method.method_name');
    $coupon_code = Session::get('coupon.coupon_code');
    $coupon_amount = Session::get('coupon.coupon_amount');
    $net_sub_total = $sub_total + $tax + $shipping_method_charge;
    $grand_total = $sub_total + $tax + $shipping_method_charge - $coupon_amount;
    ?>
    <section class="site-content">
        <div class="container">
            <div class="breadcum-area">
                <div class="breadcum-inner">
                    <h3>Checkout</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Checkout</a></li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">
                                @if(session('step')==0)
                                    Shipping Address
                                @elseif(session('step')==1)
                                    Billing Address
                                @elseif(session('step')==2)
                                    Shipping Methods
                                @elseif(session('step')==3)
                                    Order Detail
                                @endif
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="checkout-area">
                <div class="row">
                    <div class="col-12 col-lg-8 checkout-left">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(session('step')==0) active @elseif(session('step')>0) active-check @endif"
                                   id="shipping-tab" data-toggle="pill" href="#pills-shipping" role="tab"
                                   aria-controls="pills-shpping"
                                   aria-expanded="true">Shipping Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('step')==1) active @elseif(session('step')>1) active-check @endif"
                                   @if(session('step')>=1) id="billing-tab" data-toggle="pill" href="#pills-billing"
                                   role="tab" aria-controls="pills-billing"
                                   aria-expanded="true" @endif >Billing Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('step')==2) active @elseif(session('step')>2) active-check @endif"
                                   @if(session('step')>=2)  id="shipping-methods-tab" data-toggle="pill"
                                   href="#pills-shipping-methods" role="tab" aria-controls="pills-shipping-methods"
                                   aria-expanded="true" @endif>Shipping Methods</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('step')==3) active @elseif(session('step')>3) active-check @endif"
                                   @if(session('step')>=3)  id="order-tab" data-toggle="pill" href="#pills-order"
                                   role="tab" aria-controls="pills-order"
                                   aria-expanded="true" @endif>Order Detail</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if(session('step') == 0) show active in @endif"
                                 id="pills-shipping"
                                 role="tabpanel" aria-labelledby="shipping-tab">
                                @include('frontend.checkout.shipping_address')
                            </div>
                            <div class="tab-pane fade @if(session('step') == 1) show active in @endif"
                                 id="pills-billing"
                                 role="tabpanel" aria-labelledby="billing-tab">
                                @include('frontend.checkout.billing_address')
                            </div>
                            <div class="tab-pane fade @if(session('step') == 2) show active in @endif"
                                 id="pills-shipping-methods" role="tabpanel" aria-labelledby="shipping-methods-tab">
                                @include('frontend.checkout.shipping_method')
                            </div>
                            <div class="tab-pane fade @if(session('step') == 3) show active in @endif" id="pills-order"
                                 role="tabpanel" aria-labelledby="order-tab">
                                {!! Form::open(['method'=>'post', 'url'=>'place_order', 'id'=>'place_order']) !!}
                                <div class="order-review">
                                    @include('frontend.checkout.order_review')
                                </div>
                                @include('frontend.checkout.order_note_summary')
                                @include('frontend.checkout.payment_method')
                                <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                <input type="hidden" name="tax" value="{{ $tax }}">
                                <input type="hidden" name="coupon_code" class="coupon_code"
                                       value="{{ $coupon_code }}">
                                <input type="hidden" name="coupon_amount" class="coupon_amount"
                                       value="{{ $coupon_amount }}">
                                <input type="hidden" name="grand_total" class="grand_total"
                                       value="{{ $grand_total }}">
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div> <!--CHECKOUT LEFT CLOSE-->
                @include('frontend.checkout.right_bar')   <!--CHECKOUT RIGHT CLOSE-->
                </div>
            </div>
        </div>
    </section>
@endsection


