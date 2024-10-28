<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/9/17
 * Time: 10:29 AM
 */
?>
@extends('master')
@section('title', 'Checkout')
@section('content')
	<?php
	$breadcrumb = [
		"isBreadcrumbEnable" => SM::smGetThemeOption( "package_is_breadcrumb_enable", false ),
		"pagination" => [
			[
				"title" => "Checkout Pay Due"
			]
		],
		"title"      => SM::smGetThemeOption( "package_banner_title" ),
		"subtitle"   => SM::smGetThemeOption( "package_banner_subtitle" ),
		"image"      => SM::smGetThemeOption( "package_banner_image" ),
	];
	?>
    @include("common.breadcrumb",$breadcrumb)
    {!! Form::open(['method'=>'post', 'url'=>"dashboard/orders/pay-due", "files"=>true, "id"=>"orderForm"]) !!}
    <section class="common-section payment-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="payment-details-wrap">
                        <h5 class="payment-details-title">Payment Details</h5>
                        <ul>
                            <li><span>Package Name</span>: {{ ucwords(strtolower($package_name)) }}</li>
                            <li><span>Package Due Price</span>: ${{ $total_checkout }}</li>
                        </ul>
                    </div>

                    <div class="common-payment-box payment-details">
                        <div class="common-payment-box-padding">
                            <h4>Payment Details *</h4>
                            <p>Your payment will be held securely by Getweb.Inc until your job is sucessfully
                                completed.</p>
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
                            <p>Please Select Payment Method</p>
                            <div class="row margin-top60">
                                <div class="master_and_visa"
                                     style="{{ old("payment_methord")==2 || old("payment_methord")==3 ? 'display: block': 'display: none' }}">
                                    <div class="col-lg-6">
                                        <div class="input-groups">
                                            <label for="card-number">Card Number *</label>
                                            <input name="card_number" id="card-number" type="number"
                                                   value="{!! old("card_number") !!}" autocomplete="off">
                                        </div>
                                        <span class="error-notice">
                                            @if($errors->has('card_number'))
                                                {{ $errors->first("card_number") }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-lg-3">
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
                                    <div class="col-lg-3">
                                        <div class="input-groups">
                                            <label for="ex-year">Expiry Year *</label>
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

                            </div>
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="doddle-btn fill"><span></span><b></b>Pay Due Bill</button>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection
