@extends('frontend.master')
@section('title', 'Checkout')
@section('content')
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
                                   aria-controls="pills-shpping" aria-expanded="true">Shipping Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('step')==1) active @elseif(session('step')>1) active-check @endif"
                                   @if(session('step')>=1) id="billing-tab" data-toggle="pill" href="#pills-billing"
                                   role="tab" aria-controls="pills-billing" aria-expanded="true" @endif >Billing
                                    Address</a>
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
                                   role="tab" aria-controls="pills-order" aria-expanded="true" @endif>Order Detail</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if(session('step') == 0) show active in @endif"
                                 id="pills-shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                @include('frontend.checkout.shipping')
                            </div>

                            <div class="tab-pane fade @if(session('step') == 1) show active in @endif"
                                 id="pills-billing" role="tabpanel" aria-labelledby="billing-tab">
                                @include('frontend.checkout.billing')
                            </div>

                            <div class="tab-pane fade @if(session('step') == 2) show active in @endif"
                                 id="pills-shipping-methods" role="tabpanel" aria-labelledby="shipping-methods-tab">
                                @include('frontend.checkout.payment_methods')
                            </div>

                            <div class="tab-pane fade @if(session('step') == 3) show active in @endif" id="pills-order"
                                 role="tabpanel" aria-labelledby="order-tab">
                                @include('frontend.checkout.order_detail')
                            </div>
                        </div>

                    </div> <!--CHECKOUT LEFT CLOSE-->

                    <div class="col-12 col-lg-4 checkout-right">
                        <div class="order-summary-outer">
                            <div class="order-summary">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th colspan="2">Order Summary</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th><span>SubTotal</span></th>
                                            <td align="right" id="subtotal">{{$price+0}}</td>
                                        </tr>
                                        <tr>
                                            <th><span>Tax</span></th>
                                            <td align="right">{{$tax_rate}}</td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span>Shipping Cost</br>
                                                    <small>{{$shipping_name}}</small></span></span></th>
                                            <td align="right">{{$shipping_price}}</td>
                                        </tr>
                                        <tr>
                                            <th><span>Discount(Coupon)</span></th>
                                            <td align="right"
                                                id="discount">{{number_format((float)session('coupon_discount'), 2, '.', '')+0}}</td>
                                        </tr>
                                        <tr>
                                            <th class="last"><span>Total</span></th>
                                            <td class="last" align="right"
                                                id="total_price">{{number_format((float)$total_price+0, 2, '.', '')+0}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="coupons">
                                <!-- applied copuns -->


                                @if(count(session('coupon')) > 0 and !empty(session('coupon')))

                                    <div class="form-group">
                                        <label>Coupon Applied</label>
                                        @foreach(session('coupon') as $coupons_show)

                                            <div class="alert alert-success">
                                                <a href="{{ URL::to('/removeCoupon/'.$coupons_show->coupans_id)}}"
                                                   class="close"><span aria-hidden="true">&times;</span></a>
                                                {{$coupons_show->code}}
                                            </div>

                                        @endforeach
                                    </div>
                                @endif
                                <form id="apply_coupon">
                                    <div class="form-group">
                                        <label for="inputPassword2" class="">Coupon Code</label>
                                        <input type="text" name="coupon_code" class="form-control" id="coupon_code">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-dark">ApplyCoupon</button>
                                    <div id="coupon_error" style="display: none"></div>
                                    <div id="coupon_require_error" style="display: none">Please enter a valid coupon
                                        code
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>  <!--CHECKOUT RIGHT CLOSE-->
                </div>
            </div>
        </div>
    </section>
@endsection