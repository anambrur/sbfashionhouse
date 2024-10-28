<?php
$product_special_is_enable = SM::smGetThemeOption("product_special_is_enable", 1);
$product_show_category = SM::smGetThemeOption("product_show_category", 1);
$product_show_tag = SM::smGetThemeOption("product_show_tag", 1);
$product_show_brand = SM::smGetThemeOption("product_show_brand", 1);
$product_show_size = SM::smGetThemeOption("product_show_size", 1);
$product_show_color = SM::smGetThemeOption("product_show_color", 1);
$product_sidebar_add = SM::smGetThemeOption("product_sidebar_add", 1);
?>
<style>
    ul.sub-cat {
        margin-left: 20px;
    }
</style>
<div class="column col-xs-12 col-sm-3" id="left_column">
    <!-- block filter -->
    <div class="block left-module product-details-sidebar">
        <p class="title_block">Filter selection</p>
        <div class="block_content">
            <!-- layered -->
            <div class="layered layered-filter-price">
                <!-- filter categgory -->
                @if($product_show_category==1)
                    <?php
                    $getProductCategories = SM::getProductCategories(0);
                    ?>
                    @if(count($getProductCategories)>0)
                        <div class="layered_subtitle">CATEGORIES</div>
                        <div class="layered-content">
                            <ul class="check-box-list">
                                @foreach($getProductCategories as $cat)
                                    <?php
                                    $segment = Request::segment(2);
                                    if ($segment == $cat->slug) {
                                        $selected = 'checked';
                                    } else {
                                        $selected = '';
                                    }

                                    $category_filter[] = $cat->id;
                                    $subcategory_id = \App\Model\Common\Category::where('parent_id', $cat->id)->get();
                                    $countProduct = $cat->total_products;;
                                    foreach ($subcategory_id as $item) {
                                        $category_filter[] = $item->id;
                                        $countProduct += $item->total_products;
                                    }
                                    ?>
                                    <li>
                                        <input name="category" {{$selected}} type="radio" id="c1_{{ $cat->id }}"
                                               value="{{ $cat->id }}"
                                               class="common_selector category" 
                                               style="margin: 0"/>
                                        <label for="c1_{{ $cat->id }}">
                                           <!--<span class="button"></span>-->
                                            {{$cat->title}}<span class="count">( {{ $countProduct }} )</span>
                                        </label>
                                        <?php
                                        echo SM::category_tree_for_select_cat_id($cat->id, $segment);
                                        ?>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            <!-- ./filter categgory -->
                <!-- filter price -->
                <?php
                $max_price = (int)\App\Model\Common\Product::max('regular_price');
                $min_price = (int)\App\Model\Common\Product::min('regular_price');
                ?>

                <div class="layered_subtitle">Price</div>
                <div class="layered-content slider-range">
                    <div data-label-reasult="Range:" data-min="<?php echo $min_price ?>"
                         data-max="<?php echo $max_price ?>"
                         data-unit="{{SM::get_setting_value('currency')}}"
                         class="slider-range-price" data-value-min="<?php echo $min_price ?>"
                         data-value-max="<?php echo $max_price ?>">
                    </div>
                    <input type="hidden" id="hidden_minimum_price" value="<?php echo $min_price ?>"/>
                    <input type="hidden" id="hidden_maximum_price" value="<?php echo $max_price ?>"/>
                    <div class="amount-range-price">Range: {{SM::product_price($min_price)}}
                        {{SM::product_price($max_price)}}
                    </div>

                </div>
                <!-- ./filter price -->
                <!-- filter color -->
                @if($product_show_color==1)
                    <?php
                    $getProductColors = SM::getProductColors(0);
                    ?>
                    @if(count($getProductColors)>0)
                        <div class="layered_subtitle">Color</div>
                        <div class="layered-content filter-color">
                            <ul class="check-box-list">
                                @foreach($getProductColors as $color)
                                    <li>
                                        <input type="checkbox" id="color_{{$color->id}}" value="{{$color->id}}"
                                               class="common_selector color"/>
                                        <label style="" for="color_{{$color->id}}">{{ $color->title }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            <!-- ./filter color -->
                <!-- ./filter brand -->
                @if($product_show_brand==1)
                    <?php
                    $getProductBrands = SM::getProductBrands(0);
                    ?>
                    @if(count($getProductBrands)>0)
                        <div class="layered_subtitle">brand</div>
                        <div class="layered-content filter-brand">
                            <ul class="check-box-list">
                                @foreach($getProductBrands as $brand)
                                    <li>
                                        <input type="checkbox" value="{{ $brand->id }}" id="brand_{{ $brand->id }}"
                                               class="common_selector brand"/>
                                        <label for="brand_{{ $brand->id }}">
                                            <span class="button"></span>
                                            {{ $brand->title }}<span
                                                    class="count">( {{ count($brand->products )}})</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            <!-- ./filter brand -->
                <!-- ./filter size -->
                @if($product_show_size==1)
                    <?php
                    $getProductSizes = SM::getProductSizes(0);
                    ?>
                    @if(count($getProductSizes)>0)
                        <div class="layered_subtitle">Size</div>
                        <div class="layered-content filter-size">
                            <ul class="check-box-list">
                                @foreach($getProductSizes as $size)
                                    <li>
                                        <input type="checkbox" id="size_{{ $size->id }}" value="{{ $size->id }}"
                                               class="common_selector size"/>
                                        <label for="size_{{ $size->id }}">
                                            <span class="button"></span>{{ $size->title }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                @endif
            @endif
            <!-- ./filter size -->
            </div>
            <!-- ./layered -->

        </div>
    </div>
    <!-- ./block filter  -->

    <!-- left silide -->
    <?php
    $product_sidebar_add_link = SM::smGetThemeOption("product_sidebar_add_link", "#");
    $product_sidebar_add = SM::smGetThemeOption("product_sidebar_add");
    ?>
    @empty(!$product_sidebar_add)

        <div class="col-left-slide left-module">
            <a href="{!! $product_sidebar_add_link !!}">
                <img src="{!! SM::sm_get_the_src( $product_sidebar_add, 319,389 ) !!}" alt="slide-left">
            </a>
            <ul style="display: none;" class="owl-carousel owl-style2" data-loop="true" data-nav="false"
                data-margin="30"
                data-autoplayTimeout="1000" data-autoplayHoverPause="true" data-items="1"
                data-autoplay="true">
                <li><a href="#"><img src="{{ asset('frontend/') }}/images/product/pi26.png" alt="slide-left"></a></li>
                <li><a href="#"><img src="{{ asset('frontend/') }}/images/product/pi25.png" alt="slide-left"></a></li>
                <li><a href="#"><img src="{{ asset('frontend/') }}/images/product/pi24.png" alt="slide-left"></a></li>
            </ul>
        </div>
    @endempty
<!--./left silde-->
    <!-- SPECIAL -->
    @if($product_special_is_enable==1)
        <?php
        $product_special_per_page = SM::smGetThemeOption("product_special_per_page", 1);
        $specialProducts = SM::getSpecialProduct($product_special_per_page);
        ?>
        @if(count($specialProducts)>0)
            <div class="block left-module">
                <p class="title_block">SPECIAL PRODUCTS</p>
                <div class="block_content">
                    <ul class="products-block">
                        @foreach($specialProducts as $product)
                            @if($product->product_type==2)
                                <?php
                                $att_data = $product->attributeProduct[0];
                                ?>
                                <li>
                                    <div class="products-block-left">
                                        <a href="{{ url('product/'.$product->slug) }}">
                                            <img src="{!! SM::sm_get_the_src( $att_data->attribute_image , 75, 75) !!}"
                                                 class="image-style"
                                                 alt="{{$product->title}}">
                                        </a>
                                    </div>
                                    <div class="products-block-right">
                                        <p class="product-name">
                                            <a href="{{ url('product/'.$product->slug) }}">{{$product->title}}</a>
                                        </p>
                                        <div class="content_price">
                                            <p class="price product-price"> {{ SM::product_price($att_data->attribute_price) }}</p>
                                        </div>
                                        <p class="product-star">
                                            <?php
                                            echo SM::product_review($product->id);
                                            ?>
                                        </p>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <div class="products-block-left">
                                        <a href="{{ url('product/'.$product->slug) }}">
                                            <img src="{!! SM::sm_get_the_src( $product->image , 75, 75) !!}"
                                                 class="image-style"
                                                 alt="{{$product->title}}">
                                        </a>
                                    </div>
                                    <div class="products-block-right">
                                        <p class="product-name">
                                            <a href="{{ url('product/'.$product->slug) }}">{{$product->title}}</a>
                                        </p>
                                        <div class="content_price">
                                            @if($product->sale_price>0)
                                                <p class="price product-price"> {{ SM::product_price($product->sale_price) }}</p>
                                            @else
                                                <p class="price product-price">{{ SM::product_price($product->regular_price) }}</p>
                                            @endif
                                        </div>
                                        {{--<p class="product-price">{{$product->sale_price}}</p>--}}
                                        <p class="product-star">
                                            <?php
                                            echo SM::product_review($product->id);
                                            ?>
                                        </p>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="products-block">
                        <div class="products-block-bottom">
                            <a class="link-all" href="{{url('/shop')}}">All Products</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
<!-- ./SPECIAL -->
    <!-- TAGS -->
    @if($product_show_tag==1)
        <?php
        $getTags = SM::getTags();
        ?>
        @if(count($getTags)>0)
            <div class="block left-module">
                <p class="title_block">TAGS</p>
                <div class="block_content">
                    <div class="tags">
                        @foreach($getTags as $tag)
                            @if($tag->title == ! '')
                                <a href="{!! url("tag/".$tag->slug) !!}"><span
                                            class="level2">{{$tag->title}}</span></a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endif
<!-- ./TAGS -->
    <!-- Testimonials -->
    <?php
    $testimonialTitle = SM::smGetThemeOption("testimonial_title");
    $testimonials = SM::smGetThemeOption("testimonials");
    // $testimonialsCount = count($testimonials);
    ?>
    {{-- @if($testimonialsCount > 0) --}}
    @if(!empty($testimonialsCount))
        <div class="block left-module">
            <p class="title_block">{{ $testimonialTitle }}</p>
            <div class="block_content">
                <ul class="testimonials owl-carousel" data-loop="true" data-nav="false" data-margin="30"
                    data-autoplayTimeout="1000" data-autoplay="true" data-autoplayHoverPause="true"
                    data-items="1">
                    @foreach($testimonials as $testimonial)
                        <li>
                            <div class="client-mane">
                                {{ $testimonial["title"] }}
                                {{--<p>{{ $testimonial["company_name"] }}</p>--}}
                            </div>
                            <div class="client-avarta">
                                <img src="{!! SM::sm_get_the_src($testimonial["testimonial_image"], 104, 104) !!}"
                                     alt="{{ $testimonial["title"] }}">
                            </div>
                            <div class="testimonial">
                                @empty(!$testimonial["description"])
                                    {{ $testimonial["description"] }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
