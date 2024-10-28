<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/9/17
 * Time: 10:29 AM
 */
?>
@extends('frontend.master')
@section('title', 'View Ticket')
@section('content')
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-8">
                    <div class="account-panel">
						<?php
						$orderId = SM::orderNumberFormat( $ticket->order );
						$ticketFormattedId = $orderId . "-" . $ticket->id;
						?>
                        <h2>{{ $ticketFormattedId }} Ticket Detail</h2>
                        <div class="account-panel-inner">
                            <div class="single-order">
                                <div class="order-head clearfix">
                                    <h5 class="pull-left"><b>Ticket ID:</b>
                                        {{ $ticketFormattedId }}</h5>
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
                                            <h3 class="ticket-title">{{ $ticket->subject }}
                                            </h3>
                                            <p><b>Message: </b>{!! stripslashes($ticket->message) !!}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="account-panel">
                        <h2>Ticket Discussion</h2>
                        <div class="account-panel-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="support-comments-area">
                                        @if($details->lastPage() > $details->currentPage())
                                            <div class="text-center margin-top-15">
                                                <a href="{!! url("dashboard/tickets/older-support-detail/$ticket->id") !!}"
                                                   class="btn btn-primary" type="button"
                                                   id="load_more_support"
                                                   data-current="{{ $details->currentPage() }}"
                                                   data-last="{{ $details->lastPage() }}">
                                                    <i class="fa fa-refresh"></i> Load Older Message
                                                </a>
                                            </div>
                                        @endif
                                        <ol class="support-comment-list">
                                            @include("customer/tickets/support-comment-loop")
                                            @if(count($details)<1)
                                                <div class="alert alert-info margin-top-15 no_support_reply">
                                                    No Reply Available
                                                </div>
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['method'=>'post', 'url'=>'dashboard/tickets/reply', 'id'=>'support_ticket_reply']) !!}
                    <div class="account-panel">
                        <h2>Reply Ticket</h2>
                        <div class="account-panel-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="{{ $errors->has('message') ? ' has-error' : '' }}">
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" required>
                                        {!! Form::label('message', "Message")!!}
                                        {!! Form::textarea('message', null,['class'=>'form-control', 'placeholder'=>"Your Message", 'required'=>'', 'id'=>'support_message']) !!}
                                        <span class="error-notice">
                                        @if($errors->has('message'))
                                                {{ $errors->first("message") }}
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary margin-top-15"><i
                                                class="fa fa-save"></i> Reply
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
@section("footer_script")
    <script type="text/javascript">
        $(function () {
            setInterval(function () {
                var $this = $("#last_loaded_support"), last = $this.val(),
                    href = $this.data("href") + "/" + last;
                $.ajax({
                    type: 'get',
                    url: href,
                    success: function (response) {
                        if (response.html != '') {
                            $(".no_support_reply").fadeOut();
                            $this.val(response.id);
                            $('.support-comment-list').append(response.html);
                            $('.support-comments-area').scrollTop($('.support-comment-list').height());
                        }
                    }
                });
            }, 3000);
        })
    </script>
@endsection