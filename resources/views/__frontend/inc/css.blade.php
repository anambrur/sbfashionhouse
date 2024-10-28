<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{csrf_token()}}"/>

    <?php
    $site_name = SM::sm_get_site_name();
    $site_name = SM::sm_string($site_name) ? $site_name : 'Next Page Technology Ltd.';

    $seo_title = stripslashes(
        (
            isset($seo_title)
            && SM::sm_string($seo_title)
        )
            ? $seo_title
            : SM::get_setting_value('seo_title')
    );
    $meta_key = stripslashes(
        (
            isset($meta_key)
            && SM::sm_string($meta_key)
        )
            ? $meta_key
            : SM::get_setting_value('site_meta_keywords')
    );
    $meta_description = stripslashes(
        (
            isset($meta_description)
            && SM::sm_string($meta_description)
        )
            ? $meta_description
            : SM::get_setting_value('site_meta_description')
    );
    $image = (isset($image)
        && SM::sm_string($image)) ? $image
        : asset(SM::sm_get_the_src(SM::get_setting_value('site_screenshot')));


    ?><title>SB Fashion House</title>

    <meta name="keywords" content="{!!$meta_key!!}">
    <meta name="description" content="{!! $meta_description !!}"/>

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{$seo_title}}">
    <meta itemprop="description" content="{!! $meta_description !!}">
    <meta itemprop="image" content="{!!$image!!}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{$site_name}}">
    <meta name="twitter:title" content="{{ $seo_title }}">
    <meta name="twitter:description" content="{!! $meta_description !!}">
    <meta name="twitter:image:src" content="{!!$image!!}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $seo_title }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{!!$image!!}"/>
    <meta property="og:description" content="{!! $meta_description !!}"/>
    <meta property="og:site_name" content="{{$site_name}}"/>
         <meta property="og:url" content="https://emall.kz-international.com/shop"/>
    <meta property="fb:app_id" content="351088762075946"/>
    <link rel="icon" href="<?php echo SM::sm_get_the_src(SM::sm_get_site_favicon(), 30, 30); ?>" type="image/x-icon">
    {{-------------------meta section end--------------}}
    {{--    {!!Html::style('frontend/lib/bootstrap/css/bootstrap.min.css')!!}--}}
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/lib/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/lib/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css"/>
    <link rel="stylesheet" type="text/css" href="https://ecommerce.durbiin.org/frontend/assets/icofont/icofont.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/lib/select2/css/select2.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/lib/jquery.bxslider/jquery.bxslider.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/lib/owl.carousel/owl.carousel.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/lib/jquery-ui/jquery-ui.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/reset.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/style.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/responsive.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/option5.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/custom.css')}}"/>
    {{--dashboard--}}
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/dashboard/dashboard.css')}}"/>
    {{--toastr--}}
    <link rel="stylesheet" href="{{asset('frontend/toastr/toastr.min.css')}}">
    <?php
    SM::smGetSystemFrontEndCss([
        "responsive",
    ]);
    SM::smGetSystemFrontEndJs([
        "jquery-3.2.1.min",
        "state"
    ]);
    ?>


    @stack('style')
    <style>
        #main-menu .dropdown-menu.container-fluid {
            padding: 15px 17px;
        }

        .dropdown-menu > li > a {
            display: block;
            /*padding: 5px 2px;*/
            clear: both;
            font-weight: 400;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
        }


        #loading {
            background: url(../frontend/images/loader/loader.gif) no-repeat;
            /*background: url(../images/loader.gif) no-repeat;*/
            width: 80px;
            height: 80px;
            background-size: 80px 80px;
            left: 46%;
            top: 46%;
            z-index: 9999;
            position: fixed;

        }
        .error-notice {
            font-size: 13px;
            color: #ff0000;
            margin-top: 10px;
            display: block;
            font-style: italic;
            padding-left: 20px;
            line-height: 1.2;
        }

        .success-notice {
            font-size: 13px;
            color: #008000;
            margin-top: 10px;
            display: block;
            font-style: italic;
            padding-left: 20px;
            line-height: 1.2;
        }

        /*-----------*/
        /*--------- login socail ------*/
        .login-socail-form {
            margin: 42px 0 0px;
        }

        .login-socail-form .or {
            display: block;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            text-align: center;
            margin: auto;
            background: #5165a3;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 18px;
            padding: 14px 0;
            margin-bottom: 30px;
        }

        .login-socail-form ul {
            padding: 0;
            text-align: center;
        }

        .login-socail-form ul li {
            display: inline-block;
            list-style: none;
            border-radius: 25px;
            text-align: left;
            background: #000;
            margin: 0 6px;
            transition: all ease 500ms;
            position: relative;
        }

        .login-socail-form ul li a {
            color: #FFFFFF;
            font-size: 14px;
            font-weight: 600;
            text-align: left;
            transition: all ease 500ms;
            display: block;
        }

        .login-socail-form ul li span {
            transform: scale(0);
            opacity: 0;
            transition: all ease 500ms;
            position: absolute;
            font-size: 14px;
            font-weight: 600;
            z-index: 1;
            right: 12px;
            top: 11px;
        }

        .login-socail-form ul li:hover span {
            transform: scale(1);
            color: #FFFFFF;
            opacity: 1;
        }

        .login-socail-form ul li.face {
            background: #3b5998;
        }


        .login-socail-form ul li.goo {
            background: #DD5044;
        }


        .login-socail-form ul li.twi {
            background: #1DA1F2;
            padding: 10px 12px;
        }


        .login-socail-form ul li.lin {
            background: #0077b5;
            padding: 10px 12px;
        }
.terms-privacy-policy h2 {
    padding: 30px 30px 20px 0px;
    font-weight: 700;
}
section.terms-privacy-policy p {
    padding: 10px;
}
section.terms-privacy-policy ul li {
    padding: 5px;
    list-style: disc;
    padding-left: 5px;
    margin-left: 30px;
}
section.terms-privacy-policyh3 {
    font-weight: 600;
}
#footer i.fa.fa-youtube-play {
    background: #ff0000;
}
i.fa.fa-home {
    margin-top: 3px;
}

.modal-header .close {
    margin-top: -18px;
}
    </style>
    <?php $method = strtolower(SM::current_method()); ?>
    <script type="text/javascript">
        var url = '<?php echo url('') . '/'; ?>';
        var method = '<?php echo $method; ?>';
    </script>
    <![endif]-->
    {!! SM::smGetThemeOption( "google_analytic_code"); !!}
</head>