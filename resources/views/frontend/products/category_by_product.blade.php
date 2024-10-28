@extends('frontend.master')
@section("title", $categoryInfo->title)
@section('content')
    <!-- page wapper-->
    <div class="columns-container">
        <div class="container" id="columns">
            <div id="clearfix"></div>
            </br>
            <div class="row">
                @include('frontend.products.product_sidebar')
                <div class="center_column col-xs-12 col-sm-9" id="center_column">
                    <div id="view-product-list" class="view-product-list">
                        <div class="row product-list grid " id="ajax_view_product_list">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection