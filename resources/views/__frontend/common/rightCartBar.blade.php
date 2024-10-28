<style>

    .add-product-area {

        padding-top: 5px;

    }
    .empty_img.image-emty {
    overflow: hidden;
    width: 140px;
    margin: 0 auto;
    border-radius: 100px;
    padding: 20px;
    background: #ffffff;
    border: 5px solid #f5f5f5;
}

img.image-emty-busket {
    height: 100px;
    text-align: center;
}
    

</style>

<button class="bttn-cart" id="ShowDivButton" onclick="showDiv()">

    <p>Check Your Order</p>

    <img src="/storage/uploads/favorite-cart.gif"style="height:50px;">

    <h3><span class="cart_count">{{ Cart::instance('cart')->count() }}</span> Items</h3>

    <h5><span class="cart_sub_total">{{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}</span></h5>

</button>



<div id="aitcg-control-panel">

    <button class="bttn-close" id="ShowDivButton" onclick="hideDiv()"><i class="fa fa-times"></i></button>

    <h1><i class="fa fa-shopping-bag"></i> <span class="cart_count">{{ Cart::instance('cart')->count() }}</span> Items

    </h1>

    <h4>Your Cart</h4>

    <div class="add-product-area header_cart_html">

        <?php

        $items = Cart::instance('cart')->content();

        // var_dump($items);

        // exit();

        ?>

        @forelse($items as $id => $item)

            <div class="add-pro-liner">

                <div class="counting">

                    <a class="inc" data-row_id="{{ $item->rowId }}" href="JavaScript:Void(0)"><i

                                class="fa fa-plus-circle"></i></a>

                    <input type="hidden" name="qty" class="qty-inc-dc" id="{{ $item->rowId }}"

                           value="{{ $item->qty }}">

                    <h3>{{ $item->qty }}</h3>

                    @if($item->qty>1)

                        <a class="dec" data-row_id="{{ $item->rowId }}" href="JavaScript:Void(0)"><i

                                    class="fa fa-minus-circle"></i></a>

                    @endif

                </div>

                <img alt="" src="{{ SM::sm_get_the_src($item->options->image, 50, 56) }}">

                <div class="pro-head">

                    <h3>{{ $item->name }}</h3>

                    @if($item->options->sizename != '')

                        <p><small>N.W: {{ $item->options->sizename }} {{ $item->options->colorname }}</small> <small>T.W: <?php echo SM::productWeightCal1($item->options->sizename * $item->qty, $item->options->colorname); ?></small>

                        </p>

                    @endif

                </div>
                <?php
                    $Pr_new = $item->price * $item->qty ;
                ?>
                <span class="ammount "  >{{ SM::currency_price_value($Pr_new ) }}</span>

                <span class="pro-close removeToCart" data-product_id="{{$id}}"><i class="fa fa-times-circle"></i></span>

            </div>

        @empty

            <div class="empty_img image-emty">

                <img class="image-emty-busket" src="/storage/uploads/favorite-cart.gif">

            </div>

            <div class="text-center">

                <span>Empty Cart</span>

            </div>

        @endforelse

    </div>

    <div class="add-btn-area">

        <h5><span class="cart_sub_total">Total - {{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}</span></h5>

        <a class="btn btn-add-place" href="{{URL('cart')}}">Order Now</a>

    </div>

</div>