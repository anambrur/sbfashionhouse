<?php
$billing = Session::get("billing");
$user = Auth::user();

if (!empty($user->billing_firstname)) {
    $billing_firstname = $user->billing_firstname;
} elseif (!empty($billing["billing_firstname"])) {
    $billing_firstname = $billing["billing_firstname"];
} else {
    $billing_firstname = '';
}
if (!empty($user->billing_lastname)) {
    $billing_lastname = $user->billing_lastname;
} elseif (!empty($billing["billing_lastname"])) {
    $billing_lastname = $billing["billing_lastname"];
} else {
    $billing_lastname = '';
}

if (!empty($user->billing_mobile)) {
    $billing_mobile = $user->billing_mobile;
} elseif (!empty($billing["billing_mobile"])) {
    $billing_mobile = $billing["billing_mobile"];
} else {
    $billing_mobile = '';
}
if (!empty($user->billing_company)) {
    $billing_company = $user->billing_company;
} elseif (!empty($billing["billing_company"])) {
    $billing_company = $billing["billing_company"];
} else {
    $billing_company = '';
}
if (!empty($user->billing_address)) {
    $billing_address = $user->billing_address;
} elseif (!empty($billing["billing_address"])) {
    $billing_address = $billing["billing_address"];
} else {
    $billing_address = '';
}
if (!empty($user->billing_country)) {
    $billing_country_value = $user->billing_country;
} elseif (!empty($billing["billing_country"])) {
    $billing_country_value = $billing["billing_country"];
} else {
    $billing_country_value = '';
}
if (!empty($user->billing_city)) {
    $billing_city = $user->billing_city;
} elseif (!empty($billing["billing_city"])) {
    $billing_city = $billing["billing_city"];
} else {
    $billing_city = '';
}
if (!empty($user->billing_zip)) {
    $billing_zip = $user->billing_zip;
} elseif (!empty($billing["billing_zip"])) {
    $billing_zip = $billing["billing_zip"];
} else {
    $billing_zip = '';
}
?>

{!! Form::open(['method'=>'post', 'url'=>'checkout_billing_address', 'class'=>'form-validate', 'name'=>'signup']) !!}
<div class="row">
    <div class="form-group col-md-6">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control same_address"
               id="billing_firstname" name="billing_firstname"
               value="{{ $billing_firstname }}">
        <span class="help-block error-content" hidden>Please enter your first name</span>
    </div>
    <div class="form-group col-md-6">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control same_address"
               id="billing_lastname" name="billing_lastname"
               value="{{ $billing_lastname }}">
        <span class="help-block error-content" hidden>Please enter your last name</span>
    </div>
    <div class="form-group col-md-6">
        <label for="firstName">Mobile</label>
        <input type="text" class="form-control same_address"
               id="billing_mobile" name="billing_mobile"
               value="{{ $billing_mobile }}">
        <span class="help-block error-content" hidden>Please enter your mobile number</span>
    </div>
    <div class="form-group col-md-6">
        <label for="firstName">Company</label>
        <input type="text" class="form-control same_address"
               id="billing_company" name="billing_company"
               value="{{ $billing_company }}">
        <span class="help-block error-content" hidden>Please enter your company name</span>
    </div>
    <div class="form-group col-md-12">
        <label for="firstName">Address</label>
        <input type="text" class="form-control same_address"
               id="billing_address" name="billing_address"
               value="{{ $billing_address }}">
        <span class="help-block error-content" hidden>Please enter your address</span>
    </div>
    <div class="form-group col-md-6">
        <label for="lastName">Country</label>
        <select name="billing_country" id="s_country"
                class="form-control same_address_select s_country s_p_complete"
                data-s_state="s_state"
                data-onload="<?php echo isset($s_country) ? $s_country : "" ?>">
            <option value="">Select Your Country</option>
            <?php
            $s_countries = SM::$countries;
            $i = 1;

            foreach ($s_countries as $s_country_name)
            {
            ?>
            <option value="{{ $s_country_name }}"
                    @if($billing_country_value == $s_country_name) selected
                    @endif data-id="{{ $i }}">{{ $s_country_name }}</option>
            <?php
            $i++;
            }
            ?>
        </select>
        <span class="help-block error-content" hidden>Please select your country')</span>
    </div>
    <?php
    if(Auth::check()){
    $s_country = old("billing_country") != "" ? old("billing_country") : Auth::user()->billing_country;
    $s_state = old("billing_state") != "" ? old("billing_state") : Auth::user()->billing_state;

    ?>
    {{--                                        @push('script')--}}
    <script>
        $("#s_country").val('<?php echo $s_country; ?>');
            <?php if($s_country != ''): ?>
        var s_selectedCountryIndex = $("#s_country").find('option:selected').attr('data-id');
        var s_state = $("#s_country").attr('data-s_state');
        change_s_state(s_selectedCountryIndex, s_state);
        <?php endif; ?>
        $("#s_state").val('<?php echo $s_state; ?>');
    </script>
    {{--@endpush--}}
    <?php
    }
    ?>
    <div class="form-group col-md-6">
        <label for="firstName">State</label>
        <select required="" name="billing_state" id="s_state"
                class="form-control same_address_select s_state s_p_complete"
                data-onload="<?php echo isset($s_state) ? $s_state : ""; ?>">
            <option value="#">Select State / Province</option>
        </select>
        <span class="help-block error-content" hidden>Please select your state</span>
    </div>

    <div class="form-group col-md-6">
        <label for="lastName">City</label>
        <input type="text" class="form-control same_address"
               id="billing_city" name="billing_city"
               value="{{ $billing_city }}">
        <span class="help-block error-content" hidden>Please enter your city</span>
    </div>
    <div class="form-group col-md-6">
        <label for="lastName">Zip/Postal Code</label>
        <input type="text" class="form-control same_address"
               id="billing_zip" name="billing_zip"
               value="{{ $billing_zip }}">
        <span class="help-block error-content" hidden>Please enter your Zip/Postal Code</span>
    </div>


