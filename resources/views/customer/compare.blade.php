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
                            <div class="name-style">Description</div>
                            <div class="name-style">Manufacturer</div>
                            <div class="name-style">Availability</div>
                            <div class="name-style">SKU</div>
                            <div class="name-style">Size</div>
                            <div class="name-style">Color</div>
                            <div class="name-style">Weight</div>
                            <div class="name-style">Dimensions</div>
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
                                    <div class="col-md-{{ $col }} column-style-custom">
                                        <div class="image-style">
                                            <img src="{!! SM::sm_get_the_src( $compare->image , 388, 473) !!}" alt="{{ $compare->name }}">
                                        </div>
                                        <div class="name-style">{{ $compare->name }}</div>
                                        <div class="name-style">
                                            <div class="product-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                                <span>(3 Reviews)</span>
                                            </div>
                                        </div>
                                        <div class="name-style">{{ $compare->price }}</div>
                                        <div class="name-style">Description</div>
                                        <div class="name-style">Manufacturer</div>
                                        <div class="name-style">Instock (20 items)</div>
                                        <div class="name-style">#565635634</div>
                                        <div class="name-style">XL</div>
                                        <div class="name-style">Blue</div>
                                        <div class="name-style">1.5kg</div>
                                        <div class="name-style"> 40x20x72cm</div>
                                        <div class="name-style">
                                            <button class="add-cart button button-sm">Add to cart</button>
                                            <button class="button button-sm"><i class="fa fa-heart-o"></i></button>
                                            <a onclick="return confirm('Are you sure you want to remove this item?');"
                                               class="btn btn-danger"
                                               href="{{URL::to('/delete-to-compare/'.$compare->rowId)}}"><i
                                                        class="fa fa-close"></i></i>
                                            </a>
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
            height: 416px;
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