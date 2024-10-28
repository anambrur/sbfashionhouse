<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/13/17
 * Time: 5:00 PM
 */
?>
@extends('frontend.master')
@section("title", "Dashboard")
@section("content")
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-9">
                    <div class="account-panel">
                        <h2>Dashboard</h2>
                        <div class="account-panel-inner">
							<?php
							$firstname = Auth::user()->firstname;
							$lastname = Auth::user()->lastname;
							$completeOrder = SM::sm_get_count( 'orders', "user_id", Auth::user()->id, "=", "order_status", 1 );
							$progressOrder = SM::sm_get_count( 'orders', "user_id", Auth::user()->id, "=", "order_status", 2 );
							$pendingOrder = SM::sm_get_count( 'orders', "user_id", Auth::user()->id, "=", "order_status", 3 );
							$cancelledOrder = SM::sm_get_count( 'orders', "user_id", Auth::user()->id, "=", "order_status", 4 );
							?>
                            <h3>
                                Hello {{ $firstname !='' || $lastname !='' ? $firstname." ".$lastname : Auth::user()->username }}</h3>
                            <p>From your My Account Dashboard you have the ability to view a snapshot of your recent
                                tops count activity and update your account information. Select a link below.</p>
                            <div class="order-status">
                                <a class="order-complete" href="{!! url("dashboard/orders/status/1") !!}">
                                    <i class="fa fa-check-square-o"></i>
                                    <p>Order Complete ({{ $completeOrder }})</p>
                                </a>
                                <a class="order-pending" href="{!! url("dashboard/orders/status/2") !!}">
                                    <i class="fa fa-spinner"></i>
                                    <p>Order Progress ({{ $progressOrder }})</p>
                                </a>
                                <a class="order-pending" href="{!! url("dashboard/orders/status/3") !!}">
                                    <i class="fa fa-refresh"></i>
                                    <p>Order Pending ({{ $pendingOrder }})</p>
                                </a>
                                <a class="order-cancel" href="{!! url("dashboard/orders/status/4") !!}">
                                    <i class="fa fa-times"></i>
                                    <p>Order Cancel ({{ $cancelledOrder }})</p>
                                </a>
                            </div>
							<?php
							$name = Auth::user()->firstname . " " . Auth::user()->lastname;
							?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="acc-inner-panel">
                                        <h4>Contact information</h4>
                                        <div class="panel-contents">
                                            @empty(!$name)<p>{{ $name }}</p>@endempty
                                            @empty(!Auth::user()->username)
                                                <p>
                                                    Username: {{ Auth::user()->username }}
                                                </p>
                                            @endempty
                                            @empty(!Auth::user()->mobile)<p>
                                                Mobile: {{ Auth::user()->mobile }}</p>@endempty
                                            @empty(!Auth::user()->email)<p>Email: {{ Auth::user()->email }}</p>@endempty
                                        </div>
                                        <a class="edit-btn" href="{!! url("dashboard/edit-profile") !!}"><i
                                                    class="fa fa-edit"></i>Edit</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="acc-inner-panel">
                                        <h4>Default billing address</h4>
                                        <div class="panel-contents">
                                            @empty(!Auth::user()->street)<p>
                                                Street: {{ Auth::user()->street }}</p>@endempty
                                            @empty(!Auth::user()->city)<p>City: {{ Auth::user()->city }}</p>@endempty
                                            @empty(!Auth::user()->state || Auth::user()->zip)
                                                <p>State/District: {{ Auth::user()->state." - ".Auth::user()->zip }}</p>
                                            @endempty
                                            @empty(!Auth::user()->country)<p>
                                                Country: {{ Auth::user()->country }}</p>@endempty
                                        </div>

                                        <a class="edit-btn" href="{!! url("dashboard/edit-profile") !!}"><i
                                                    class="fa fa-edit"></i>Edit</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
