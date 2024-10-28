<?php
$productSecondLoop = 1;
?>
@if(count($productLists) > 0)
@foreach($productLists as $product)
@if($product->product_type==2)
<?php
$att_data = SM::getAttributeByProductId($product->id);
if (!empty($att_data->attribute_image)) {
    $attribute_image = $att_data->attribute_image;
} else {
    $attribute_image = $product->image;
}
?>
<li class="col-sx-12 col-sm-4">
    <div class="product-container">
        <div class="left-block">
            <a href="{{ url('product/'.$product->slug) }}">
                <img class="img-responsive" alt="{{ $product->title }}"
                     src="{{ SM::sm_get_the_src($attribute_image, 268, 327) }}"/>
            </a>
            <div class="quick-view">
                <?php echo SM::quickViewHtml($product->id, $product->slug); ?>
            </div>
            <div class="add-to-cart">
                <?php echo SM::addToCartButton($product->id, $product->regular_price, $product->sale_price); ?>
            </div>
        </div>
        <div class="right-block">
            <h5 class="product-name">
                <a href="{{ url('product/'.$product->slug) }}">{{ $product->title }}</a>
            </h5>
            <div class="product-star">
                <?php echo SM::product_review($product->id) ?>
            </div>
            <div class="content_price">
                <span class="price product-price">{{ SM::currency_price_value($att_data->attribute_price) }}</span>

            </div>
            <div class="info-orther">
                <p>Item Code: #453217907</p>
                <p class="availability">Availability: <span>{{ $product->in_stock }}</span></p>
                <div class="product-desc">
                    {{ $product->short_description }}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</li>
@else
<li class="col-sx-12 col-sm-4">
    <div class="product-container">
        <div class="left-block">
            <a href="{{ url('product/'.$product->slug) }}">
                <img class="img-responsive" alt="{{ $product->title }}"
                     src="{{ SM::sm_get_the_src($product->image, 268, 327) }}"/>
            </a>
            <div class="quick-view">
                <?php echo SM::quickViewHtml($product->id, $product->slug); ?>
            </div>
            <div class="add-to-cart">
                <?php echo SM::addToCartButton($product->id, $product->regular_price, $product->sale_price); ?>
            </div>
        </div>
        <div class="right-block">
            <h5 class="product-name">
                <a href="{{ url('product/'.$product->slug) }}">{{ $product->title }}</a>
            </h5>
            <div class="product-star">
                <?php echo SM::product_review($product->id) ?>
            </div>

            <div class="content_price">
                @if($product->sale_price>0)
                <span class="price product-price"> {{ SM::currency_price_value($product->sale_price) }}</span>
                <span class="price old-price">{{ SM::currency_price_value($product->regular_price) }}</span>
                @else
                <span class="price product-price">{{ SM::currency_price_value($product->regular_price) }}</span>
                @endif
            </div>
            <div class="info-orther">
                <p>Item Code: #453217907</p>
                <p class="availability">Availability: <span>{{ $product->in_stock }}</span></p>
                <div class="product-desc">
                    {{ $product->short_description }}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</li>
@endif
@endforeach
@else
<div class="alert alert-info"><i class="fa fa-info"></i> No Product Found!</div>
@endif
<div class="col-md-12" style="margin-top: 25px;">
    {!! $productLists->links() !!}
</div>
