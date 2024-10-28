<?php
$site_name = SM::sm_get_site_name();
$site_name = SM::sm_string($site_name) ? $site_name : 'buckleup-bd';
$mobile = SM::get_setting_value('mobile');
$email = SM::get_setting_value('email');
$address = SM::get_setting_value('address');
$footer_logo = SM::smGetThemeOption("footer_logo", "");
$footer_widget2_title = SM::smGetThemeOption('footer_widget2_title', "Seo Services");
$footer_widget2_description = SM::smGetThemeOption('footer_widget2_description', "");
$footer_widget3_title = SM::smGetThemeOption('footer_widget3_title', "Company");
$footer_widget3_description = SM::smGetThemeOption('footer_widget3_description', "");
$footer_widget4_title = SM::smGetThemeOption('footer_widget4_title', "Technology");
$footer_widget4_description = SM::smGetThemeOption('footer_widget4_description', "");
$contact_branches = SM::smGetThemeOption("contact_branches");
$newsletter_success_title = SM::smGetThemeOption("newsletter_success_title", "Thank You For Subscribing!");
$newsletter_success_description = SM::smGetThemeOption("newsletter_success_description", "You're just one step away from being one of our dear susbcribers.Please check the Email provided and confirm your susbcription.");

?>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <!-- introduce-box -->
        <div id="introduce-box" class="row">
            <div class="col-md-3">
                <div id="address-box">
                    <a href="#"><img src="{!! SM::sm_get_the_src($footer_logo, 171, 45 ) !!}"
                                     alt="{{ SM::sm_get_site_name() }}"/></a>
                    <div id="address-list">
                        
                        <div class="tit-name"><i class="icofont-headphone-alt"></i> {{ $mobile }}</div>
                        <div class="tit-name"><i class="icofont-envelope"></i> {{$email}}</div>
                        <div class="tit-name"><i class="icofont-google-map"></i> {{ $address }}</div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="introduce-title">{{ $footer_widget3_title }}</div>
                        <div class="footer-widged">
                            {!! stripslashes($footer_widget3_description) !!}
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="introduce-title">{{ $footer_widget2_title }}</div>
                        <div class="footer-widged">
                            {!! stripslashes($footer_widget2_description) !!}
                        </div>
                        
                    </div>
                    
                   
                    <div class="col-sm-4">
                        <div class="introduce-title">{{ $footer_widget4_title }}</div>
                        <div class="footer-widged">
                            <?php 
                            
                            
                            
                            ?>
                            {!! stripslashes($footer_widget4_description) !!}
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="contact-box">
                    <div class="introduce-title"></div>
                     {!! Form::open(["method"=>"post", "action"=>'Front\HomeController@subscribe', 'id'=>"newsletterForm"]) !!}
                    <div class="input-group" id="mail-box">
                                <input required type="email" class="form-control" placeholder="Enter Your E-mail Address">
                        <span class="input-group-btn">
                            <button class="btn btn-default" value="Subscribe" type="submit" id="newsletterFormSubmit">Ok</button>
                          </span>
                       
                    </div><!-- /input-group -->
                     {!! Form::close() !!}
                    
                    <div class="introduce-title">Stay Connected</div>
                    <div class="social-link">
                        @empty(!SM::smGetThemeOption("social_facebook"))
                            <a target="_blank" href="{{ SM::smGetThemeOption("social_facebook") }}">
                                <i class="fa fa-facebook"></i>
                            </a>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_twitter"))
                            <a href="{{ SM::smGetThemeOption("social_twitter") }}">
                                <i class="fa fa-twitter"></i>
                            </a>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_google_plus"))
                            <a target="_blank" href="{{ SM::smGetThemeOption("social_google_plus") }}">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_linkedin"))
                            <a href="{{ SM::smGetThemeOption("social_linkedin") }}">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_github"))
                            <a target="_blank" href="{{ SM::smGetThemeOption("social_github") }}">
                                <i class="fa fa-github"></i>
                            </a>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_pinterest"))
                            <a target="_blank" href="{{ SM::smGetThemeOption("social_pinterest") }}">
                                <i class="fa fa-pinterest-p"> </i>
                            </a>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_youtube"))
                            <a target="_blank" href="{{ SM::smGetThemeOption("social_youtube") }}">
                                <i class="fa fa-youtube-play"></i>
                            </a>
                        @endempty
                         @empty(!SM::smGetThemeOption("social_instagram"))
                            <a target="_blank" href="{{ SM::smGetThemeOption("social_instagram") }}">
                                <img src="/storage/uploads/icon-for-zenvo_web-04.png" style="height: 30px; width: 30px;">
                            </a>
                        @endempty
                    </div>
                </div>

            </div>
        </div><!-- /#introduce-box -->

        <!-- #trademark-box -->
        <div id="trademark-box" class="row hidden">
            <div class="col-sm-12">
                <?php
                $payment_methods = \App\Model\Common\Payment_method::Published()->get();
                ?>
                <ul id="trademark-list">
                    <li id="payment-methods">Accepted Payment Methods</li>
                    @forelse($payment_methods as $method)
                        <li>
                            <a href="#">
                                <img src="{{-- SM::sm_get_the_src($method->image) --}}" alt="{{ $method->title --}}"/>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a href="#">
                                <p>No data found!</p>
                            </a>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div> <!-- /#trademark-box -->
    </div>
    
</footer>
<div class="sticky-footer">
    <div class="container">
        <div id="footer-menu-box">
            <p><span>© 2024 All rights reserved</span> <a href="{{ url('/') }}" target="_blank">{{ SM::smGetThemeOption("copyright") }}</a></p> 
            <p>
                <span class="">Developed By  </span> <a target="_blank" href="http://nextpagetl.com/" target="_blank">Next Page Technology LTD</a>
            </p>
        </div><!-- /#footer-menu-box -->
    </div>
</div>

<a href="#" class="scroll_top" title="Scroll to Top" style="display: inline;">Scroll</a>

