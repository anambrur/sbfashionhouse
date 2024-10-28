<input type="hidden" name="_token" id="table_csrf_token" value="{!! csrf_token() !!}">
<section>
    <div class="top-header">

        <?php
        $mobile = SM::get_setting_value('mobile');
        $email = SM::get_setting_value('email');
        $address = SM::get_setting_value('address');
        $country = SM::get_setting_value('country');
        if (Auth::check()) {
            $blogAuthor = Auth::user();
            $fname = $blogAuthor->firstname . ' ' . $blogAuthor->lastname;
            $fname = trim($fname) != '' ? $fname : $blogAuthor->username;
        } else {
            $fname = 'My Account';
            $logonMoadal = 'data-toggle="modal" data-target="#loginModal"';
        }
        ?>
        <div class="bg-opacity">
            <div class="container">
                <div class="top-bar-social top-hotline">
                    <a href="tel:{{ $mobile }}"><img style="height: 25px;" src="/storage/uploads/support.png">
                        {{ $mobile }} </a>
                </div>
                <div class="top-bar-social">
                    @empty(!SM::smGetThemeOption('social_facebook'))
                        <a target="_blank" href="{{ SM::smGetThemeOption('social_facebook') }}">
                            <img style="height: 25px;" src="/storage/uploads/icon-for-zenvo_web-01.png">
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_twitter'))
                        <a href="{{ SM::smGetThemeOption('social_twitter') }}">
                            <i class="fa fa-twitter"></i>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_google_plus'))
                        <a target="_blank" href="{{ SM::smGetThemeOption('social_google_plus') }}">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_linkedin'))
                        <a target="_blank" href="{{ SM::smGetThemeOption('social_linkedin') }}">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_github'))
                        <a href="{{ SM::smGetThemeOption('social_github') }}">
                            <i class="fa fa-github"></i>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_pinterest'))
                        <a href="{{ SM::smGetThemeOption('social_pinterest') }}">
                            <i class="fa fa-pinterest-p"> </i>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_youtube'))
                        <a target="_blank" href="{{ SM::smGetThemeOption('social_youtube') }}">
                            <img style="height: 25px;" src="/storage/uploads/icon-for-zenvo_web-02.png">
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption('social_instagram'))
                        <a target="_blank" href="{{ SM::smGetThemeOption('social_instagram') }}">
                            <img style="height: 25px;" src="/storage/uploads/icon-for-zenvo_web-03.png">
                        </a>
                    @endempty
                </div>
                <div class="support-link">
                    <a href="{{ url('/about') }}">About Us</a>
                    <a href="{{ url('/contact') }}">Contact Us</a>
                </div>

                <div id="user-info-top" class="user-info pull-right">
                    <div class="dropdown ">
                        <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            href="{{ '/dashboard' }}"><span>{{ $fname }}</span></a>
                        <ul class="dropdown-menu mega_dropdown" role="menu">
                            @if (Auth::check())
                                <li><a href="{{ '/dashboard' }}">Profile</a></li>
                                <li><a href="{{ url('/dashboard/wishlist') }}">Wishlists</a></li>
                                <li><a href="{{ '/logout' }}">Logout</a></li>
                            @else
                                <li class="my-accounts"><a href="#" data-toggle="modal"
                                        data-target="#loginModal">Login</a></li>
                                <li class="my-accounts"><a href="#" data-toggle="modal"
                                        data-target="#loginModal">Register</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="header">
    <div class="bg-opacity">
        <div class="container">
            <div id="header" class="header">

            </div>
            <!--/.top-header -->
            <!-- MAIN HEADER -->
            <div class=" main-header">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-xs-6 col-sm-6 col-12 logo">
                        <a href="{{ url('/') }}">
                            <img class="logo-brand" alt="{{ SM::get_setting_value('site_name') }}"
                            src="{{ SM::sm_get_the_src(SM::sm_get_site_logo()) }}" />
                        </a>
                    </div>
                    <div class="col-lg-5 col-md-5 col-xs-4 col-sm-6 col-12 header-search-box">
                        <div class="input-group category-search" id="main_search">
                            <input type="hidden" name="search_param" value="all" id="search_param">         
                            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search All Products..">
                            <span class="input-group-btn">
                                <button class="btn btn-default custom-btn" type="button"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 phone-call_cart">
                        <div class="shopping-cart-wrapper">
                            <!--<div class="Phone_call">-->
                            <!--    <a href="tel:{{ $mobile }}" >-->
                            <!--        <i class="fa fa-phone-square" aria-hidden="true"></i> {{ $mobile }}-->
                            <!--    </a>-->
                            <!--</div>-->
                            <div class="group-button-header">
                                <div class="btn-cart header_cart_html" id="cart-block">
                                    <a href="{{ url('/cart') }}" style="display: flex;">
                                        <div class="card_view">
                                            {{-- <a title="My cart" href="{{ url('/cart') }}">Cart</a> --}}
                                            {{-- <span class="notify notify-right cart_count">{{ Cart::instance('cart')->count() }}</span> --}}
                                            <img src="{{url('frontend/images/favorite-cart.gif')}}" alt="">
                                        </div>
                                        <div class="shoping_cart_text">
                                            <p>Shopping Cart</p>
                                            <span>{{ Cart::instance('cart')->count() }} items</span>
                                                <span>- ৳ {{Cart::total()}}</span>
                                        </div>
                                    </a>
                                    <div class="cart-block">
                                        <div class="cart-block-content">
                                            <h5 class="cart-title cart_count">{{ Cart::instance('cart')->count() }} Items in
                                                my cart</h5>
                                            <div class="cart-block-list">
                                                <ul>
                                                    <?php
                                                    $items = Cart::instance('cart')->content();
                                                    ?>
                                                    @forelse($items as $id => $item)
                                                        <li class="product-info removeCartTrLi">
                                                            <div class="p-left">
                                                                <a data-product_id="{{ $item->rowId }}"
                                                                    class="remove_link removeToCart" title="Remove item"
                                                                    href="javascript:void(0)"></a>
                                                                <a href="{{ url('product/' . $item->options->slug) }}">
                                                                    <img class="img-responsive"
                                                                        src="{{ SM::sm_get_the_src($item->options->image, 100, 100) }}"
                                                                        alt="{{ $item->name }}">
                                                                </a>
                                                            </div>
                                                            <div class="p-right">
                                                                <p class="p-name">{{ $item->name }}</p>
                                                                <p class="p-rice">{{ SM::currency_price_value($item->price) }}
                                                                </p>
                                                                <p>Qty: {{ $item->qty }}</p>
                                                                @if ($item->options->sizename != '')
                                                                    <p>Size: {{ $item->options->sizename }}</p>
                                                                @endif
                                                                @if ($item->options->colorname != '')
                                                                    <p>Color: {{ $item->options->colorname }}</p>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <p>No data found!</p>
                                                    @endforelse
                                                </ul>
                                            </div>
                                            <div class="toal-cart">
                                                <span>Total</span>
                                                <span class="toal-price pull-right">
                                                    {{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}
                                                </span>
                                            </div>
                                            <div class="cart-buttons">
                                                <a href="{{ url('/cart') }}" class="btn-check-out">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MANIN HEADER -->
    </div>
    </div>
</section>
