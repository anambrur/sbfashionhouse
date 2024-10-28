@extends('frontend.master')
@section("title", "About")
@section('content')
    <?php
    $authCheck = Auth::check();
    ?>
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
        @include('frontend.common.breadcrumb')
        <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Left colunm -->
                <div class="column col-xs-12 col-sm-6" id="left_column">
                    <!-- block category -->
                    
                        <div class="block left-module">
                            <p class="title_block">Password Reset</p>
                            <div class="block_content">
                                <!-- layered -->
                                <div class="layered layered-category">
                                    <form method="post" action="{{ url('/password/reset') }}" id="forgotPassword"
                                      class="forgot-form-wraper  smAuthHide smAuthForm {{ !$authCheck && SM::current_controller()=="ForgotPassword" && SM::current_method()=="index" ? ' active' : '' }}"
                                      style="display: {{ SM::current_controller()=="ForgotPassword" && SM::current_method()=="index" ? 'block' : 'none1' }}">
                                    {!! csrf_field() !!}
                                    <?php
                                    $isForgotPassword = SM::current_controller() == "ForgotPassword" ? true : false;
                                    ?>
                                    <span class="forgot-password-message"></span>
                                    <div class="form-list">
                                        {!! Form::email("email",  null, ["id"=>"forgot-email", 'class'=>'input-text form-control', 'required', 'placeholder'=>'Please enter your email']) !!}
                                        <span class="error-notice"></span>
                                    </div>
                                    <div class="signup_email">
                                        <div class="form-list">
                                            <button type="submit" class="button btn-lg button-style labellogin-btn" id="signupform_email"> Send
                                                Reset Link
                                            </button>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <span class="success-notice"></span>
                                    </div>
                                </form>
                                </div>
                                <!-- ./layered -->
                            </div>
                        </div>
                   
                 
                </div>
                <!-- ./left colunm -->
                
            </div>
            <!-- ./row-->
        </div>
    </div>
    <!-- ./page wapper-->
@endsection