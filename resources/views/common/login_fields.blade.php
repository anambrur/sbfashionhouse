<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/14/17
 * Time: 2:18 PM
 */
?>
<h3>Registered Customers</h3>
<p>Have an account with Doodle Digital? Please log into your account, experience our offers and enhance your digital marketing experience with us.</p>
<div class="form-input">
    <label for="login-email">Email Address<span>*</span></label>
    {!! Form::text("username",  null) !!}
    <span class="error-notice"></span>
</div>
<div class="form-input">
    <label for="login-password">Password<span>*</span></label>
    <input name="password" type="password">
    <span class="error-notice"></span>
</div>
<div class="clearfix">
    <div class="form-button pull-left">
        <span></span><b></b>
        <input type="submit" value="login Now">
    </div>
    <a class="forgot-pass pull-right" href="#">Forgot Your Password?</a>
</div>

<?php
$fb_api_enable = SM::get_setting_value( 'fb_api_enable' ) == 'on' ? true : false;
$gp_api_enable = SM::get_setting_value( 'gp_api_enable' ) == 'on' ? true : false;
$tt_api_enable = SM::get_setting_value( 'tt_api_enable' ) == 'on' ? true : false;
$li_api_enable = SM::get_setting_value( 'li_api_enable' ) == 'on' ? true : false;
?>
@if($fb_api_enable || $gp_api_enable || $tt_api_enable)
    <div class="login-socail-form">
        <span class="or">OR</span>
        <ul>
            @if($fb_api_enable)
                <li class="face">
                    <a href="{!! url("login/facebook") !!}"><i class="fa fa-facebook"></i>
                        <span>Login with Facebook</span>
                    </a>
                </li>
            @endif
            @if($gp_api_enable)
                <li class="goo">
                    <a href="{!! url("login/google") !!}"><i
                                class="fa fa-google-plus"></i><span>Login with Google Plus</span>
                    </a>
                </li>
            @endif
            @if($tt_api_enable)
                <li class="twi">
                    <a href="{!! url("login/twitter") !!}"><i
                                class="fa fa-twitter"></i><span>Login with Twitter</span> </a>
                </li>
            @endif
            @if($li_api_enable)
                <li class="lin">
                    <a href="{!! url("login/linkedin") !!}"><i
                                class="fa fa-linkedin"></i><span>Login with LinkedIn</span> </a>
                </li>
            @endif
        </ul>
        @if(Session::has("w_message_social_login"))
            <div class="clearfix text-center">
                <span class="error-notice">{{ Session::get("w_message_social_login") }}</span>
            </div>
			<?php
			Session::forget( "w_message_social_login" );
			?>
        @endif
    </div>
@endif
