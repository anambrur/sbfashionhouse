@extends("nptl-admin/master")
@section("title","Order")
@section("content")
	<?php
	$edit_order = SM::check_this_method_access( 'orders', 'edit' ) ? 1 : 0;
	$order_status_update = SM::check_this_method_access( 'orders', 'order_status_update' ) ? 1 : 0;
	$delete_order = SM::check_this_method_access( 'orders', 'destroy' ) ? 1 : 0;
	$per = $edit_order + $delete_order;
	?>
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="order_list_wid">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-shopping-cart"></i> </span>
                        <h2>Order list </h2>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body table-responsive">

                            <!-- this is what the user will see -->
                            <table id="manage_blog" class="table table-striped table-bordered data_table" width="100%">

                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due / Advanced</th>
 									<?php if ($order_status_update != 0): ?>
                                    <th class="text-center">Order Status</th>
                                    <th class="text-center">Payment Status</th>
									<?php endif; ?>
									<?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.order.orders')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due / Advanced</th>
 									<?php if ($order_status_update != 0): ?>
                                    <th class="text-center">Order Status</th>
                                    <th class="text-center">Payment Status</th>
									<?php endif; ?>
									<?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                                </tfoot>
                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$all_order])
                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>

    <!-- Button trigger modal -->
    <div class="modal fade" id="sm_order_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                {!! Form::open(["method"=>"post", "route"=>"order_info_update", "id"=>"order_status_form"]) !!}
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Order</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="od_pay_div">
                        <input type="hidden" id="od_order_id" name="order_id">
                        <input type="hidden" id="od_row">
                        <input type="hidden" id="od_order_status" name="order_status">
                        <label for="od_pay">Pay Due</label>
                        <input type="number" class="form-control" step="any" id="od_pay" name="pay">
                        <span class="help-block">
                              <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="od_mail_message">Mail Message</label>
                        <textarea class="form-control" id="od_mail_message" name="message" rows="8" required></textarea>
                        <span class="help-block">
                              <strong></strong>
                        </span>
                    </div>
                    <div class="row hidden">
                        @include('nptl-admin/common/common/gallary_form',['header_name'=>'Mail Files', 'image'=>'', 'grid'=>'col-xs-12 col-sm-12 col-md-12'])
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save_order_info"><i class="fa fa-save"></i>
                        Save Order Info and Send Mail
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="modal fade" id="sm_mail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                {!! Form::open(["method"=>"post", "route"=>"order_mail", "id"=>"order_mail_form"]) !!}
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Mail</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="od_mail_message">Mail Message</label>
                        <input type="hidden" id="mail_order_id" name="order_id">
                        <textarea class="form-control" id="od_mail_message" name="message" rows="8" required></textarea>
                        <span class="help-block">
                              <strong></strong>
                        </span>
                    </div>
                    <div class="row">
                        @include('nptl-admin/common/common/gallary_form',[
                        'header_name'=>'Mail Files',
                        'image'=>'',
                        'input_holder'=>'order_image',
                        'img_holder'=>'order_mail',
                        'grid'=>'col-xs-12 col-sm-12 col-md-12'
                        ])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="send_order_info"><i class="fa fa-save"></i>
                        Send Mail
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="modal fade" id="sm_order_payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                {!! Form::open(["method"=>"post", "route"=>"payment_info_update", "id"=>"payment_status_form"]) !!}
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Order</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="pm_order_id" name="order_id">
                        <input type="hidden" id="pm_row">
                        <input type="hidden" id="pm_payment_status" name="payment_status">
                        <label for="pm_pay">Pay Due</label>
                        <input type="number" class="form-control" step="any" id="pm_pay" name="pay" min="1">
                        <span class="help-block">
                              <strong></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save_payment_info"><i class="fa fa-save"></i> Save
                        Order Info
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @include(('nptl-admin/common/media/media_pop_up'))
@endsection