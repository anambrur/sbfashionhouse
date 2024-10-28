@extends('frontend.master')
@section("title", "Compare")
@section("content")

<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Compare</span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title2">Compare Products</span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2 column-style-custom">
                        <div class="name-style image-style-image">
                            Product Image
                        </div>
                        <div class="name-style">Product Name</div>
                        <div class="name-style">Rating</div>
                        <div class="name-style">Price</div>

                        <div class="name-style">Manufacturer</div>
                        <div class="name-style">Availability</div>
                        <div class="name-style">SKU</div>
                        <div class="name-style">Size</div>
                        <div class="name-style">Color</div>
                        <div class="name-style">Description</div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <?php
                            $count = count($compares);
                            if ($count == 1) {
                                $col = 12;
                            } elseif ($count == 2) {
                                $col = 6;
                            } elseif ($count == 3) {
                                $col = 4;
                            } else {
                                $col = 3;
                            }
                            ?>
                            @forelse($compares as $compare)
                            <?php
                            $product = App\Model\Common\Product::where('id', $compare->id)->first();
                            if ($product->product_type == 2) {
                                $att_data = SM::getAttributeByProductId($compare->id);
                                if (!empty($att_data->attribute_image)) {
                                    $attribute_image = $att_data->attribute_image;

                                    $price = $att_data->attribute_price;
                                } else {
                                    $attribute_image = $product->image;

                                    if ($product->sale_price > 0) {
                                        $price = $product->sale_price;
                                    } else {
                                        $price = $product->regular_price;
                                    }
                                }
                            } else {

                                $attribute_image = $product->image;
                                if ($product->sale_price > 0) {
                                    $price = $product->sale_price;
                                } else {
                                    $price = $product->regular_price;
                                }
                            }
                            ?>
                            <div class="col-md-{{ $col }} column-style-custom compareRow">
                                <div class="image-style">
                                    <a href="{{ url('product/'.$product->slug) }}">
                                        <img src="{!! SM::sm_get_the_src( $attribute_image , 388, 473) !!}"
                                             alt="{{ $product->title }}">
                                    </a>
                                </div>
                                <div class="name-style">
                                    <a href="{{ url('product/'.$product->slug) }}">
                                        {{ $product->title }}
                                    </a>
                                </div>
                                <div class="name-style">
                                    <div class="product-star">
                                        <?php
                                        echo SM::product_review($product->id);
                                        ?>
                                    </div>
                                </div>
                                <div class="name-style">{{ $price }}</div>

                                <div class="name-style">{{ $product->brand->title }}</div>
                                <div class="name-style">{{ $product->stock_status }}</div>
                                <div class="name-style">{{ $product->sku }}</div>
                                <div class="name-style">
                                    @if($product->product_type == 2)
                                    @foreach($product->attributeProduct as $key => $attributeProduct)

                                    {{ $attributeProduct->attribute->title  }} (
                                    {{ $attributeProduct->attribute_legnth != "" ? 'Legnth: '.$attributeProduct->attribute_legnth : "" }}
                                    {{ $attributeProduct->attribute_front != "" ? 'Front: '.$attributeProduct->attribute_front : "" }}
                                    {{ $attributeProduct->attribute_back != "" ? 'Back: '.$attributeProduct->attribute_back : "" }}
                                    {{ $attributeProduct->attribute_chest != "" ? 'Chest: '.$attributeProduct->attribute_chest : "" }}
                               
                                      )
                                    @if (!$loop->last),@endif

                                    @endforeach
                                    @endif



                                </div>
                                <div class="name-style">

                                    <?php
                                    $string = '';
                                    if ($product->product_type == 2) {
                                        $att_data = SM::getAttributeByProductId($compare->id);
                                        foreach ($att_data as $key => $value) {
                                            $AttributeTitle = SM::getAttributeTitleById($att_data->color_id);
                                            $attr[] = $AttributeTitle->title;
                                        }
                                        $attribute = array_unique($attr);
                                        foreach ($attribute as $key => $value) {
                                          echo $value . ', ';
                                        }
                                    }
                                    ?>
                                </div>
                              
                                <div class="name-style">{{ $product->short_description }}</div>
                                <div class="name-style add-to-cart">
                                    <?php
                                    $textButton = ' button button-sm';
                                    echo SM::addToCartButton($compare->id, $compare->price, $compare->sale_price, $textButton);

                                    $icon = '<i class="fa fa-heart-o"></i>';
                                    echo SM::wishlistHtml($compare->id, $textButton, $icon);
                                    ?>
                                    {{--<button class="add-cart button button-sm">Add to cart</button>--}}
                                        {{--<button class="button button-sm"><i class="fa fa-heart-o"></i></button>--}}
                                    <a data-product_id="{{ $compare->rowId }}"
                                       class="btn btn-danger removeToCompare"
                                       title="Remove item"
                                       href="javascript:void(0)"><i class="fa fa-close"></i></a>
                                    {{--<button class="button button-sm"><i class="fa fa-close"></i></button>--}}
                                </div>
                            </div>
                            @empty
                            <div class="col-md-3 column-style-custom">
                                <div class="name-style">No data found!</div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .column-style-custom {
        padding: 0;
        margin: 0;
    }

    .image-style-image {
        height: 462px;
        border: 1px solid #ededed;
    }

    .image-style img {
        width: 100%;
        border: 1px solid #ededed;
    }

    .name-style {
        border: 1px solid #ededed;
        padding: 10px;
    }
</style>
<!-- ./page wapper-->
@endsection