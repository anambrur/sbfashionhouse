<!DOCTYPE html>
<html lang="en-us" id="extr-page">
<head>
    <meta charset="utf-8">
    <title> <?php echo SM::get_setting_value( 'site_name' ); ?> - @yield('title')</title>
    <meta name="description" content="">
    <meta name="author" content="Next Page Technology Ltd. <info@nextpagetl.com>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/font-awesome.min.css')}}">

    <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
    <link rel="stylesheet" type="text/css" media="screen"
          href="{{asset('nptl-admin/css/smartadmin-production.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/smartadmin-skins.min.css')}}">

<!-- SmartAdmin RTL Support is under construction
          This RTL CSS will be released in version 1.5
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/smartadmin-rtl.min.css')}}"> -->

<!-- We recommend you use "your_style.css" to override SmartAdmin
           specific styles this will also ensure you retrain your customization with each SmartAdmin update.
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/your_style.css')}}"> -->

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/demo.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('nptl-admin/css/admin.css')}}">

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="<?php echo SM::sm_get_the_src( SM::sm_get_site_favicon(), 30, 30 ); ?>"
          type="image/x-icon">
    <link rel="icon" href="<?php echo SM::sm_get_the_src( SM::sm_get_site_favicon(), 30, 30 ); ?>" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip
        Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="{{asset('nptl-admin/img/splash/sptouch-icon-iphone.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('nptl-admin/img/splash/touch-icon-ipad.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('nptl-admin/img/splash/touch-icon-iphone-retina.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('nptl-admin/img/splash/touch-icon-ipad-retina.png')}}">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">


    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="{{asset('nptl-admin/img/splash/ipad-landscape.png')}}"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="{{asset('nptl-admin/img/splash/ipad-portrait.png')}}"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="{{asset('nptl-admin/img/splash/iphone.png')}}"
          media="screen and (max-device-width: 320px)">

</head>

<body class="animated fadeInDown">

<header id="header">

    <div id="logo">
        <a href="{{url('')}}">
            <img src="<?php echo SM::sm_get_the_src( SM::sm_get_site_logo(), 193, 78 ); ?>"
                 alt="<?php echo SM::get_setting_value( 'site_name' ); ?>">
        </a>
    </div>
    @yield('reff_page_link')

</header>

<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                <h1 class="txt-color-red login-header-big"><?php echo SM::get_setting_value( 'site_name' ); ?></h1>
                <div class="hero">

                    <div class="pull-left login-desc-box-l">
                        <h4 class="paragraph-header"><?php echo SM::get_setting_value( 'tag_line' ); ?></h4>
                        <div class="login-app-icons">
                            <a href="{{url('/')}}" class="btn btn-danger btn-sm">Home</a>
                            <a href="{{url('contact')}}" class="btn btn-danger btn-sm">About US</a>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">About <?php echo SM::get_setting_value( 'site_name' ); ?></h5>
                        <p><?php echo SM::get_setting_value( 'about' ); ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">Contact to <?php echo SM::get_setting_value( 'site_name' ); ?></h5>
                        <p>
							<?php echo SM::get_setting_value( 'address' ); ?>
                        </p>
                        <p>
                            Email: <a
                                    href="mailto:<?php echo $mail = SM::get_setting_value( 'email' ); ?>">{{$mail}}</a>
                        </p>
                        <p>
                            Mobile: <a
                                    href="tel:<?php echo $mobile = SM::get_setting_value( 'Mobile' ); ?>">{{$mobile}}</a>
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                @section('content')
                @show
            </div>
        </div>
    </div>

</div>

<!--================================================== -->

<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script src="{{asset('nptl-admin/js/plugin/pace/pace.min.js')}}"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script>
    if (!window.jQuery) {
        document.write('<script src="<?php echo asset( 'nptl-admin/js/libs/jquery-2.0.2.min.js' ); ?>"><\/script>');
    }
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="<?php echo asset( 'nptl-admin/js/libs/jquery-ui-1.10.3.min.js' ); ?>"><\/script>');
    }
</script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
      <script src="{{asset('nptl-admin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js')}}"></script> -->

<!-- BOOTSTRAP JS -->
<script src="{{asset('nptl-admin/js/bootstrap/bootstrap.min.js')}}"></script>

<!-- JQUERY VALIDATE -->
<script src="{{asset('nptl-admin/js/plugin/jquery-validate/jquery.validate.min.js')}}"></script>

<!-- JQUERY MASKED INPUT -->
<script src="{{asset('nptl-admin/js/plugin/masked-input/jquery.maskedinput.min.js')}}"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- MAIN APP JS FILE -->
<script src="{{asset('nptl-admin/js/app.min.js')}}"></script>

@yield('validation_script')

</body>
</html>