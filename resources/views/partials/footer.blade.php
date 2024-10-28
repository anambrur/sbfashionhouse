<?php
//$site_name = SM::sm_get_site_name();
//$site_name = SM::sm_string( $site_name ) ? $site_name : 'Doodle Digital';
//$mobile = SM::get_setting_value( 'mobile' );
//$email = SM::get_setting_value( 'email' );
$footer_logo = SM::smGetThemeOption( "footer_logo", "" );
$footer_widget2_title = SM::smGetThemeOption( 'footer_widget2_title', "Seo Services" );
$footer_widget2_description = SM::smGetThemeOption( 'footer_widget2_description', "" );
$footer_widget3_title = SM::smGetThemeOption( 'footer_widget3_title', "Company" );
$footer_widget3_description = SM::smGetThemeOption( 'footer_widget3_description', "" );
$footer_widget4_title = SM::smGetThemeOption( 'footer_widget4_title', "Technology" );
$footer_widget4_description = SM::smGetThemeOption( 'footer_widget4_description', "" );
$contact_branches = SM::smGetThemeOption( "contact_branches" );
$newsletter_success_title = SM::smGetThemeOption( "newsletter_success_title", "Thank You For Subscribing!");
$newsletter_success_description = SM::smGetThemeOption( "newsletter_success_description", "You're just one step away from being one of our dear susbcribers.Please check the Email provided and confirm your susbcription.");
?>
<div class="successful-popup-wrap" id="newsletterPopUp" style="display: none">
    <div class="successful-popup">
        <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
        <img src="{{ asset('images/success.png') }}" alt="check">
        <h3 class="popup_title">{{ $newsletter_success_title }}</h3>
        <p class="popup_message">{!! $newsletter_success_description !!}</p>
        <a class="success-popup" href="{{ url('/') }}">{{ $site_name }}</a>
    </div>
</div>
<div class="successful-popup-wrap" style="display: none;">
    <div class="successful-popup">
        <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
        <img src="{{ asset('images/thanku.png') }}" alt="Thank You">
        <h3>Thank You!</h3>
        <p>Your submission has been received!</p>
        <a class="success-popup" href="{{ url('/') }}">{{ $site_name }}</a>
    </div>
</div>
<!--FOOTER START-->
<footer class="footer">
    <div class="footer-widget-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <aside class="widget">
                        <div class="about-widget">
                            <div class="flogo">
                                <a href="#">
                                    <img src="{!! SM::sm_get_the_src($footer_logo, 193, 78 ) !!}"
                                         alt="{{ SM::sm_get_site_name() }}">
                                </a>
                            </div>
                            <ul>
                                <li>
                                    <a href="mailto:{{$email}}">
                                        <img src="{{ asset('images/email-icon.png') }}" alt="Email">
                                        {{ $email }}
                                    </a>
                                </li>
                                <li>
                                    <a href="skype:">
                                        <img src="{{ asset('images/skype-icon.png') }}" alt="Skype">
                                        Connect Skype
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('images/chatting-cion.png') }}" alt="Live Chat">
                                        Live Chat
                                    </a>
                                </li>
                                <li>
                                    <a href="tel:{{ $mobile }}">
                                        <img src="{{ asset('images/phone-icon.png') }}" alt="Phone">
                                        {{ $mobile }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <aside class="widget">
                        <h3 class="widget-title">{{ $footer_widget2_title }}</h3>
						<?php
						$services = SM::getServices();
						?>
                        @if($services)
                            <ul>
                                @foreach($services as $service)
                                    <li><a href="{!! url("/services/".$service->slug) !!}">{{ $service->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </aside>
                </div>
                <div class="clearfix visible-sm"></div>
                <div class="col-lg-3 col-sm-6">
                    <aside class="widget">
                        <h3 class="widget-title">{{ $footer_widget4_title }}</h3>
                        {!! stripslashes($footer_widget4_description) !!}
                    </aside>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <aside class="widget">
                        <h3 class="widget-title">{{ $footer_widget3_title }}</h3>
                        {!! stripslashes($footer_widget3_description) !!}
                    </aside>
                </div>
            </div>
            <!-- animation -->
            <div class="footer-animation3">
                <div class="loader-6"><span></span></div>
            </div>
            <div class="footer-animation4">
                <div class="loader-6"><span></span></div>
            </div>
            <div class="footer-animation5">
                <div class="loader-6"><span></span></div>
            </div>
        </div>
    </div>
    <div class="footer-info-area">
        <div class="container">
            @if($contact_branches)
                @foreach($contact_branches as $branch)
                    <div class="footer-location">
                        <div class="single-info">
                            <i class="fa fa-map-marker"></i>
                            @empty(!$branch['title'])
                                <h3>{{ $branch['title'] }}</h3>
                            @endempty
                            @empty(!$branch['footer_address'])
                                <p>{{ $branch['footer_address'] }}</p>
                            @endempty
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="footer-location">
                <div class="doodle_footer-socail">
                    @empty(!SM::smGetThemeOption("social_facebook"))
                        <a href="{{ SM::smGetThemeOption("social_facebook") }}" class="face"><i
                                    class="fa fa-facebook"></i>
                            <span class="fa fa-facebook"></span>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption("social_twitter"))
                        <a href="{{ SM::smGetThemeOption("social_twitter") }}" class="twi"><i
                                    class="fa fa-twitter"></i>
                            <span class="fa fa-twitter"></span>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption("social_google_plus"))
                        <a href="{{ SM::smGetThemeOption("social_google_plus") }}" class="goo"><i
                                    class="fa fa-google-plus"></i>
                            <span class="fa fa-google-plus"></span>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption("social_linkedin"))
                        <a href="{{ SM::smGetThemeOption("social_linkedin") }}" class="link"><i
                                    class="fa fa-linkedin"></i>
                            <span class="fa fa-linkedin"></span>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption("social_github"))
                        <a href="{{ SM::smGetThemeOption("social_github") }}" class="git"><i
                                    class="fa fa-github"></i>
                        </a>
                        <span class="fa fa-github"></span>
                    @endempty
                    @empty(!SM::smGetThemeOption("social_pinterest"))
                        <a href="{{ SM::smGetThemeOption("social_pinterest") }}" class="pin"><i
                                    class="fa fa-pinterest-p"></i>
                            <span class="fa fa-pinterest-p"></span>
                        </a>
                    @endempty
                    @empty(!SM::smGetThemeOption("social_youtube"))
                        <a href="{{ SM::smGetThemeOption("social_youtube") }}" class="you"><i
                                    class="fa fa-youtube-play"></i>
                        </a>
                        <span class="fa fa-github"></span>
                    @endempty
                </div>
            </div>
            <div class="clearfix"></div>

            <!-- animation -->
            <div class="footer-animation1">
                <div class="loader-6"><span></span></div>
            </div>
            <div class="footer-animation2">
                <div class="loader-6"><span></span></div>
            </div>
        </div>
    </div>
    <div class="copyright-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-11">
                    <p class="copyright-text">
                        {{ SM::smGetThemeOption("copyright") }}
                    </p>
                    <!-- animation -->
                    <div class="footer-animation">
                        <div class="loader-6"><span></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="back-to-top">
            <a href="#" id="back-to-top"><i class="fa fa-arrow-up"></i></a>
        </div>
    </div>
</footer>
<!--FOOTER END-->