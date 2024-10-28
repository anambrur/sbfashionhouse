<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/9/17
 * Time: 10:29 AM
 */
?>
@extends('frontend.master')
@section('title', 'Add Ticket')
@section('header_style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    @endsection
@section('content')
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-8">

                    {!! Form::open(['method'=>'post', 'url'=>'dashboard/tickets/add']) !!}
                    <div class="account-panel">
                        <h2>Add Ticket</h2>
                        <div class="account-panel-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="{{ $errors->has('order_id') ? ' has-error' : '' }}">
                                        {!! Form::label('order_id', "Order No") !!}
										<?php
										$orderInfo = [];
										if ( $orders ) {
											foreach ( $orders as $order ) {
												$orderInfo[ $order->id ] = SM::orderNumberFormat( $order );
											}
										}
										?>
                                        {!! Form::select('order_id', $orderInfo, null, ['class'=>'form-control select2',  'required'=>'']) !!}
                                        <span class="error-notice">
                                        @if($errors->has('order_id'))
                                                {{ $errors->first("order_id") }}
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="{{ $errors->has('subject') ? ' has-error' : '' }}">
                                        {!! Form::label('subject', "Subject")!!}
                                        {!! Form::text('subject', null, ['class'=>'form-control', 'placeholder'=>"Subject", 'required'=>'']) !!}
                                        <span class="error-notice">
                                        @if($errors->has('subject'))
                                                {{ $errors->first("subject") }}
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="{{ $errors->has('message') ? ' has-error' : '' }}">
                                        {!! Form::label('message', "Message")!!}
                                        {!! Form::textarea('message', null,['class'=>'form-control', 'placeholder'=>"Your Message", 'required'=>'']) !!}
                                        <span class="error-notice">
                                        @if($errors->has('message'))
                                                {{ $errors->first("message") }}
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save
                                        Ticket
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
@section('footer_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript">
        $('.select2').select2();
    </script>
@endsection
