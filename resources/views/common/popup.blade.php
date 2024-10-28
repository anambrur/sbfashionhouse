<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 8/16/17
 * Time: 4:33 PM
 */
?>
<!-- start login form -->
<input type="hidden" name="_token" id="table_csrf_token" value="{!! csrf_token() !!}">
<?php
$authCheck = Auth::check();
$newsletter_pop_is_enable = SM::smGetThemeOption( "newsletter_pop_is_enable", 0 );
$offer_is_enable = SM::smGetThemeOption( "offer_is_enable", 0 );

echo Cookie::get( "smSubscribe" );
?>
@if($newsletter_pop_is_enable==1)
	<?php
	$doodleSubscriber = Cookie::get( "doodleSubscriber" );
	if ( !$doodleSubscriber && $authCheck ) {
		$doodleSubscriber = SM::isSubscribed( Auth::user()->email );
	}
	?>
    @if(!$doodleSubscriber)
        <div class="newslatter-popup-item">
            <div class="newslatter-content" id="doodle-newslatter-popup">
                <div class="newslatter-popup-header">
                    <img src="<?php echo SM::sm_get_the_src( SM::sm_get_site_logo(), 193, 78 ); ?>" alt="Logo">
                    <div class="closeBar subscriptionClosedForADay" data-id="#newsletter">
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="newslatter-popup-content pull-left">
                    <h3>{{ SM::smGetThemeOption( "newsletter_pop_title",  'Join Our Newsletter') }}</h3>
                    {!!  SM::smGetThemeOption( "newsletter_pop_description",  '<p>
                    We really care about you and your website as much as you do. from us you get 100% free support.
                </p>') !!}

                    {!! Form::open(["method"=>"post", "action"=>'Front\HomeController@subscribe', 'id'=>"newsletterPopUpForm"]) !!}
                    <div class="newslatter-popup-form">
                        <input type="email" class="popup-email-type" name="email" value="" placeholder="Your E-mail">
                        <button type="submit" id="newsletterPopUpFormSubmit">Submit</button>
                    </div>
                    {!! Form::close() !!}
                    <ul class="newslatter-popup-socail">
                        @empty(!SM::smGetThemeOption("social_facebook"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_facebook") }}"><i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_twitter"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_twitter") }}"><i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_linkedin"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_linkedin") }}"><i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_github"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_github") }}"><i class="fa fa-github"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_behance"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_behance") }}"><i class="fa fa-behance"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_pinterest"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_pinterest") }}"><i
                                            class="fa fa-pinterest-p"></i>
                                </a>
                            </li>
                        @endempty
                    </ul>
                </div>
                <div class="newslatter-popup-img pull-right">
                    <img src="{{ asset('images/newslatter-popup.png') }}" alt="Doodle digital">
                </div>
            </div>
        </div>
    @endif
