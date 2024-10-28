
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
<!--                    <a href="{!! url("register/facebook") !!}">
                        <i class="fa fa-facebook"></i>
                    </a>-->
                    <a href="login/facebook" class="btn btn-light facebook">Login with Facebook</a>
                </li>
            @endif
            @if($gp_api_enable)
                <li class="goo">
                    <a href="login/google" class="btn btn-light google">Login with Google</a>
                </li>
            @endif
            @if($tt_api_enable)
                <li class="twi">
                    <a href="{!! url("register/twitter") !!}"><i
                                class="fa fa-twitter"></i>
                </li>
            @endif
            @if($li_api_enable)
                <li class="lin">
                    <a href="{!! url("register/linkedin") !!}"><i
                                class="fa fa-linkedin"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif


