@extends('frontend.master')
@section("title", $tagInfo->title)
@section('content')
    @push('style')
        <style>
            #loading {
                text-align: center;
                background: url('loader.gif') no-repeat center;
                height: 150px;
            }
        </style>
    @endpush
    <!-- page wapper-->
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
        @include('frontend.common.breadcrumb')
            <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Left colunm -->
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

                <!-- ./left colunm -->
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-9" id="center_column">
                    <!-- category-slider -->
                    <div class="category-slider">
                        <img src="{{ SM::sm_get_the_src($tagInfo->image, 1017, 336) }}"
                             alt="{{ $tagInfo->title }}">

                    </div>
                    <!-- ./category-slider -->
                    <!-- view-product-list-->
                    <div id="view-product-list" class="view-product-list">
                        <h2 class="page-heading">
                            <span class="">{{ count($tagInfo->products) }} items found in Tag:{{ $tagInfo->title }}</span>
                        </h2>
                        <ul class="display-product-option" style="width: 63px;!important;">
                            <li class="view-as-grid selected">
                                <span>grid</span>
                            </li>
                            <li class="view-as-list">
                                <span>list</span>
                            </li>
                        </ul>
                        <!-- PRODUCT LIST -->
                        <ul class="row product-list grid " id="ajax_view_product_list_tag">
                            @include('frontend.products.product_list_item', ['productLists'=>$products])
                        </ul>
                        <!-- ./PRODUCT LIST -->
                    </div>
                    <!-- ./view-product-list-->

                </div>
                <!-- ./ Center colunm -->
            </div>
            <!-- ./row-->
        </div>
    </div>
    <!-- ./page wapper-->
@endsection