@endif
@if($offer_is_enable==1)
	<?php
	$doodleOffer = Cookie::get( "doodleOffer" );
	?>
    @if(!$doodleOffer)
        <div class="offer-popup-item">
            <div class="offer-popup-content" id="doodle-offer-popup">
                <div class="newslatter-popup-header offer-popup-header clearfix">
                    <div class="offer-closeBar pull-right offerClosedForADay">
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="newslatter-popup-content offer-popup-cont text-center pull-left">
                    <h3>{{ SM::smGetThemeOption( "offer_title",  '1st Order To 30% Off') }}</h3>
                    {!!  SM::smGetThemeOption( "offer_description",  '<p>
                        As content marketing continues to drive results for businesses trying to reach their audience
                    </p>
                    <a href="#">Get More</a>') !!}
                </div>
                <div class="offer-popup-img pull-right">
                    <img src="{{ asset('images/offer-popup.png') }}" alt="Doodle Digital">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    @endif
@endif
<div class="search-wrap">
    <div class="search-inner" id="main_search">
        <div class="search-select">
            <select id="search_type">
                <option>All</option>
                <option selected>Package</option>
                <option>Blog</option>
                <option>Service</option>
                <option>Case</option>
            </select>
        </div>
        <input id="search_text" type="search" placeholder="Search..." autocomplete="off">
        <button id="searchbtn"><i class="fa fa-search"></i></button>
        <div class="search-list-wrap">
        </div>
    </div>
</div>
<form id="loginForm1" method="post" action="{{ url('/login') }}"
      class="login-form-wraper smAuthHide smAuthForm {{ SM::current_controller()=="LoginController" && SM::current_method()=="index" ? ' active' : '' }}"
      style="display: {{ !$authCheck && SM::current_controller()=="LoginController" && SM::current_method()=="index" ? 'block' : 'none' }}">
	<?php
	$isLoginController = SM::current_controller() == "LoginController" ? true : false;
	?>
    {!! csrf_field() !!}
    <div class="commom-form login-form-new">
        <div class="login-form-new-inner">
            <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
            <div class="row">
                <div class="col-sm-6">
                    <div class="reg-customers">
                        @include('common.login_fields')
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="new-customers clearfix">
                        <h3>New Customers</h3>
                        <p>Create an account with Doodle Digital, and more exciting things await you upon signing up. What are you waiting for? It’s easy and rewarding.</p>
                        <div class="form-button pull-right">
                            <span></span><b></b>
                            <input class="signUpFormShow" type="submit" value="Join Now">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" action="{{ url('/login') }}" class="guest-form-wraper smAuthHide smAuthForm" id="guestForm"
      style="display: none">
    <div class="commom-form login-form-new">
        <div class="login-form-new-inner">
            <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
            <div class="row">
                <div class="col-md-6">
                    {!! csrf_field() !!}
                    @include('common.login_fields')
                </div>
                <div class="col-md-6">
                    <div class="or-separator">
                        <p>OR</p>
                    </div>
                    <div class="reg-customers">
                        <div class="guest-login-here">
                            <div class="form-button inline">
                                <span></span><b></b>
                                <button class="guestLogin">Continue as a Guest</button>
                            </div>
                            <br>
                            <p>You,ll have the option to register for an account after your purchase.</p>

                            <div class="login-socail-form">
                                <div class="form-button inline">
                                    <span></span><b></b>
                                    <button class="signUpFormShow guestSignUp">Signup Now</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<form method="post" action="{{ url('/password/reset') }}" id="forgotPassword"
      class="forgot-form-wraper  smAuthHide smAuthForm {{ !$authCheck && SM::current_controller()=="ForgotPassword" && SM::current_method()=="index" ? ' active' : '' }}"
      style="display: {{ SM::current_controller()=="ForgotPassword" && SM::current_method()=="index" ? 'block' : 'none' }}">
    {!! csrf_field() !!}
	<?php
	$isForgotPassword = SM::current_controller() == "ForgotPassword" ? true : false;
	?>
    <div class="commom-form login-form-new">
        <div class="login-form-new-inner">
            <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
            <div class="row">
                <div class="col-lg-12">
                    <h3>Forgot Your Password</h3>
                    <p>Can’t remember your log in details? Don’t worry. Follow these simple steps and get your access to our site back in a moment.</p>
                    <div class="form-input">
                        <label for="forgot-email">Email Address<span>*</span></label>
                        {!! Form::email("email",  null, ["id"=>"forgot-email"]) !!}
                        <span class="error-notice"></span>
                    </div>
                    <div class="clearfix">
                        <div class="form-button pull-left">
                            <span></span><b></b>
                            <input type="submit" value="Forgot Password">
                        </div>
                    </div>
                    <div class="clearfix">
                        <span class="success-notice"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@if(SM::current_method()=="showResetForm")

    <div
            class="singup-form-wraper  smAuthHide"
            style="display: block">
        <div class="commom-form login-form-new">
            <div class="login-form-new-inner">
                <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" class="smAuthForm" id="resetPassword"
                              action="{{ url('/password/update') }}">
                            {!! csrf_field() !!}
							<?php
							$isshowResetForm = SM::current_method() == "showResetForm" ? true : false;
							?>
                            <h3>Reset Password Form</h3>
                            <div class="form-input">
                                <input type="hidden" name="token" value="{{$token}}">
                                <label for="email">Email Address<span>*</span></label>
                                {!! Form::email("email",  null, ["id"=>"email"]) !!}
                                <span class="error-notice"></span>
                            </div>
                            <div class="form-input">
                                <label for="password">Password<span>*</span></label>
                                <input name="password" id="password" type="password">
                                <span class="error-notice"></span>
                            </div>

                            <div class="form-input">
                                <label for="password_confirmation">Confirmation Password<span>*</span></label>
                                <input name="password_confirmation" id="password_confirmation" type="password">
                                <span class="error-notice"></span>
                            </div>
                            <div class="clearfix">
                                <div class="form-button pull-left">
                                    <span></span><b></b>
                                    <input type="submit" value="Reset Now">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="post" class="smAuthForm" id="loginForm2" action="{{ url('/login') }}">
                            {!! csrf_field() !!}
                            <div class="reg-customers hidden-xs hidden-sm">
                                @include('common.login_fields')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div
        class="singup-form-wraper smAuthHide {{ (SM::current_controller()=="RegisterController"
        && SM::current_method()=="index") ? ' active' : '' }}"
        style="display: {{ !$authCheck && (
      request()->isAuthRegistration ==1 ||
      (SM::current_controller() == "RegisterController" && SM::current_method() == "index" )
        ) ? 'block' : 'none' }}">
    <div class="commom-form login-form-new">
        <div class="login-form-new-inner">
            <a href="#" class="close-icon"><i class="fa fa-times-circle"></i></a>
            <div class="row">
                <div class="col-sm-12">
                    @if(Session::has("socialAuthSuccessMessage"))
                        <div class="alert alert-success">
                            {{ session( 'socialAuthSuccessMessage' ) }}
							<?php
							Session::forget( "socialAuthSuccessMessage" );
							Session::save();
							?>
                        </div>
                    @endif
                    @if(Session::has("socialAuthWarningMessage"))
                        <div class="alert alert-warning">
                            {{ session( 'socialAuthWarningMessage' ) }}
							<?php
							Session::forget( "socialAuthWarningMessage" );
							Session::save();
							?>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <form method="post" id="registrationForm" class="smAuthForm" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                        <h3>Create an Account</h3>
                        <p>Please provide the details in the required fields. Your information is safe with us! </p>
                        <div class="form-input">
                            <label for="username">Username<span>*</span></label>
                            {!! Form::text("username",  null, ["id"=>"username"]) !!}
                            <span class="error-notice"></span>
                        </div>
						<?php
						if ( Session::has( "profile" ) && count( Session::get( "profile" ) ) > 0
						     && isset( Session::get( "profile" )->email ) && Session::get( "profile" )->email != '' ) {
							$profile = Session::get( "profile" );
							$email   = $profile->email;
							$extra   = [ "id" => "email", "readonly" => "" ];
						} else {
							$email = null;
							$extra = [ "id" => "email" ];
						}
						?>
                        <div class="form-input">
                            <label for="email">Email Address<span>*</span></label>
                            {!! Form::email("email",  $email, $extra) !!}
                            <span class="error-notice"></span>
                        </div>
                        <div class="form-input">
                            <label for="password">Password<span>*</span></label>
                            <input name="password" id="password" type="password">
                            <span class="error-notice"></span>
                        </div>

                        <div class="form-input">
                            <label for="password_confirmation">Confirmation Password<span>*</span></label>
                            <input name="password_confirmation" id="password_confirmation" type="password">
                            <span class="error-notice"></span>
                        </div>
                        <div class="clearfix">
                            <div class="form-button pull-left">
                                <span></span><b></b>
                                <input type="submit" value="Signup Now">
                            </div>
                        </div>
                        @include("common.register_social")
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="post" class="smAuthForm" action="{{ url('/login') }}" id="loginForm3">
                        {!! csrf_field() !!}
                        <div class="reg-customers hidden-xs hidden-sm">
                            @include('common.login_fields')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
