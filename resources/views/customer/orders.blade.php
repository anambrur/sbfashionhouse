 @extends('frontend.master')
@section("title", "Orders")
@section("content")
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-9">
                    <div class="account-panel">
                        <h2>Order @isset($status)
                                @if($status==1)
                                    Completed
                                @elseif($status==2)
                                    Progress
                                @elseif($status==3)
                                    Pending
                                @else
                                    Canceled
                                @endif
                            @endisset List
                        </h2>
                        @if(count($orders)>0)
                            <div class="account-panel-inner">
                                @foreach($orders as $order)
                                    <div class="single-order">
                                        <div class="order-head clearfix">
                                            <h5 class="pull-left"><b>Order date:</b>
                                                {{ date('d-m-Y', strtotime($order->created_at)) }}</h5>
                                            <h5 class="pull-right"><b>Order ID:</b>
                                                {{ SM::orderNumberFormat($order) }}</h5>
                                        </div>
                                        <div class="order-content">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3>
                                                    </h3>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p><b>Order Total:</b> {{ SM::get_setting_value('currency') }} {{ $order->grand_total }}</p>
                                                    <p><b>Paid:</b> {{ SM::get_setting_value('currency') }} {{ $order->paid }}</p>
													<?php
													$due = $order->paid - $order->net_total;
													$dueSign = $due < 0 ? "-" : "+";
													$dueSign = $due == 0 ? "" : $dueSign;
													?>
                                                    @if($due<0)
<!--                                                        <p><b>Due:</b> {{ $dueSign }} ${{ abs($due) }}</p>
                                                        <a href="{{ url("dashboard/orders/pay/$order->id") }}"
                                                           class="btn btn-warning">Pay your Due
                                                        </a>-->
                                                    @endif
                                                    <div class="order-btn">
                                                        {{--<a class="reorder" title="Reorder Invoice"--}}
                                                           {{--href="{!! url("dashboard/orders/reorder/$order->id") !!}"><i--}}
                                                                    {{--class="fa fa-repeat"></i></a>--}}
                                                        <a title="View Invoice" target="_blank"
                                                           href="{!! url("dashboard/orders/detail/$order->id") !!}"><i
                                                                    class="fa fa-eye"></i></a>
                                                        {{--<a href="{!! url("dashboard/orders/edit/$order->id") !!}"><i--}}
                                                        {{--class="fa fa-pencil"></i></a>--}}
                                                        <a title="Download Invoice" href="{!! url("dashboard/orders/download/$order->id") !!}"><i
                                                                    class="fa fa-download"></i> </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p><b>Order Status:</b> <?php
														if ( $order->order_status == 1 ) {
															echo 'Completed';
														} else if ( $order->order_status == 2 ) {
															echo 'Processing';
														} else if ( $order->order_status == 3 ) {
															echo 'Pending';
														} else {
															echo 'Cancel';
														}
														?></p>
                                                    <p><b>Payment Status:</b> <?php
														if ( $order->payment_status == 1 ) {
															echo 'Completed';
														} else if ( $order->payment_status == 2 ) {
															echo 'Pending';
														} else {
															echo 'Cancel';
														}
														?>
                                                    </p>

													<?php
													if ( ! empty( trim( $order->completed_files ) ) ) {
													$files = SM::getMediaArrayFromStringImages( $order->completed_files );
													if ( count( $files ) > 0 ) {
													?>
                                                    <p><strong>Completed Files:</strong><br>
													<?php
													foreach ( $files as $file ) {
														$filename = $file->slug;
														$img      = SM::sm_get_galary_src_data_img( $filename, $file->is_private == 1 ? true : false );
														$src      = $img['src'];
														$data_img = $img['data_img'];

														echo '<a href="' . url( '/dashboard/media/download/' . $file->id ) . '" title="Download ' . $file->title . '">
													<img src="' . $src . '"
                                                     caption="' . $file->caption . '" description="' . $file->description . '"
                                                     class="orderFile"></a>';
													}
													?>
                                                    <div class="clearfix"></div>
                                                    </p>
													<?php
													}
													}
													?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                {!! $orders->links('common.pagination_orders') !!}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-warning"></i> No @isset($status)
                                    @if($status==1)
                                        Completed
                                    @elseif($status==2)
                                        Progress
                                    @elseif($status==3)
                                        Pending
                                    @elseif($status==3)
                                        Canceled
                                    @endif
                                @endisset Order Found!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection