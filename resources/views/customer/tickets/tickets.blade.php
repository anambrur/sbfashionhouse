<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/13/17
 * Time: 5:00 PM
 */
?>
@extends('frontend.master')
@section("title", "My Tickets")
@section("content")
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-8">
                    <div class="account-panel">
                        <h2>My Tickets
                        </h2>
                        @if(count($tickets)>0)
                            <div class="account-panel-inner">
                                @foreach($tickets as $ticket)
                                    <div class="single-order">
                                        <div class="order-head clearfix">
											<?php
											$orderId = SM::orderNumberFormat( $ticket->order );
											?>
                                            <h5 class="pull-left"><b>Ticket ID:</b>
                                                {{ $orderId."-".$ticket->id }}</h5>
                                            <h5 class="pull-right"><b>Order ID:</b>
                                                {{ $orderId }}</h5>
                                        </div>
                                        <div class="order-content">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p><b>Status:</b> <?php
														if ( $ticket->status == 1 ) {
															echo 'Completed';
														} else if ( $ticket->status == 2 ) {
															echo 'Processing';
														} else if ( $ticket->status == 3 ) {
															echo 'Pending';
														} else {
															echo 'Cancel';
														}
														?>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p><b>Created date:</b>
                                                        {{ date('d-m-Y', strtotime($ticket->created_at)) }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-12">

                                                    <a title="View Tickets"
                                                       href="{!! url("dashboard/tickets/detail/$ticket->id") !!}">
                                                        <h3 class="ticket-title">{{ $ticket->subject }}</h3>
                                                        <p><b>Message:</b>
															<?php
															$message = $ticket->message;
															if ( strlen( $message ) > 150 ) {
																$message = substr( $message, 0, 150 ) . " ...";
															}
															?>
                                                            {{ $message }}
                                                        </p>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                {!! $tickets->links('common.pagination_orders') !!}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-warning"></i> No Ticket Found!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection