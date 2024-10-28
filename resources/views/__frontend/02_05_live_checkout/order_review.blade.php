<div class="table">
    <table class="table">
        <thead>
        <tr>
            <th class="cart_product">Product</th>
            <th>Description</th>
            <th>Unit price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @forelse($cart as $id => $item)
            <tr id="tr_{{$item->rowId}}" class="removeCartTrLi">
                <td class="cart_product">
                    <a href="{{ url('product/'.$item->options->slug) }}">
                        <img src="{{ SM::sm_get_the_src($item->options->image, 100, 122) }}"
                             alt="{{ $item->name }}"></a>
                </td>
                <td class="cart_description">
                    <p class="product-name">
                        <a href="{{ url('product/'.$item->options->slug) }}"><strong>{{ $item->name }}</strong> </a></p>
                    <br>
                    <small class="cart_ref">SKU : {{ $item->options->sku }}</small>
                    <br>
                    @if($item->options->colorname != '')
                        <small>Color : {{$item->options->colorname}}</small>
                        <br>
                    @endif
                    @if($item->options->sizename != '')
                        <small>Size : {{$item->options->sizename}}</small>
                    @endif
                </td>
                <td class="price"><span>{{ SM::currency_price_value($item->price) }}</span></td>
                <td class="qty">
                    <span>{{ $item->qty }}</span>
                </td>
                <td class="price">
                    <span>{{ SM::currency_price_value($item->price * $item->qty) }}</span>
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
    </table>
</div>