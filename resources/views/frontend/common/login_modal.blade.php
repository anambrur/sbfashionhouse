<!--Login model-->


<div class="modal fade loginModal" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 737px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b>User Account</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $authCheck = Auth::check();
                    ?>
                    <div class="col-md-6  panel-style ">
                        {{ Form::open(['url' => ['/register'], 'id' => 'registrationForm', 'class' => 'smAuthForm']) }}
                        <h3 class="m-log">Create an account</h3>
                        <p>Please enter your email address to create an account.</p>
                        <label for="Username" class="m-label">Username <span> * </span></label>
                        {!! Form::text('username', null, [
                            'class' => 'form-control input-lg m-log',
                            'required',
                            'id' => 'username',
                            'placeholder' => 'Username . . .',
                        ]) !!}
                        <span class="error-notice"></span>
                        <label for="emmail_register" class="m-label">Email address<span> * </span></label>
                        {!! Form::email('email', null, [
                            'class' => 'form-control input-lg m-log',
                            'required',
                            'id' => 'emmail_login',
                            'placeholder' => 'Email Address . . .',
                        ]) !!}
                        <span class="error-notice"></span>
                        <label for="password" class="m-label">Password<span> * </span></label>
                        <input id="password" type="password" name="password" class="form-control input-lg m-log"
                            placeholder="Password">
                        <label for="conformpassword" class="m-label">Conform Password<span> * </span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="form-control input-lg m-log" placeholder="Conform Password . . .">
                        <button type="submit" class="button btn-lg button-style"><i class="fa fa-user"></i> Create
                            an account
                        </button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-6 panel-style ">
                        <form id="loginForm1" method="post" action="{{ url('/login') }}"
                            class="login-form-wraper smAuthHide smAuthForm {{ SM::current_controller() == 'LoginController' && SM::current_method() == 'index' ? ' active' : '' }}"
                            style="display: {{ !$authCheck && SM::current_controller() == 'LoginController' && SM::current_method() == 'index' ? 'block' : 'block' }}">
                            <?php
                            $isLoginController = SM::current_controller() == 'LoginController' ? true : false;
                            ?>
                            {!! csrf_field() !!}

                            <h3 class="m-log">Already registered?</h3>
                            <label for="emmail_login" class="m-label">Email Address<span> * </span></label>
                            {!! Form::email('username', null, [
                                'class' => 'form-control input-lg m-log',
                                'id' => 'emmail_login',
                                'placeholder' => 'Email Address . . .',
                            ]) !!}
                            <span class="error-notice"></span>
                            <label for="password_login" class="m-label">Password<span> * </span></label>
                            <input id="password_login" required name="password" type="password"
                                class="form-control input-lg m-log" placeholder="Password . . .">
                            <span class="error-notice"></span>
                            <p class="forgot-pass m-log"><a href="{{ url('/forgot-password') }}">Forgot your
                                    password?</a></p>
                            <button type="submit" class="button btn-lg button-style"><i class="fa fa-lock"></i>
                                LOGIN NOW
                            </button>
                        </form>
                    </div>



                    <div class="col-md-6 panel-style ">
                        <form id="loginForm1" method="post" action="{{ url('/signUpPhoneNumber') }}"
                            class="login-form-wraper smAuthHide smAuthForm {{ SM::current_controller() == 'LoginController' && SM::current_method() == 'index' ? ' active' : '' }}"
                            style="display: {{ !$authCheck && SM::current_controller() == 'LoginController' && SM::current_method() == 'index' ? 'block' : 'block' }}">
                            <?php
                            $isLoginController = SM::current_controller() == 'LoginController' ? true : false;
                            ?>
                            {!! csrf_field() !!}

                            <h3 class="m-log">This is Phone number Login system</h3>

                            <label for="mobile" class="m-label">Phone Number<span> * </span></label>
                            <input id="mobile" required name="mobile" type="text"
                                class="form-control input-lg m-log" placeholder="Phone Number">
                            <span class="error-notice"></span>
                            <button type="submit" id="signUpBtn" class="button btn-lg button-style"><i class="fa fa-lock"></i>
                                Sign Up
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 panel-style ">
                        <form id="loginForm1" method="post" action="{{ url('/verifyOtp') }}"
                            class="login-form-wraper smAuthHide smAuthForm {{ SM::current_controller() == 'LoginController' && SM::current_method() == 'index' ? ' active' : '' }}"
                            style="display: {{ !$authCheck && SM::current_controller() == 'LoginController' && SM::current_method() == 'index' ? 'block' : 'block' }}">
                            <?php
                            $isLoginController = SM::current_controller() == 'LoginController' ? true : false;
                            ?>
                            {!! csrf_field() !!}
                            <div class="otp-input">
                                <input type="text" class="form-control" name="otp1" pattern="\d*" maxlength="1"
                                    autofocus="">
                                <input type="text" class="form-control" name="otp2" maxlength="1">
                                <input type="text" class="form-control" name="otp3" maxlength="1">
                                <input type="text" class="form-control" name="otp4" maxlength="1">
                            </div>
                            <input type="hidden" id="valid_mobile" name="valid_mobile" value="">
                            <button type="submit" class="button btn-lg button-style"><i class="fa fa-lock"></i>
                                Login
                            </button>
                        </form>
                    </div>
                </div>
                @include('frontend.common.register_social')
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#signUpBtn').click(function() {
            var mobile = $('#mobile').val();
            $('#valid_mobile').val(mobile);
            
        });
    })
</script>