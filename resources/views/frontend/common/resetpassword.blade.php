@extends('frontend.master')
@section("title", "About")
@section('content')
   
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
                            <p class="title_block">Reset Password</p>
                            <div class="block_content">
                                <!-- layered -->
                                <div class="layered layered-category"> 
                                      <form method="post" class="smAuthForm" id="resetPassword"
                                          action="{{ url('/password/update') }}">
                                        {!! csrf_field() !!}
                                        <?php
                                        $isshowResetForm = SM::current_method() == "showResetForm" ? true : false;
                                        ?>
                                        <h3>Reset Password Form</h3>
                                        <br>
                                        <div class="form-list">
                                            <input type="hidden" name="token" value="{{$token}}">
                                            <label for="email">Email Address<span>*</span></label>
                                            {!! Form::email("email",  null, ["id"=>"email", 'class'=>'input-text form-control', 'required','placeholder'=>'Please enter your email']) !!} 
                                             <span class="error-notice"></span>
                                        </div>
                                        <div class="form-list">
                                            <label for="password">New Password<span>*</span></label>
                                            <input name="password" class="input-text form-control" placeholder="Enter your new password" id="password" type="password">
                                            <span class="error-notice"></span>
                                        </div>
                
                                        <div class="form-list">
                                            <label for="password_confirmation">New Confirmation Password<span>*</span></label>
                                            <input name="password_confirmation" class="input-text form-control" placeholder="Enter your new confirmation password" id="password_confirmation" type="password">
                                            <span class="error-notice"></span>
                                        </div>
                                        <div class="signup_email">
                                        <div class="form-list">
                                            <button type="submit" class="button btn-lg button-style labellogin-btn" id="">Reset Now
                                            </button>
                                        </div>
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