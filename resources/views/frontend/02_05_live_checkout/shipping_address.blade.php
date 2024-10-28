<?php
$shipping = Session::get("shipping");
$user = Auth::user();

if (!empty($user->firstname)) {
    $firstname = $user->firstname;
} elseif (!empty($shipping["firstname"])) {
    $firstname = $shipping["firstname"];
} else {
    $firstname = '';
}
if (!empty($user->lastname)) {
    $lastname = $user->lastname;
} elseif (!empty($shipping["lastname"])) {
    $lastname = $shipping["lastname"];
} else {
    $lastname = '';
}

if (!empty($user->mobile)) {
    $mobile = $user->mobile;
} elseif (!empty($shipping["mobile"])) {
    $mobile = $shipping["mobile"];
} else {
    $mobile = '';
}
if (!empty($user->company)) {
    $company = $user->company;
} elseif (!empty($shipping["company"])) {
    $company = $shipping["company"];
} else {
    $company = '';
}
if (!empty($user->address)) {
    $address = $user->address;
} elseif (!empty($shipping["address"])) {
    $address = $shipping["address"];
} else {
    $address = '';
}
if (!empty($user->country)) {
    $country_value = $user->country;
} elseif (!empty($shipping["country"])) {
    $country_value = $shipping["country"];
} else {
    $country_value = '';
}
if (!empty($user->city)) {
    $city = $user->city;
} elseif (!empty($shipping["city"])) {
    $city = $shipping["city"];
} else {
    $city = '';
}
if (!empty($user->zip)) {
    $zip = $user->zip;
} elseif (!empty($shipping["zip"])) {
    $zip = $shipping["zip"];
} else {
    $zip = '';
}
?>

{!! Form::open(['method'=>'post', 'url'=>'checkout_shipping_address', 'class'=>'form-validate', 'name'=>'signup']) !!}


<div class="form-row">
    <div class="form-group col-md-6">
        <label for="firstName">First Name</label>
        <input required type="text" class="form-control field-validate" id="firstname" name="firstname"
               value="{{ $firstname }}">
        <span class="help-block error-content" hidden>Please enter your first name')</span>
    </div>
    <div class="form-group col-md-6">
        <label for="lastName">Last Name</label>
        <input required type="text" class="form-control field-validate" id="lastname" name="lastname"
               value="{{ $lastname }}">
        <span class="help-block error-content" hidden>Please enter your last name')</span>
    </div>
    <div class="form-group col-md-6">
        <label for="firstName">Mobile</label>
        <input required type="text" class="form-control field-validate" id="mobile" name="mobile"
               value="{{ $mobile }}">
        <span class="help-block error-content" hidden>Please enter your mobile number')</span>
    </div>
    <div class="form-group col-md-6">
        <label for="firstName">Company</label>
        <input required type="text" class="form-control field-validate" id="company" name="company"
               value="{{ $company }}">
        <span class="help-block error-content" hidden>Please enter your company name')</span>
    </div>
    <div class="form-group col-md-12">
        <label for="firstName">Address</label>
        <input required type="text" class="form-control field-validate" id="address" name="address"
               value="{{ $address }}">
        <span class="help-block error-content" hidden>Please enter your address')</span>
    </div>
    <div class="form-group col-md-6">
        <label for="lastName">Country</label>
        <select name="country" id="country"
                class="form-control country p_complete"
                data-state="state"
                required=""
                data-onload="<?php echo isset($country) ? $country : "" ?>">
            <option value="">Select Your Country</option>
            <?php
            $countries = SM::$countries;
            ?>
            @if(count($countries)>0)
                <?php
                $i = 1;
                ?>
                @foreach($countries as $country)
                    <option data-id="{{ $i }}" value="{{$country}}"
                            @if($country_value == $country) selected @endif >{{$country}}</option>
                    <?php
                    $i++;
                    ?>
                @endforeach
            @endif
        </select>
        <span class="help-block error-content" hidden>Please select your country</span>
    </div>
    <div class="form-group col-md-6">
        <label for="firstName">State</label>
        <select required="" name="state" id="state"
                class="form-control state p_complete"
                required=""
                data-onload="<?php echo isset($state) ? $state : ""; ?>">
            <option value="#">Select State / Province</option>
        </select>
        <span class="help-block error-content" hidden>Please select your state</span>
    </div>
    <?php
    if(Auth::check()){
    $country = old("country") != "" ? old("country") : Auth::user()->country;
    $state = old("state") != "" ? old("state") : Auth::user()->state;
    ?>
    {{--                                        @push('script')--}}
    <script>
        $("#country").val('<?php echo $country; ?>');
            <?php if($country != ''): ?>
        var selectedCountryIndex = $("#country").find('option:selected').attr('data-id');
        var state = $("#country").attr('data-state');
        change_state(selectedCountryIndex, state);
        <?php endif; ?>
        $("#state").val('<?php echo $state; ?>');
    </script>
    {{--@endpush--}}
    <?php
    }
    ?>
    <div class="form-group col-md-6">
        <label for="lastName">City</label>
        <input required type="text" class="form-control field-validate" id="city" name="city"
               value="{{ $city }}">
        <span class="help-block error-content" hidden>Please enter your city</span>
    </div>
    <div class="form-group col-md-6">
        <label for="lastName">Zip/Postal Code</label>
        <input required type="text" class="form-control" id="zip" name="zip"
               value="{{ $zip }}">
        <span class="help-block error-content" hidden>Please enter your Zip/Postal Code</span>
    </div>
</div>
<div class="submitButton">
    <button type="submit" class="btn btn-success">Continue</button>
</div>
{!! Form::close() !!}