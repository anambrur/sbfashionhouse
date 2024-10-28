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
                <a href="#" title="Return to Home">Fashion</a>
                <span class="navigation-pipe">&nbsp;</span>
                <a href="#" title="Return to Home">Women</a>
                <span class="navigation-pipe">&nbsp;</span>
                <a href="#" title="Return to Home">Dresses</a>
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page">Maecenas consequat mauris</span>
            </div>
            <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Left colunm -->
                <div class="column col-xs-12 col-sm-3" id="left_column">
                    <!-- block category -->
                    <div class="block left-module">
                        <p class="title_block">CATEGORIES</p>
                        <div class="block_content">
                            <!-- layered -->
                            <div class="layered layered-category">
                                <div class="layered-content">
                                    <ul class="tree-menu">
                                        <li class="active">
                                            <span></span><a href="#">Tops</a>
                                            <ul>
                                                <li><span></span><a href="#">T-shirts</a></li>
                                                <li><span></span><a href="#">Dresses</a></li>
                                                <li><span></span><a href="#">Casual</a></li>
                                                <li><span></span><a href="#">Evening</a></li>
                                                <li><span></span><a href="#">Summer</a></li>
                                                <li><span></span><a href="#">Bags & Shoes</a></li>
                                                <li><span></span><a href="#"><span></span>Blouses</a></li>
                                            </ul>
                                        </li>
                                        <li><span></span><a href="#">T-shirts</a></li>
                                        <li><span></span><a href="#">Dresses</a></li>
                                        <li><span></span><a href="#">Jackets and coats </a></li>
                                        <li><span></span><a href="#">Knitted</a></li>
                                        <li><span></span><a href="#">Pants</a></li>
                                        <li><span></span><a href="#">Bags & Shoes</a></li>
                                        <li><span></span><a href="#">Best selling</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- ./layered -->
                        </div>
                    </div>
                    <!-- ./block category  -->
                    <!-- block best sellers -->
                    <div class="block left-module">
                        <p class="title_block">BEST SELLERS</p>
                        <div class="block_content">
                            <div class="owl-carousel owl-best-sell" data-loop="true" data-nav="false" data-margin="0"
                                 data-autoplayTimeout="1000" data-autoplay="true" data-autoplayHoverPause="true"
                                 data-items="1">
                                <ul class="products-block best-sell">
                                    <li>
                                        <div class="products-block-left">
                                            <a href="#">
                                                <img src="{{ asset('frontend/') }}/images/product/pi17.png"
                                                     alt="SPECIAL PRODUCTS">
                                            </a>
                                        </div>
                                        <div class="products-block-right">
                                            <p class="product-name">
                                                <a href="#">Woman Within Plus Size Flared</a>
                                            </p>
                                            <p class="product-price">$38,95</p>
                                            <p class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="products-block-left">
                                            <a href="#">
                                                <img src="{{ asset('frontend/') }}/images/product/pi16.png"
                                                     alt="SPECIAL PRODUCTS">
                                            </a>
                                        </div>
                                        <div class="products-block-right">
                                            <p class="product-name">
                                                <a href="#">Woman Within Plus Size Flared</a>
                                            </p>
                                            <p class="product-price">$38,95</p>
                                            <p class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="products-block-left">
                                            <a href="#">
                                                <img src="{{ asset('frontend/') }}/images/product/pi15.png"
                                                     alt="SPECIAL PRODUCTS">
                                            </a>
                                        </div>
                                        <div class="products-block-right">
                                            <p class="product-name">
                                                <a href="#">Plus Size Rock Star Skirt</a>
                                            </p>
                                            <p class="product-price">$38,95</p>
                                            <p class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="products-block best-sell">
                                    <li>
                                        <div class="products-block-left">
                                            <a href="#">
                                                <img src="{{ asset('frontend/') }}/images/product/pi14.png"
                                                     alt="SPECIAL PRODUCTS">
                                            </a>
                                        </div>
                                        <div class="products-block-right">
                                            <p class="product-name">
                                                <a href="#">Woman Within Plus Size Flared</a>
                                            </p>
                                            <p class="product-price">$38,95</p>
                                            <p class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="products-block-left">
                                            <a href="#">
                                                <img src="{{ asset('frontend/') }}/images/product/pi13.png"
                                                     alt="SPECIAL PRODUCTS">
                                            </a>
                                        </div>
                                        <div class="products-block-right">
                                            <p class="product-name">
                                                <a href="#">Woman Within Plus Size Flared</a>
                                            </p>
                                            <p class="product-price">$38,95</p>
                                            <p class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="products-block-left">
                                            <a href="#">
                                                <img src="{{ asset('frontend/') }}/images/product/pi12.png"
                                                     alt="SPECIAL PRODUCTS">
                                            </a>
                                        </div>
                                        <div class="products-block-right">
                                            <p class="product-name">
                                                <a href="#">Plus Size Rock Star Skirt</a>
                                            </p>
                                            <p class="product-price">$38,95</p>
                                            <p class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- ./block best sellers  -->

                    <!-- left silide -->
                    <div class="col-left-slide left-module">
                        <ul class="owl-carousel owl-style2" data-loop="true" data-nav="false" data-margin="0"
                            data-autoplayTimeout="1000" data-autoplayHoverPause="true" data-items="1"
                            data-autoplay="true">
                            <li><a href="#"><img src="{{ asset('frontend/') }}/images/product/pi23.png"
                                                 class="image-style" alt="slide-left"></a></li>
                            <li><a href="#"><img src="{{ asset('frontend/') }}/images/product/pi20.png"
                                                 class="image-style" alt="slide-left"></a></li>
                            <li><a href="#"><img src="{{ asset('frontend/') }}/images/product/pi21.png"
                                                 class="image-style" alt="slide-left"></a></li>
                        </ul>
                    </div>
                    <!--./left silde-->
                    <!-- block best sellers -->
                    <div class="block left-module">
                        <p class="title_block">ON SALE</p>
                        <div class="block_content product-onsale">
                            <ul class="product-list owl-carousel" data-loop="true" data-nav="false" data-margin="0"
                                data-autoplayTimeout="1000" data-autoplayHoverPause="true" data-items="1"
                                data-autoplay="true">
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi25.png"/>
                                            </a>
                                            <div class="price-percent-reduction2">-30% OFF</div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                        <div class="product-bottom">
                                            <a class="btn-add-cart" title="Add to Cart" href="#add">Add to Cart</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi1.png"/>
                                            </a>
                                            <div class="price-percent-reduction2">-10% OFF</div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                        <div class="product-bottom">
                                            <a class="btn-add-cart" title="Add to Cart" href="#add">Add to Cart</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi2.png"/>
                                            </a>
                                            <div class="price-percent-reduction2">-42% OFF</div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                        <div class="product-bottom">
                                            <a class="btn-add-cart" title="Add to Cart" href="#add">Add to Cart</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- ./block best sellers  -->
                    <!-- left silide -->
                    <div class="col-left-slide left-module">
                        <div class="banner-opacity">
                            <a href="#"><img src="{{ asset('frontend/') }}/images/add.jpg" alt="ads-banner"
                                             class="image-style"></a>
                        </div>
                    </div>
                    <!--./left silde-->
                </div>
                <!-- ./left colunm -->
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-9" id="center_column">
                    <!-- Product -->
                    <div id="product">
                        <div class="primary-box row">
                            <div class="pb-left-column col-xs-12 col-sm-6">
                                <!-- product-imge-->
                                <div class="product-image">
                                    <div class="product-full">
                                        <img id="product-zoom" src='{{ asset('frontend/') }}/images/product/pi11.png'
                                             data-zoom-image="{{ asset('frontend/') }}/images/zoom1.png"
                                             class="image-style">
                                    </div>
                                    <div class="product-img-thumb" id="gallery_01">
                                        <ul class="owl-carousel" data-items="3" data-nav="true" data-dots="false"
                                            data-margin="20" data-loop="true">
                                            <li>
                                                <a href="#"
                                                   data-image="{{ asset('frontend/') }}/images/product/pi12.png"
                                                   data-zoom-image="{{ asset('frontend/') }}/images/zoom2.png">
                                                    <img id="product-zoom"
                                                         src="{{ asset('frontend/') }}/images/product/pi12.png"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   data-image="{{ asset('frontend/') }}/images/product/pi13.png"
                                                   data-zoom-image="{{ asset('frontend/') }}/images/zoom3.png">
                                                    <img id="product-zoom"
                                                         src="{{ asset('frontend/') }}/images/product/pi13.png"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   data-image="{{ asset('frontend/') }}/images/product/pi14.png"
                                                   data-zoom-image="{{ asset('frontend/') }}/images/zoom4.png">
                                                    <img id="product-zoom"
                                                         src="{{ asset('frontend/') }}/images/product/pi14.png"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   data-image="{{ asset('frontend/') }}/images/product/pi15.png"
                                                   data-zoom-image="{{ asset('frontend/') }}/images/zoom5.png">
                                                    <img id="product-zoom"
                                                         src="{{ asset('frontend/') }}/images/product/pi15.png"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   data-image="{{ asset('frontend/') }}/images/product/pi16.png"
                                                   data-zoom-image="{{ asset('frontend/') }}/images/zoom1.png">
                                                    <img id="product-zoom"
                                                         src="{{ asset('frontend/') }}/images/product/pi16.png"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   data-image="{{ asset('frontend/') }}/images/product/pi17.png"
                                                   data-zoom-image="{{ asset('frontend/') }}/images/zoom2.png">
                                                    <img id="product-zoom"
                                                         src="{{ asset('frontend/') }}/images/product/pi17.png"/>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- product-imge-->
                            </div>
                            <form action="{{url('/add-to-cart')}}" method="post">
                                {{ csrf_field() }}
                                <?php
                                $min = 7;
                                $max = 14;
                                $product_id = rand($min, $max);
                                //                                    $product_id = rand();
                                $user_id = Auth::id();
                                ?>
                                <input name="qty" type="hidden" value="1"/>
                                <input type="hidden" name="id" value="{{ $product_id }}">

                                <div class="pb-right-column col-xs-12 col-sm-6">
                                    <h1 class="product-name">Maecenas consequat mauris</h1>
                                    <div class="product-comments">
                                        <div class="product-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </div>
                                        <div class="comments-advices">
                                            <a href="#">Based on 3 ratings</a>
                                            <a href="#"><i class="fa fa-pencil"></i> write a review</a>
                                        </div>
                                    </div>
                                    <div class="product-price-group">
                                        <span class="price">$38.95</span>
                                        <span class="old-price">$52.00</span>
                                        <span class="discount">-30%</span>
                                    </div>
                                    <div class="info-orther">
                                        <p>Item Code: #453217907</p>
                                        <p>Availability: <span class="in-stock">In stock</span></p>
                                        <p>Condition: New</p>
                                    </div>
                                    <div class="product-desc">
                                        Vestibulum eu odio. Suspendisse potenti. Morbi mollis tellus ac sapien. Praesent
                                        egestas tristique nibh. Nullam dictum felis eu pede mollis pretium.Fusce egestas
                                        elit eget lorem.
                                    </div>
                                    <div class="form-option">
                                        <p class="form-option-title">Available Options:</p>
                                        <div class="attributes">
                                            <div class="attribute-label">Color:</div>
                                            <div class="attribute-list">
                                                <ul class="list-color">
                                                    <li style="background:#0c3b90;"><a href="#">red</a></li>
                                                    <li style="background:#036c5d;" class="active"><a href="#">red</a>
                                                    </li>
                                                    <li style="background:#5f2363;"><a href="#">red</a></li>
                                                    <li style="background:#ffc000;"><a href="#">red</a></li>
                                                    <li style="background:#36a93c;"><a href="#">red</a></li>
                                                    <li style="background:#ff0000;"><a href="#">red</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="attributes">
                                            <div class="attribute-label">Qty:</div>
                                            <div class="attribute-list product-qty">
                                                <div class="qty">
                                                    <input id="option-product-qty" type="text" value="1">
                                                </div>
                                                <div class="btn-plus">
                                                    <a href="#" class="btn-plus-up">
                                                        <i class="fa fa-caret-up"></i>
                                                    </a>
                                                    <a href="#" class="btn-plus-down">
                                                        <i class="fa fa-caret-down"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="attributes">
                                            <div class="attribute-label">Size:</div>
                                            <div class="attribute-list">
                                                <select>
                                                    <option value="1">X</option>
                                                    <option value="2">XL</option>
                                                    <option value="3">XXL</option>
                                                </select>
                                                <a id="size_chart" class="fancybox"
                                                   href="{{ asset('frontend/') }}/data/size-chart.jpg">Size Chart</a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-action">
                                        <div class="button-group">
                                            <button type="submit" class="btn-add-cart">
                                                Add to cart
                                            </button>
                                            {{--<a class="btn-add-cart" href="{{ url('/add-to-cart') }}/{{$product_id}}">Add--}}
                                            {{--to cart</a>--}}
                                        </div>

                                        <div class="button-group">
                                            <a class="wishlist"
                                               href="{{ url('/addWishlist') }}/{{$product_id}}/{{$user_id}}"><i
                                                        class="fa fa-heart-o"></i>
                                                <br>Wishlist</a>
                                            <a class="compare" href="{{ url('/add-to-compare') }}/{{$product_id}}"><i
                                                        class="fa fa-signal"></i>
                                                <br>
                                                Compare</a>
                                        </div>
                                    </div>
                                    <div class="form-share">
                                        <div class="sendtofriend-print">
                                            <a href="javascript:print();"><i class="fa fa-print"></i> Print</a>
                                            <a href="#"><i class="fa fa-envelope-o fa-fw"></i>Send to a friend</a>
                                        </div>
                                        <div class="network-share">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- tab product -->
                        <div class="product-tab">
                            <ul class="nav-tab">
                                <li class="active">
                                    <a aria-expanded="false" data-toggle="tab" href="#product-detail">Product
                                        Details</a>
                                </li>
                                <li>
                                    <a aria-expanded="true" data-toggle="tab" href="#information">information</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#reviews">reviews</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#extra-tabs">Extra Tabs</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#guarantees">guarantees</a>
                                </li>
                            </ul>
                            <div class="tab-container">
                                <div id="product-detail" class="tab-panel active">
                                    <p>Morbi mollis tellus ac sapien. Nunc nec neque. Praesent nec nisl a purus blandit
                                        viverra. Nunc nec neque. Pellentesque auctor neque nec urna.</p>

                                    <p>Curabitur suscipit suscipit tellus. Cras id dui. Nam ipsum risus, rutrum vitae,
                                        vestibulum eu, molestie vel, lacus. Class aptent taciti sociosqu ad litora
                                        torquent per conubia nostra, per inceptos hymenaeos. Maecenas vestibulum mollis
                                        diam.</p>

                                    <p>Vestibulum facilisis, purus nec pulvinar iaculis, ligula mi congue nunc, vitae
                                        euismod ligula urna in dolor. Sed lectus. Phasellus leo dolor, tempus non,
                                        auctor et, hendrerit quis, nisi. Nam at tortor in tellus interdum sagittis.
                                        Pellentesque egestas, neque sit amet convallis pulvinar, justo nulla eleifend
                                        augue, ac auctor orci leo non est.</p>
                                </div>
                                <div id="information" class="tab-panel">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="200">Compositions</td>
                                            <td>Cotton</td>
                                        </tr>
                                        <tr>
                                            <td>Styles</td>
                                            <td>Girly</td>
                                        </tr>
                                        <tr>
                                            <td>Properties</td>
                                            <td>Colorful Dress</td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="reviews" class="tab-panel">
                                    <div class="product-comments-block-tab">
                                        <div class="comment row">
                                            <div class="col-sm-3 author">
                                                <div class="grade">
                                                    <span>Grade</span>
                                                    <span class="reviewRating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </div>
                                                <div class="info-author">
                                                    <span><strong>Jame</strong></span>
                                                    <em>04/08/2015</em>
                                                </div>
                                            </div>
                                            <div class="col-sm-9 commnet-dettail">
                                                Phasellus accumsan cursus velit. Pellentesque egestas, neque sit amet
                                                convallis pulvinar
                                            </div>
                                        </div>
                                        <div class="comment row">
                                            <div class="col-sm-3 author">
                                                <div class="grade">
                                                    <span>Grade</span>
                                                    <span class="reviewRating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </div>
                                                <div class="info-author">
                                                    <span><strong>Author</strong></span>
                                                    <em>04/08/2015</em>
                                                </div>
                                            </div>
                                            <div class="col-sm-9 commnet-dettail">
                                                Phasellus accumsan cursus velit. Pellentesque egestas, neque sit amet
                                                convallis pulvinar
                                            </div>
                                        </div>
                                        <p>
                                            <a class="btn-comment" href="#">Write your review !</a>
                                        </p>
                                    </div>

                                </div>
                                <div id="extra-tabs" class="tab-panel">
                                    <p>Phasellus accumsan cursus velit. Pellentesque egestas, neque sit amet convallis
                                        pulvinar, justo nulla eleifend augue, ac auctor orci leo non est. Sed lectus.
                                        Sed a libero. Vestibulum eu odio.</p>

                                    <p>Maecenas vestibulum mollis diam. In consectetuer turpis ut velit. Curabitur at
                                        lacus ac velit ornare lobortis. Praesent ac sem eget est egestas volutpat. Nam
                                        eget dui.</p>

                                    <p>Maecenas nec odio et ante tincidunt tempus. Vestibulum suscipit nulla quis orci.
                                        Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Aenean ut eros
                                        et nisl sagittis vestibulum. Aliquam eu nunc.</p>
                                </div>
                                <div id="guarantees" class="tab-panel">
                                    <p>Phasellus accumsan cursus velit. Pellentesque egestas, neque sit amet convallis
                                        pulvinar, justo nulla eleifend augue, ac auctor orci leo non est. Sed lectus.
                                        Sed a libero. Vestibulum eu odio.</p>

                                    <p>Maecenas vestibulum mollis diam. In consectetuer turpis ut velit. Curabitur at
                                        lacus ac velit ornare lobortis. Praesent ac sem eget est egestas volutpat. Nam
                                        eget dui.</p>

                                    <p>Maecenas nec odio et ante tincidunt tempus. Vestibulum suscipit nulla quis orci.
                                        Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Aenean ut eros
                                        et nisl sagittis vestibulum. Aliquam eu nunc.</p>
                                    <p>Maecenas vestibulum mollis diam. In consectetuer turpis ut velit. Curabitur at
                                        lacus ac velit ornare lobortis. Praesent ac sem eget est egestas volutpat. Nam
                                        eget dui.</p>
                                </div>
                            </div>
                        </div>
                        <!-- ./tab product -->
                        <!-- box product -->
                        <div class="page-product-box">
                            <h3 class="heading">Related Products</h3>
                            <ul class="product-list owl-carousel" data-dots="false" data-loop="true" data-nav="true"
                                data-margin="30" data-autoplayTimeout="1000" data-autoplayHoverPause="true"
                                data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":3}}'>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi12.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi22.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi21.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi20.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- ./box product -->
                        <!-- box product -->
                        <div class="page-product-box">
                            <h3 class="heading">You might also like</h3>
                            <ul class="product-list owl-carousel" data-dots="false" data-loop="true" data-nav="true"
                                data-margin="30" data-autoplayTimeout="1000" data-autoplayHoverPause="true"
                                data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":3}}'>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi24.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi18.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi17.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="product-container">
                                        <div class="left-block">
                                            <a href="#">
                                                <img class="img-responsive" alt="product"
                                                     src="{{ asset('frontend/') }}/images/product/pi16.png"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                                <a title="Add to compare" class="compare" href="#"></a>
                                                <a title="Quick view" class="search" href="#"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="#add">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name"><a href="#">Maecenas consequat mauris</a></h5>
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                            </div>
                                            <div class="content_price">
                                                <span class="price product-price">$38,95</span>
                                                <span class="price old-price">$52,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- ./box product -->
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