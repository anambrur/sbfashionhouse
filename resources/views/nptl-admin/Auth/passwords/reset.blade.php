<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/30/17
 * Time: 12:29 PM
 */
?>
@extends('nptl-admin/Auth/AuthLayout')

@section('title','Reset Password')

@section('reff_page_link')
    <span id="extr-page-header-space"> <span class="hidden-mobile">Already registered?</span> <a
                href="{{url(config('constant.smAdminSlug').'/login')}}" class="btn btn-danger">Sign In</a> </span>

@endsection

@section('content')
    <div class="well no-padding">
        <form class="smart-form client-form" id="smart-form-password-update" role="form" method="POST"
              action="{{ url(config('constant.smAdminSlug').'/password/update') }}">
            {!! csrf_field() !!}

            <header>
                Reset Password
            </header>

            <fieldset>
				<?php
				//         echo '<pre>';
				//         print_r($errors->all());
				//         echo '</pre>';
				?>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if(Session::has('message'))
                    <div class="warning">
                        {{ Session::get('message')}}
                    </div>
                @endif
                @if(Session::has('s_message'))
                    <div class="success">
                        {{ Session::get('s_message')}}
                    </div>
                @endif


                <section>
                    <label class="input{{ $errors->has('email') ? ' state-error' : '' }}">
                        <i class="icon-append fa fa-envelope"></i>
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="email" name="email" class="{{ $errors->has('email') ? ' invalid' : '' }}"
                               placeholder="Email address" value="{{ $email or old('email') }}" autocomplete="off">
                        <b class="tooltip tooltip-bottom-right">Enter your email</b> </label>
                    @if ($errors->has('email'))
                        <em class="invalid" for="email">{{ $errors->first('email') }}</em>
                    @endif
                </section>

                <section>
                    <label class="input{{ $errors->has('password') ? ' state-error' : '' }}">
                        <i class="icon-append fa fa-lock"></i>
                        <input type="password" name="password" class="{{ $errors->has('password') ? ' invalid' : '' }}"
                               placeholder="Password" id="password" value="" required="">
                        <b class="tooltip tooltip-bottom-right">Enter your password (Min 6 character's)</b> </label>
                    @if ($errors->has('password'))
                        <em class="invalid" for="password">{{ $errors->first('password') }}</em>
                    @endif
                </section>

                <section>
                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" value=""
                               required="">
                        <b class="tooltip tooltip-bottom-right">Enter your confirm password</b> </label>
                    @if ($errors->has('password_confirmation'))
                        <em class="invalid" for="password">{{ $errors->first('password_confirmation') }}</em>
                    @endif
                </section>
            </fieldset>

            <footer>
                <button type="submit" class="btn btn-primary">
                    Reset Password
                </button>
            </footer>
        </form>

    </div>

@endsection
@section('validation_script')

    <script type="text/javascript">
        runAllForms();

        // Validation
        $(function () {
// Validation
            $("#smart-form-password-update").validate({
// Rules for form validation
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    }
                },
// Messages for form validation
                messages: {
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a VALID email address'
                    },
                    password: {
                        required: 'Please enter your password'
                    },
                    password_confirmation: {
                        required: 'Please enter your password one more time',
                        equalTo: 'Please enter the same password as above'
                    }
                },
// Ajax form submition
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        success: function () {
                            $("#smart-form-register").addClass('submited');
                        }
                    });
                },
// Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>
@endsection
