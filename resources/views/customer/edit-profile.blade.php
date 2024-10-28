@extends('frontend.master')
@section('title', 'Edit Profile')
@section('content')
    <?php
    $contact_email = old("contact_email") != "" ? old("contact_email") : Auth::user()->email;
    $firstname = old("firstname") != "" ? old("firstname") : Auth::user()->firstname;
    $lastname = old("lastname") != "" ? old("lastname") : Auth::user()->lastname;
    $address = old("address") != "" ? old("address") : Auth::user()->address;
    $city = old("city") != "" ? old("city") : Auth::user()->city;
    $zip = old("zip") != "" ? old("zip") : Auth::user()->zip;
    $mobile = old("mobile") != "" ? old("mobile") : Auth::user()->mobile;
    $skype = SM::get_front_user_meta(Auth::user()->id, 'skype');

    ?>
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-8">
                    {!! Form::open(['method'=>'post', 'url'=>'dashboard/update-password']) !!}
                    <div class="account-panel">
                        <h2>Account Information</h2>
                        <div class="account-panel-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::label('username', "Username")!!}
                                            {!! Form::text('username', Auth::user()->username,['class'=>'form-control', 'disabled'=>'']) !!}
                                            <span class="error-notice"></span>
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('useremail',"Email")!!}
                                            {!! Form::text('useremail', Auth::user()->email,['class'=>'form-control', 'disabled'=>'']) !!}
                                            <span class="error-notice"></span>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                                        {!! Form::label('current_password', "Current Password")!!}
                                                        {!! Form::password('current_password', ['class'=>'form-control', 'placeholder'=>"Current Password", 'required'=>'']) !!}
                                                        <span class="error-notice">
                                                @if($errors->has('current_password'))
                                                                {{ $errors->first("current_password") }}
                                                            @endif
                                            </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                                                        {!! Form::label('password', "New Password")!!}
                                                        {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>"Password", 'required'=>'']) !!}
                                                        <span class="error-notice">
                                                @if($errors->has('password'))
                                                                {{ $errors->first("password") }}
                                                            @endif
                                            </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                        {!! Form::label('password_confirmation', "Confirm Password")!!}
                                                        {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>"Confirm Password", 'required'=>'']) !!}
                                                        <span class="error-notice">
                                                @if($errors->has('password_confirmation'))
                                                                {{ $errors->first("password_confirmation") }}
                                                            @endif
                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i>
                                                Update Password
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    {!! Form::open(['method'=>'post', 'url'=>'dashboard/save-profile']) !!}
                    <div class="account-panel">
                        <h2>Personal Information</h2>
                        <div class="account-panel-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                                {!! Form::label('firstname', "First Name")!!}
                                                {!! Form::text('firstname', $firstname,['class'=>'form-control', 'placeholder'=>"First Name", 'required'=>'']) !!}
                                                <span class="error-notice">
                                                @if($errors->has('firstname'))
                                                        {{ $errors->first("firstname") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                                {!! Form::label('lastname',"Last Name")!!}
                                                {!! Form::text('lastname', $lastname,['class'=>'form-control', 'placeholder'=>"Last Name", 'required'=>'']) !!}
                                                <span class="error-notice">
                                                @if($errors->has('lastname'))
                                                        {{ $errors->first("lastname") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                                {!! Form::label('mobile', "Mobile No")!!}
                                                {!! Form::text('mobile', $mobile,['class'=>'form-control', 'placeholder'=>"Mobile No", 'required'=>'']) !!}
                                                <span class="error-notice">
                                                @if($errors->has('mobile'))
                                                        {{ $errors->first("mobile") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="{{ $errors->has('skype') ? ' has-error' : '' }}">
                                                {!! Form::label('skype',"Skype ID")!!}
                                                {!! Form::text('skype', $skype,['class'=>'form-control', 'placeholder'=>"Skype ID"]) !!}
                                                <span class="error-notice">
                                                @if($errors->has('skype'))
                                                        {{ $errors->first("skype") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="{{ $errors->has('address') ? ' has-error' : '' }}">
                                        {!! Form::label('address',__("Address"))!!}
                                        {!! Form::text('address', $address,['class'=>'form-control', 'placeholder'=>__("Address"), 'required'=>'']) !!}
                                        <span class="error-notice">
                                        @if($errors->has('address'))
                                                {{ $errors->first("address") }}
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="{{ $errors->has('city') ? ' has-error' : '' }}">
                                                {!! Form::label('city',__("user.city"))!!}
                                                {!! Form::text('city', $city,['class'=>'form-control', 'placeholder'=>__("user.city"), 'required'=>'']) !!}
                                                <span class="error-notice">
                                                @if($errors->has('city'))
                                                        {{ $errors->first("city") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="{{ $errors->has('zip') ? ' has-error' : '' }}">
                                                {!! Form::label('zip',__("user.zip"))!!}
                                                {!! Form::number('zip', $zip,['class'=>'form-control', 'placeholder'=>__("user.zip"), 'required'=>'']) !!}
                                                <span class="error-notice">
                                                @if($errors->has('zip'))
                                                        {{ $errors->first("zip") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                                {!! Form::label('country', __("user.country")) !!}
                                                <select name="country" id="country"
                                                        class="form-control country p_complete"
                                                        data-state="state"
                                                        required=""
                                                        data-onload="<?php echo isset($country) ? $country : "" ?>">
                                                    <option value="">Select Your Country</option>
                                                    <?php
                                                    $countries = SM::$countries;
                                                    $i = 1;
                                                    foreach ($countries as $country_name)
                                                    {
                                                    //                                 if (in_array($i, array(17, 18, 19, 20)))
                                                    //                                 {
                                                    ?>
                                                    <option value="<?php echo $country_name; ?>"
                                                            data-id="<?php echo $i; ?>"><?php echo $country_name; ?></option>
                                                    <?php
                                                    //                                 }
                                                    $i++;
                                                    }
                                                    ?>
                                                </select>
                                                <span class="error-notice">
                                                @if($errors->has('street'))
                                                        {{ $errors->first("street") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                                                {!! Form::label('state', __("user.state")) !!}
                                                <select required="" name="state" id="state"
                                                        class="form-control state p_complete"
                                                        required=""
                                                        data-onload="<?php echo isset($state) ? $state : ""; ?>">
                                                    <option value="#">Select State / Province</option>
                                                </select>
                                                <span class="error-notice">
                                                @if($errors->has('state'))
                                                        {{ $errors->first("state") }}
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                        <?php
                                        if(Auth::check()){
                                        $country = old("country") != "" ? old("country") : Auth::user()->country;
                                        $state = old("state") != "" ? old("state") : Auth::user()->state;
                                        ?>
                                        <script>
                                            $("#country").val('<?php echo $country; ?>');
                                                <?php if($country != ''): ?>
                                            var selectedCountryIndex = $("#country").find('option:selected').attr('data-id');
                                            var state = $("#country").attr('data-state');
                                            change_state(selectedCountryIndex, state);
                                            <?php endif; ?>
                                            $("#state").val('<?php echo $state; ?>');
                                        </script>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save
                                        Profile
                                    </button>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>


@endsection


