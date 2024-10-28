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
    <span id="extr-page-header-space"> <span class="hidden-mobile">Already registered?</span> <a href="{{url(config('constant.smAdminSlug').'/login')}}" class="btn btn-danger">Sign In</a> </span>

@endsection

@section('content')
    <div class="well no-padding">
        <form class="smart-form client-form" id="smart-form-reset"  role="form" method="POST" action="{{ url('admin/password/reset') }}">
            {!! csrf_field() !!}

            <header>
                Reset Password
            </header>

            <fieldset>
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
                        <input type="email" name="email" class="{{ $errors->has('email') ? ' invalid' : '' }}" placeholder="Email address" value="{{ old('email') }}">
                        <b class="tooltip tooltip-bottom-right">Enter your email</b> </label>
                    @if ($errors->has('email'))
                        <em class="invalid" for="email">{{ $errors->first('email') }}</em>
                    @endif
                </section>
            </fieldset>


            <footer>
                <button type="submit" class="btn btn-primary">
                    Send Password Reset Link
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
            $("#smart-form-reset").validate({
// Rules for form validation
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
// Messages for form validation
                messages: {
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a VALID email address'
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
