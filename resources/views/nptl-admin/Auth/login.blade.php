<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/30/17
 * Time: 12:28 PM
 */
?>
@extends('nptl-admin/Auth/AuthLayout')

@section('title','Login')

@section('reff_page_link')
    <span id="extr-page-header-space"> <span class="hidden-mobile">Need an account?</span> <a href="{{url(config('constant.smAdminSlug').'/register')}}" class="btn btn-danger">Create account</a> </span>
@endsection

@section('content')
    <div class="well no-padding">
        <form class="smart-form client-form" id="login-form" role="form" method="POST" action="{{ url(config('constant.smAdminSlug').'/login') }}">
            {!! csrf_field() !!}

            <header>
                Sign In
            </header>

            <fieldset>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if(Session::has('w_message'))
                    <div class="warning">
                        {!! Session::get('w_message')!!}
                    </div>
                @endif
                @if(Session::has('s_message'))
                    <div class="success">
                        <i class="fa fa-check"></i> {!! Session::get('s_message')!!}
                    </div>
                @endif
                <section>
                    <label class="label">Username / E-mail</label>
                    <label class="input {{ $errors->has('email') ? ' state-error' : '' }}"> <i class="icon-append fa fa-user"></i>
                        <input type="text" name="email" value="{{ old('email') }}">
                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b></label>
                    @if ($errors->has('email'))
                        <em class="invalid" for="email">{{$errors->first('email')}}</em>
                    @endif
                </section>

                <section>
                    <label class="label">Password</label>
                    <label class="input {{ $errors->has('password') ? ' state-error' : '' }}"> <i class="icon-append fa fa-lock"></i>
                        <input type="password" name="password">
                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
                    @if ($errors->has('password'))
                        <em class="invalid" for="password">Please enter your password</em>
                    @endif
                    <div class="note">
                        <a href="{{ url(config('constant.smAdminSlug').'/password/reset') }}">Forgot password?</a>
                    </div>
                </section>

                <section>
                    <label class="checkbox">
                        <input type="checkbox" name="remember" checked="">
                        <i></i>Stay signed in</label>
                </section>
            </fieldset>
            <footer>
                <button type="submit" class="btn btn-primary">
                    Sign in
                </button>
            </footer>
        </form>

    </div>


@endsection
@section('validation_script')
    <script type="text/javascript">
        runAllForms();
        $(function () {
// Validation
            $("#login-form").validate({
// Rules for form validation
                rules: {
                    email: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    }
                },
// Messages for form validation
                messages: {
                    email: {
                        required: 'Please enter your email address or username'
                    },
                    password: {
                        required: 'Please enter your password'
                    }
                },
// Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>
@endsection
