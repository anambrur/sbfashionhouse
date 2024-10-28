
@extends('master')
@section('title', 'Checkout')
@section('content')
	<?php
	$title = SM::smGetThemeOption( "checkout_banner_title" );
	$subtitle = SM::smGetThemeOption( "checkout_banner_subtitle" );
	$bannerImage = SM::smGetThemeOption( "checkout_banner_image" );
	?>
    <!--BREADCRUMB START-->
    <section class="page-banner-section contact-banner-section">
        <div class="blog-banner-sec "
             style="background:url( {!! SM::sm_get_the_src( $bannerImage ) !!}) no-repeat center center /cover">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                          <div class="blog-banner-contents text-center">
                        @empty(!$title)
                            <h1>{{$title}}</h1>
                        @endempty
                        @if(isset($subtitle) && $subtitle != '')
                            <p>{{$subtitle}}</p>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::open(['method'=>'post', 'url'=>"save-order", "files"=>true, "id"=>"orderForm"]) !!}
    <section class="common-section payment-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if($isPaymentCancelled == "cancel")
                        <div class="alert alert-warning alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            Payment Cancelled. Pay again if you like this package.
                        </div>
                    @endif
                    <div class="payment-details-wrap">
                        <h5 class="payment-details-title">Payment Details</h5>
                        <ul>
                            <li><span>Package Name</span>: {!! $package_name !!}</li>
                            <li><span>Package Total Price</span>: ${{ number_format($amount, 2) }}</li>
                        </ul>
                    </div>

                    @empty(!trim($packageInfo->requirements))
                        <div class="common-payment-box we-need-project sm-content">
                            <div class="common-payment-box-padding">
                                <h4>What we need for this project :</h4>
                                {!! stripslashes($packageInfo->requirements) !!}
                            </div>
                        </div>
                    @endif
                    <div class="aditional-message">
                        <textarea name="message" placeholder="Aditional Massage..."></textarea>
                        <div class="box">
                            <input type="file" name="attachments[]" id="file" class="inputfile"
                                   data-multiple-caption="{count} files selected" multiple/>
                            <label for="file"><i class="fa fa-file-text-o"></i> <span>Attchment</span></label>
                            <small>Max upload file size {{ config( 'constant.smPostMaxInMb' ) }}MB.</small>

							<?php
							$index = 0;
							if ($errors->has( 'attachments.' . $index ))
							{
							?>
                            <em class="invalid" for="file">
								<?php
								while ($errors->has( 'attachments.' . $index ))
								{
								?>
                                <span class="error-notice">
                                    {{ $errors->first('attachments.'.$index) }}
                                        </span>
                                <br>
								<?php
								$index ++;
								}
								?>
                            </em>
							<?php
							}
							?>
                        </div>
                    </div>
					<?php
					if ( Auth::check() ) {
						$contact_email = old( "contact_email" ) != "" ? old( "contact_email" ) : Auth::user()->email;
						$firstname     = old( "firstname" ) != "" ? old( "firstname" ) : Auth::user()->firstname;
						$lastname      = old( "lastname" ) != "" ? old( "lastname" ) : Auth::user()->lastname;
						$street        = old( "street" ) != "" ? old( "street" ) : Auth::user()->street;
						$city          = old( "city" ) != "" ? old( "city" ) : Auth::user()->city;
						$zip           = old( "zip" ) != "" ? old( "zip" ) : Auth::user()->zip;
					} else {
						$contact_email = old( "contact_email" ) or "";
						$firstname = old( "firstname" ) or "";
						$lastname = old( "lastname" ) or "";
						$street = old( "street" ) or "";
						$city = old( "city" ) or "";
						$zip = old( "zip" ) or '';
					}
					$checkout_email_label = SM::smGetThemeOption( "checkout_email_label", "Please Provide Your Email Address :" );
					$checkout_email_description = SM::smGetThemeOption( "checkout_email_description", "Please enter a valid email address. We guarantee 100% privacy of this information. Our only purpose of asking the email is to use this to inform you of the scheduled updates of your job." )
					?>
                    <div class="common-payment-box provide-your-email">
                        <div class="common-payment-box-padding">
                            <h4> {{ $checkout_email_label }}</h4>
                            @empty(!$checkout_email_description)
                                <p>{{ $checkout_email_description }}</p>
                            @endempty
                            <input name="contact_email" id="contact_email" type="email"
                                   placeholder="your@example.com" required=""
                                   value="{{ $contact_email }}">
                            <span class="error-notice">
                                @if($errors->has('contact_email'))
                                    {{ $errors->first("contact_email") }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="common-payment-box provide-your-email">
                        <div class="common-payment-box-padding">
                            <h4> Billing Information: *</h4>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                            {!! Form::label('firstname', "First Name")!!}
                                            {!! Form::text('firstname', $firstname,['class'=>'form-control validateName', 'placeholder'=>"First Name", 'required'=>'']) !!}
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
                                        <div class="form-group ab_from_group {{ $errors->has('country') ? ' has-error' : '' }}">
                                            {!! Form::label('country', __("user.country")) !!}
                                            <select name="country" id="country" class="form-control country p_complete"
                                                    data-state="state"
                                                    required=""
                                                    data-onload="<?php echo isset( $country ) ? $country : "" ?>">
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
												$i ++;
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
                                        <div class="form-group ab_from_group {{ $errors->has('state') ? ' has-error' : '' }}">
                                            {!! Form::label('state', __("user.state")) !!}
                                            <select required="" name="state" id="state"
                                                    class="form-control state p_complete"
                                                    required=""
                                                    data-onload="<?php echo isset( $state ) ? $state : ""; ?>">
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
									$country = old( "country" ) != "" ? old( "country" ) : Auth::user()->country;
									$state = old( "state" ) != "" ? old( "state" ) : Auth::user()->state;
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
                                <div class="{{ $errors->has('street') ? ' has-error' : '' }}">
                                    {!! Form::label('street',__("user.street"))!!}
                                    {!! Form::text('street', $street,['class'=>'form-control', 'placeholder'=>__("user.street"), 'required'=>'']) !!}
                                    <span class="error-notice">
                                        @if($errors->has('street'))
                                            {{ $errors->first("street") }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="common-payment-box payment-details">
                        <div class="common-payment-box-padding">
							<?php
							$checkout_payment_description = SM::smGetThemeOption( "checkout_payment_description", "Your payment information will be safe with Doodle Digital. We secure your payment until the successful completion of your job." )
							?>
                            <h4>Payment Details *</h4>
                            @empty(!$checkout_payment_description)
                                <p>{{ $checkout_payment_description }}</p>
                            @endempty
                            <p>Please Select Your Payment Method</p>
                            <div class="payment-methord">
                                @if(count($payment_methods)>0)
                                    @foreach($payment_methods as $method)
                                        <div class="single-payment">
                                            <input type="radio" class="payment_type"
                                                   @if($loop->index==0){{ 'checked="checked"' }} @endif value="{{ $method->id }}"
                                                   name="payment_method"
                                                   id="payment_method{{ $method->title }}">
                                            <label for="payment_method{{ $method->title }}"><img
                                                        src="{!! SM::sm_get_the_src($method->image)!!}"
                                                        alt="{{ $method->title }}"></label>
                                        </div>
                                    @endforeach
                                @endif
                                @if($errors->has('payment_methord'))
                                    <span class="error-notice">{{ $errors->first("payment_methord") }}</span>
                                @endif
                            </div>
                            <div class="row margin-top60">
                                <div class="master_and_visa"
                                     style="{{ old("payment_methord")==2 || old("payment_methord")==3 ? 'display: block': 'display: none' }}">
                                    <div class="col-lg-6">
                                        <div class="input-groups">
                                            <label for="card-number">Card Number *</label>
                                            <input name="card_number" id="card-number" type="text"
                                                   value="{!! old("card_number") !!}"
                                                   autocomplete="off"
                                                   placeholder="**** **** **** ****">
                                        </div>
                                        <span class="error-notice">
                                            @if($errors->has('card_number'))
                                                {{ $errors->first("card_number") }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-lg-3 displayNone cvv2_div">
                                        <div class="input-groups">
                                            <label for="cbc">CVV2 *</label>
                                            <input name="card_cvv2" id="cvv2" type="number"
                                                   value="{!! old("card_cvv2") !!}"
                                                   placeholder="CVV2">
                                        </div>
                                        <span class="error-notice">
                                            @if($errors->has('card_cvv2'))
                                                {{ $errors->first("card_cvv2") }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-lg-3 displayNone card_expire_div">
                                        <div class="input-groups">
                                            <label for="ex-year">Expired Year *</label>
                                            <input class="month_year_calender" name="card_expire" id="card_expire"
                                                   type="text"
                                                   maxlength='7'
                                                   value="{!! old("card_expire") !!}"
                                                   placeholder="{{ date("m/Y") }}"
                                                   onkeyup="formatString(event);">
                                        </div>
                                        <span class="error-notice">
                                            @if($errors->has('card_expire'))
                                                {{ $errors->first("card_expire") }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-lg-12 margin-bottom30">
                                        <div class="remember-pass">
                                            <input name="remember_card" type="checkbox" id="remember1" value="1">
                                            <label for="remember1">Remember this card .</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-groups">
                                        <label for="copon-code">Coupon Code</label>
                                        <input name="coupon_code" id="copon-code" type="text" placeholder="De2F8rc">
                                        <span class="error-notice">
                                            @if($errors->has('coupon_code'))
                                                {{ $errors->first("coupon_code") }}
                                            @endif
                                        </span>
                                        <span class="success-notice">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-groups">
                                        <a class="doddle-btn fill applybtn" href="#"><span></span><b></b>Apply now</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="total-price-payment1">
                            <ul>
                                <li>
                                    Sub Total :
                                    <p>$<span id="sub_total">{{ number_format($amount, 2) }}</span></p>
                                </li>
                                <li style="display: {{ $is_tax_enable==1 ? "block" :"none" }}">
                                    Tax :
                                    <p>$<span id="tax"
                                              data-is_tax_enable="{{ $is_tax_enable }}"
                                        >{{ $tax }}</span></p>
                                </li>
                                <li id="coupon_row" style="display: none">
                                    Coupon Use : <b id="coupon_code"></b>
                                    <p>$<span id="coupon_amount">0</span></p>
                                </li>
                                <li>
                                    Grand Total :
                                    <p>$<span id="total_checkout">{{ number_format($total_checkout, 2) }}</span></p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="">
                        <div class="remember-pass margin-bottom30">
                            <input name="service_agreement" type="checkbox" id="agree" value="1">
                            <label for="agree">
                                I agree to Doodle Digital's <a target="_blank" href="{!! url("terms-conditions") !!}">Terms
                                    & Conditions</a> & <a target="_blank" href="{!! url("privacy-policy") !!}">Privacy Policy.</a>
                            </label>
                            <span class="error-notice">
                                @if($errors->has('service_agreement'))
                                    {{ $errors->first("service_agreement") }}
                                @endif
                            </span>
                        </div>

                        <button type="submit" class="doddle-btn fill"><span></span><b></b>Submit order</button>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection