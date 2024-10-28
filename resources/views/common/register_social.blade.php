<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 12/3/17
 * Time: 12:04 PM
 */
?>
<?php
$fb_api_enable = SM::get_setting_value( 'fb_api_enable' ) == 'on' ? true : false;
$gp_api_enable = SM::get_setting_value( 'gp_api_enable' ) == 'on' ? true : false;
$tt_api_enable = SM::get_setting_value( 'tt_api_enable' ) == 'on' ? true : false;
$li_api_enable = SM::get_setting_value( 'li_api_enable' ) == 'on' ? true : false;
?>
@if($fb_api_enable || $gp_api_enable || $tt_api_enable || $li_api_enable)
    <div class="login-socail-form">
        <span class="or">OR</span>
        <ul>
            @if($fb_api_enable)
                <li class="face">
                    <a href="{!! url("register/facebook") !!}">
                        <i class="fa fa-facebook"></i> <span>Sign Up with Facebook</span>
                    </a>
                </li>
            @endif
            @if($gp_api_enable)
                <li class="goo">
                    <a href="{!! url("register/google") !!}">
                        <i class="fa fa-google-plus"></i> <span>Sign Up with Google Plus</span>
                    </a>
                </li>
            @endif
            @if($tt_api_enable)
                <li class="twi">
                    <a href="{!! url("register/twitter") !!}"><i
                                class="fa fa-twitter"></i> <span>Sign Up with Twitter</span> </a>
                </li>
            @endif
            @if($li_api_enable)
                <li class="lin">
                    <a href="{!! url("register/linkedin") !!}"><i
                                class="fa fa-linkedin"></i> <span>Sign Up with LinkedIn</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
