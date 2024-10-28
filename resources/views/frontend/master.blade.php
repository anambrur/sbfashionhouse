<!DOCTYPE html>
<html>
@include('frontend.inc.css')

<body class="option5 wrapper" style="">
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    {{-- <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
    window.fbAsyncInit = function() {
        FB.init({
        xfbml            : true,
        version          : 'v3.3'
        });
    };

    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script> --}}

    <!-- Your customer chat code -->
    {{-- <div class="fb-customerchat" attribution=setup_tool page_id="566587163461634"> </div> --}}
    <!-- HEADER -->
    @include('frontend.common.login_modal')
    @include('frontend.inc.header')
    @include('frontend.common.mainnav')
    <!-- end header -->
    {{-- Success & warning Start --}}
    @if (Session::has('w_message'))
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-warning margin-top-20">
                        <i class="fa fa-warning"></i> {{ Session::get('w_message') }}
                    </div>
                </div>
            </div>
        </div>
        <?php
        Session::forget('w_message');
        Session::save();
        ?>
    @endif
    @if (Session::has('s_message'))
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success margin-top-20">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="fa fa-check"></i> {{ Session::get('s_message') }}
                    </div>
                </div>
            </div>
        </div>
        <?php
        Session::forget('s_message');
        Session::save();
        ?>
    @endif
    {{-- Success & warning End --}}
    {{-- content start --}}
    <div class="search-html">
        @yield('content')
    </div>
    {{-- content end --}}
    @include('frontend.inc.footer_top')
    @include('frontend.inc.footer')
    {{-- <div class="loader"></div> --}}
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.wrapper').addClass('loaded');

            }, 750);
        });
    </script>
    @include('frontend.inc.js')
</body>

</html>