</div>
<div class="form-row">
    <div class="form-group">
        <div class="form-check">
            {{--<label class="switch">--}}
            {{--<input type="checkbox" checked="" name="shippingOnOff" id="shippingOnOff">--}}
            {{--<span class="slider round"></span>Same shipping and billing address--}}
            {{--</label>--}}
            <label class="switch">
                <input type="checkbox" checked="" name="shippingOnOff" id="shippingOnOff">
                <span class="slider round"></span>
            </label>
            <label style="margin-left:20px ">Same shipping and billing address</label>
        </div>
    </div>
</div>


<div class="submitButton">
    <button type="submit" class="btn btn-success">Continue</button>
</div>
{!! Form::close() !!}

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#billing_firstname").val($("#firstname").val());
            $("#billing_lastname").val($("#lastname").val());
            $("#billing_mobile").val($("#mobile").val());
            $("#billing_company").val($("#company").val());
            $("#billing_address").val($("#address").val());
            $("#billing_country").val($("#country").val());
            $("#billing_state").val($("#state").val());
            $("#billing_city").val($("#city").val());
            $("#billing_zip").val($("#zip").val());

            $(".same_address").attr('readonly', 'readonly');
            $(".same_address_select").attr('disabled', 'disabled');
            $("#shippingOnOff").click(function () {
                if ($("#shippingOnOff").is(":checked")) {
                    $(".same_address").attr('readonly', 'readonly');
                    $(".same_address_select").attr('disabled', 'disabled');
                } else {
                    $("#billing_firstname").val($("#firstname").val());
                    $("#billing_lastname").val($("#lastname").val());
                    $("#billing_mobile").val($("#mobile").val());
                    $("#billing_company").val($("#company").val());
                    $("#billing_address").val($("#address").val());
                    $("#billing_country").val($("#country").val());
                    $("#billing_state").val($("#state").val());
                    $("#billing_city").val($("#city").val());
                    $("#billing_zip").val($("#zip").val());
                    $(".same_address").removeAttr('readonly');
                    $(".same_address_select").removeAttr('disabled');
                }
            });
        });
    </script>
@endpush