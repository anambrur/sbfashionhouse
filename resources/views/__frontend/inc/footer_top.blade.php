@php
    $current = \Carbon\Carbon::now();
@endphp
<style>

    .thumb img {
        background-size: cover;
        background-position: center;
        transition: all 0.7s ease;
    }

    .thumb img:hover {
        transform: scale(1.5);
    }

    #ShowDivButton img {
        height: 60px;
        text-align: center;
    }
</style>
<section class="banner-content">
    <button class="bttn-cart showButton cart_icon_popup" id="ShowDivButton">
        <img src="{{url('frontend/images/favorite-cart.gif')}}" alt="">
        <p>{{ Cart::instance('cart')->count() }} Item(s)</p>
        <p><span>{{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}</span></p>
    </button>

    <div id="aitcg-control-panel" style="display: none">
        <button class="bttn-close hideButton" id="ShowDivButton">
            <i class="fa fa-times"></i> Close
        </button>
        <h1 class="popup_top_total"><i class="fa fa-shopping-bag"></i> {{ Cart::instance('cart')->count() }} ITEMS</h1>
        <h4>Trusted Online Shopping Site</h4>
        <div class="add-product-area right_cart_html" style="max-height: 400px; overflow-y: scroll">
            <?php $items = Cart::instance('cart')->content(); ?>
            @forelse($items as $id=>$item)
                @if(!empty($dateV))
                  @if($dateV->validity <= $current && $dateV->validity_end >= $current)
                      @if($item->options['offer_type'] == 4)
                          <small style="color: green;">Got (Qty: {{ $item->qty }}) Free!</small><br>
                      @endif
                  @endif
                @endif
                <div class="add-pro-liner">
                    <div class="counting">
                        <i class="fa fa-plus inc" data-row_id="{{ $item->rowId }}" style="color: green;"></i>
                        <input type="hidden" name="qty" class="form-control input-sm qty-inc-dc"
                               id="{{ $item->rowId }}" value="{{ $item->qty }}">
                        <h3 class="itemqty"><span>{{$item->qty}}</span></h3>
                        <i class="fa fa-minus dec" data-row_id="{{ $item->rowId }}" style="color: green;"></i>
                    </div>

                    <img src="{{ SM::sm_get_the_src($item->options->image, 100, 122) }}" alt="{{$item->name}}">
                    <div class="pro-head">
                        <h3>{{$item->name}}</h3>
                        <h3 class="ammount">{{SM::currency_price_value($item->price)}}</h3>
                    </div>

                    <span class="pro-close removeToCart" data-product_id="{{$id}}"
                          onclick="delete_cart_product($id)"><i class="fa fa-times-circle"></i></span>
                </div>
                <hr>
            @empty
                <div class="empty_img image-emty">
                    <img src="{{url('frontend/images/favorite-cart.gif')}}" alt="">
                </div>
                <div class="text-center">
                    <span>Empty Cart</span>
                </div>
            @endforelse
        </div>

        <div class="add-btn-area">
            <h5 class="sub_total">{{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}</h5>
            <!--<a class="btn btn-add-place" data-toggle="modal" data-target="#myLogin" href="">Place Order</a>-->
            <a class="btn btn-add-place" href="{{URL('cart')}}">Place Order</a>
        </div>

        <div class="text-center">
            <a class="btn btn-info view-cart-btn-ex" href="{{url('/cart')}}">View Cart</a>
        </div>
    </div>
</section>