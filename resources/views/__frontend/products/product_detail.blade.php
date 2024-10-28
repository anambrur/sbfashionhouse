@extends('frontend.master')
@section("title", $product->title)
@section("content")

<div class="columns-container">
    <div class="container" id="columns">
        </br>
       <div id="clearfix"></div>
        <!-- breadcrumb -->          
        @include('frontend.common.breadcrumb')
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Left colunm -->
            @include('frontend.products.product_detail_sidebar')
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                <!-- Product -->
                <div class="product-details" id="product">
                    <div class="primary-box">
                        <div class="row">
                            <div class="pb-left-column col-xs-12 col-sm-6">
                                <!-- product-imge-->
                                <div class="product-image">
                                    <div class="product-full">
                                        <?php
                                        if (!empty($product->image_gallery)) {
                                            $myString = $product->image_gallery;
                                            $myArray = explode(',', $myString);
                                            ?>
                                            <img id="product-zoom"
                                                 src="{!! SM::sm_get_the_src( $myArray[0] , 500, 500) !!}"
                                                 data-zoom-image="{!! SM::sm_get_the_src( $myArray[0] , 1000, 1000) !!}"
                                                 class="image-style" alt="{{$product->title}}">
                                             <?php } else { ?>
                                            @empty(!$product->image)
                                            <img id="product-zoom"
                                                 src="{!! SM::sm_get_the_src( $product->image , 500, 500) !!}"
                                                 data-zoom-image="{!! SM::sm_get_the_src( $product->image , 1000, 1000) !!}"
                                                 class="image-style" alt="{{$product->title}}">
                                            @endempty
                                        <?php } ?>
                                    </div>
                                    @empty(!$product->image_gallery)
                                    <div class="product-img-thumb" id="gallery_01">
                                        <ul class="owl-carousel" data-items="3" data-nav="true" data-dots="false"
                                            data-margin="20" data-loop="true">
                                                <?php
                                                $myString = $product->image_gallery;
                                                $myArray = explode(',', $myString);
                                                ?>
                                            @foreach($myArray as $v_data)
                                            <li>
                                                <a href="#"
                                                   data-image="{!! SM::sm_get_the_src( $v_data, 500, 500) !!}"
                                                   data-zoom-image="{!! SM::sm_get_the_src( $v_data , 1000, 1000) !!}">
                                                    <img alt="{{$product->title}}" id="product-zoom"
                                                         src="{!! SM::sm_get_the_src( $v_data, 103, 125) !!}"/>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endempty
                                </div>
                                <!-- product-imge-->
                            </div>
                            <div class="pb-right-column col-xs-12 col-sm-6">
                                <h1 class="product-name">{{$product->title}}</h1>
                                <div class="product-comments">
                                    <div class="product-star">
                                        <?php
                                        echo SM::product_review($product->id);
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $discount = 0;
                                ?>
                                <div class="product-price-group">
                                    <?php if ($product->product_type == 2) { ?>
                                        <span class="price product_price"></span>
                                    <?php } else {
                                        ?>
                                        @if($product->sale_price>0)
                                        <?php
                                        $value = $product->regular_price - $product->sale_price;
                                        $discount = $value * 100 / $product->regular_price;
                                        ?>
                                        <span class="price product-price">{{ SM::currency_price_value($product->sale_price) }}</span>
                                        <span class="old-price ">{{ SM::currency_price_value($product->regular_price) }}</span>
                                        {!! Form::hidden('price',$product->sale_price, ['class' => 'price']) !!}
                                        @else
                                        <span class="price product-price">{{ SM::currency_price_value($product->regular_price) }}</span>
                                        {!! Form::hidden('price',$product->regular_price, ['class' => 'price']) !!}
                                        @endif
                                        @if($discount>0)
                                        <span class="discount">-{{ ceil($discount) }}%</span>
                                        @endif
                                    <?php } ?>
                                </div>

                                <div class="info-orther">
                                    <p>SKU: {{ $product->sku }}</p>
                                    <p>Availability: 
                                        <?php
                                        if ($product->product_qty > 0) {
                                            ?>
                                            <span class="in-stock">{{ $product->stock_status }}</span>
                                        <?php } else { ?>
                                            <span class="out-stock">Stock Out</span>
                                    <?php } ?>
    
    
                                    </p>
                                    {{--<p>Condition: New</p>--}}
                                </div>
                                @if(!empty($product->short_description))
                                <div class="product-desc">
                                    {!! $product->short_description !!}
                                </div>
                                @endif
                                <?php
                                $item = Cart::instance('cart')->content()->where('id', $product->id)->first();
                                ?>
                                <div class="form-option">
                                    <?php if ($product->product_type == 2) { ?>
                                        {{--product_attribute--}}
                                        @include('frontend.products.product_attribute')
                                        {{--product_attribute--}}
                                    <?php } ?>
                                    <div class="attributes">
                                        <div class="attribute-label">Qty:</div>
    
                                        <div class="sinolo">
                                            @if (!empty($item))
                                            <a onclick="var less = parseInt($('.up_qty').val()) - 1; $('.up_qty').val(less);" data-row_id="{{ $item->rowId }}"class="decDetail btn btn-default btn-sm"><i class="fa fa-minus"></i>
                                            </a>
                                            <input type="text" value="{{ $item->qty }}" class="qty-inc-dc up_qty"
                                                   id="{{ $item->rowId }}">
                                            <a onclick="var add = parseInt($('.up_qty').val()) + 1; $('.up_qty').val(add);"
                                               data-row_id="{{ $item->rowId }}"
                                               class="incDetail btn btn-default btn-sm"><i class="fa fa-plus"></i>
                                            </a>
                                            @else
                                            <a onclick="var less = parseInt($('#qty').val()) - 1; $('#qty').val(less);"
                                               id="" class="btn btn-default btn-sm"><i
                                                    class="fa fa-minus"></i> </a>
                                            <input type="text" value="1" class="productCartQty qty-inc-dc" id="qty">
                                            <a onclick="var add = parseInt($('#qty').val()) + 1; $('#qty').val(add);"
                                               id="" class="btn btn-default btn-sm"><i
                                                    class="fa fa-plus"></i> </a>
                                            @endif
    
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-action">
                                    <div class="button-group add-to-cart">
                                        <button data-add_class=" btn-add-cart" data-product_id="{{ $product->id }}"
                                                data-regular_price="{{ $product->regular_price }}"
                                                data-sale_price="{{ $product->sale_price }}"
                                                class="addToCart btn-add-cart"
                                                title="add To Cart">Add To Cart
                                        </button>
    
                                    </div>
                                    <div class="button-group">
                                        <?php
                                        echo SM::wishlistHtml($product->id);
                                        ?>
                                        <?php
                                        echo SM::compareHtml($product->id);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tab product -->
                    <div class="product-tab">
                        <ul class="nav-tab">
                            <li class="active">
                                <a aria-expanded="false" data-toggle="tab" href="#product-detail">Product
                                    Details</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#reviews">reviews</a>
                            </li>
                        </ul>
                        <div class="tab-container">
                            <div id="product-detail" class="tab-panel active">
                                {!! $product->long_description !!}
                            </div>
                            @include('frontend.products.product_review')
                        </div>
                    </div>
                    <!-- ./tab product -->
                    <!-- related product -->
                    @include('frontend.products.related_products')
                    <!-- ./related product -->

                </div>
                <!-- Product -->
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
<!-- ./page wapper-->
@endsection