@extends('frontend.master')
@section('title', 'Cart')
@section('content')
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Your shopping cart</span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading no-line">
            <span class="page-heading-title2">Shopping Cart Summary</span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content page-order">
            <ul class="step">
                <li class="current-step"><span>01. Summary</span></li>
                <li><span>02. Sign in</span></li>
                <li><span>03. Address</span></li>
                <li><span>04. Shipping</span></li>
                <li><span>05. Payment</span></li>
            </ul>
            <div class="heading-counter warning">Your shopping cart contains:
                <span>1 Product</span>
            </div>
            <div class="order-detail-content table-responsive">
                <table class="table table-bordered table-responsive cart_summary">
                    <thead>
                        <tr>
                            <th class="cart_product">Product</th>
                            <th>Description</th>
                            <th>Avail.</th>
                            <th>Unit price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th class="action"><i class="fa fa-trash-o"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cart as $id => $item)
                            <tr>
                                <td class="cart_product">
                                    <a href="#"><img src="{{ asset('frontend/') }}/data/product-100x122.jpg"
                                                     alt="Product"></a>
                                </td>
                                <td class="cart_description">
                                    <p class="product-name"><a href="#">{{ $item->name }} </a></p>
                                    <small class="cart_ref">SKU : #123654999</small>
                                    <br>
                                    <small><a href="#">Color : Beige</a></small>
                                    <br>
                                    <small><a href="#">Size : S</a></small>
                                </td>
                                <td class="cart_avail"><span class="label label-success">In stock</span></td>
                                <td class="price"><span>{{ $item->price }} TK</span></td>
                                <td class="qty">
                                    {!! Form::text('qty', $item->qty , ['id' => 'option-product-qty','class'=>'form-control input-sm qty-inc-dc']) !!}
                                    {{--<input class="form-control input-sm" type="text" value="{{ $item->qty }}">--}}
                                    <a id="inc"><i class="fa fa-caret-up"></i></a>
                                    <a id="dec"><i class="fa fa-caret-down"></i></a>
                                </td>
                                <td class="price">
                                    <span>{{ $item->price * $item->qty }} TK</span>
                                </td>
                                <td class="action">
                                    <a href="{{ url('product/cart/destroy') }}/{{ $item->rowId }}"
                                       title="Delete" class="btn btn-xs btn-default delete_data_row"
                                       delete_message="Are you sure to remove this item?"
                                       delete_row="tr_{{$brand->id}}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
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
                            <td colspan="2">{{Cart::subTotal()}} TK</td>
                        </tr>


                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="2"><strong>{{Cart::total()}} TK</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="cart_navigation">
                    <a class="prev-btn" href="{{url('/shop')}}">Continue shopping</a>
                    <?php if (Auth::check()) { ?>
                        <a class="next-btn" href="{{url('/checkout')}}">Proceed to checkout</a>

                    <?php } else { ?>
                        <a href="#" class="next-btn" data-toggle="modal" data-target="#loginModal">Proceed to checkout</a>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./page wapper-->
@endsection