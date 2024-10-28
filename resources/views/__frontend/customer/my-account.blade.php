@extends('frontend.master')
@section('title', '')
@section('content')
    <!-- page wapper-->
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
            <div class="breadcrumb clearfix">
                <a class="home" href="#" title="Return to Home">Home</a>
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page">My account</span>
            </div>
            <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Left colunm -->
                <div class="column col-xs-12 col-sm-3" id="left_column">
                    <!-- Blog category -->
                    <div class="block left-module">
                        <p class="title_block">My account</p>
                        <div class="block_content">
                            <!-- layered -->
                            <div class="layered layered-category">
                                <div class="layered-content">
                                    <ul class="tree-menu">
                                        <li><span></span><a href="#">Dashboard</a></li>
                                        <li><span></span><a href="#">Orders</a></li>
                                        <li><span></span><a href="#">Downloads</a></li>
                                        <li><span></span><a href="#">Addresses</a></li>
                                        <li><span></span><a href="#">Account details</a></li>
                                        <li><span></span><a href="#">Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- ./layered -->
                        </div>
                    </div>
                    <!-- ./blog category  -->
                </div>
                <!-- ./left colunm -->
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-9" id="center_column">
                    <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper"></div>
                        <p>Hello <strong>{{ Auth::user()->firstname }}</strong> (not <strong>{{ Auth::user()->firstname }}</strong>? <a
                                    href="{{ url('/logout') }}">Log
                                out</a>)</p>
                        <p>From your account dashboard you can view your <a
                                    href="https://kuteshop.kute-themes.net/my-account/orders/">recent orders</a>, manage
                            your <a href="https://kuteshop.kute-themes.net/my-account/edit-address/">shipping and
                                billing addresses</a>, and <a
                                    href="https://kuteshop.kute-themes.net/my-account/edit-account/">edit your password
                                and account details</a>.</p></div>

                </div>
                <!-- ./ Center colunm -->
            </div>
            <!-- ./row-->
        </div>
    </div>
    <!-- ./page wapper-->
@endsection