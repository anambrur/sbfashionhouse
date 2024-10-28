<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<?php
	$image = ( isset( $image ) ) ? $image : SM::sm_get_the_src( SM::get_setting_value( 'site_screenshot' ) );
	$site_name = SM::sm_get_site_name();
	$site_name = SM::sm_string( $site_name ) ? $site_name : 'Doodle Digital';
	?>
    <title>Maintenance - {{$site_name}}</title>
    <meta name="author" content="Engr. Mizanur Rahman Khan <engr.mrksohag@gmail.com>">
    <link rel="icon" href="<?php echo SM::sm_get_the_src( SM::sm_get_site_favicon(), 30, 30 ); ?>" type="image/x-icon">
    <!-- All CSS -->
<?php
SM::smGetSystemFrontEndCss( [
	"bootstrap.min",
	"font-awesome.min"
] );
?>
<?php
SM::smGetSystemFrontEndCss( [
	"style",
	"responsive",
] );
?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<section class="maintance-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-5">
                <div class="maintance-img text-right">
                    <img src="{{ asset('images/maintaince.png') }}" alt="{{ $site_name }} Maintenance Mode Image">
                </div>
            </div>
            <div class="col-lg-7 col-sm-7">
                <div class="maintaince-content">
                    <h1>Hello !</h1>
                    <h2>{{ SM::get_setting_value( 'maintenance_title' ) }}</h2>
                    {!! SM::get_setting_value( 'maintenance_description' ) !!}
                    <ul class="time-count" id="ab-time-count" data-minutes="{{ $minutes }}">
                        <li>
                            <span id="ab-hours"></span>
                            <span>hours</span>
                        </li>
                        <li>
                            <span id="ab-minutes"></span>
                            <span>minutes</span>
                        </li>
                        <li>
                            <span id="ab-seconds"></span>
                            <span>seconds</span>
                        </li>
                    </ul>
                </div>
                <span class="maintance-bar"></span>
                <div class="maintance-socail pull-left">
                    <ul>
                        @empty(!SM::smGetThemeOption("social_facebook"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_facebook") }}"><i class="fa fa-facebook"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_twitter"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_twitter") }}"><i class="fa fa-twitter"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_linkedin"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_linkedin") }}"><i class="fa fa-linkedin"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_github"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_github") }}"><i class="fa fa-github"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_behance"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_behance") }}"><i class="fa fa-behance"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_pinterest"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_pinterest") }}"><i class="fa fa-pinterest-p"></i> </a>
                            </li>
                        @endempty
                    </ul>
                </div>
                <div class="maintance-logo pull-right">
                    <a href="#">
                        <img src="<?php echo SM::sm_get_the_src( SM::sm_get_site_logo(), 193, 78 ); ?>" alt="{{ $site_name }} Logo">
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!--ALL JS-->
<?php
SM::smGetSystemFrontEndJs( [
	"jquery-3.2.1.min",
	"bootstrap.min",
	"main"
] );
?>
</body>
</html>
