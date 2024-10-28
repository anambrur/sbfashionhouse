@extends("nptl-admin/master")
@section("title","Subscribers")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
	<?php
	$edit_subscriber = SM::check_this_method_access( 'subscribers', 'edit' ) ? 1 : 0;
	$subscriber_status_update = SM::check_this_method_access( 'subscribers', 'subscriber_status_update' ) ? 1 : 0;
	$delete_subscriber = SM::check_this_method_access( 'subscribers', 'destroy' ) ? 1 : 0;
	$per = $edit_subscriber + $delete_subscriber;
	?>
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="subscriber_list_wid">
                    <!-- widget options:
                       usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                       data-widget-colorbutton="false"
                       data-widget-editbutton="false"
                       data-widget-togglebutton="false"
                       data-widget-deletebutton="false"
                       data-widget-fullscreenbutton="false"
                       data-widget-custombutton="false"
                       data-widget-collapsed="true"
                       data-widget-sortable="false"

                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-star"></i> </span>
                        <h2>Subscriber list </h2>

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
                            <div class="row">
                                <form method="get" action="">
                                    <div class="col-md-3 form-group">
                                        <label for="fullname">Name</label>
                                        <input type="text" placeholder="Name" class="form-control" id="fullname"
                                               name="fullname"
                                               value="{{ $fullname }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="name">Email</label>
                                        <input type="email" placeholder="Email" class="form-control" id="email"
                                               name="name"
                                               value="{{ $email }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="country">Country</label>
                                        <select name="country" id="country" class="form-control "
                                                data-onload="<?php echo isset( $country ) ? $country : "" ?>">
                                            <option value="">Select Your Country</option>
											<?php
											$countries = SM::$countries;
											foreach ($countries as $country_name)
											{
											?>
                                            <option value="{{ $country_name}}" {{ $country == $country_name ? "selected" : "" }}><?php echo $country_name; ?></option>
											<?php
											}
											?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="status">Status</label>
                                        <select name="sstatus" id="sstatus" class="form-control ">
                                            <option value="">Select Subscriber Status</option>
                                            <option value="1" {{ $sstatus == '1' ? "selected" : "" }}>Subscribed
                                            </option>
                                            <option value="0" {{ $sstatus == '0' ? "selected" : "" }}>Unsubscribed
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-recycle"></i> Sort
                                        </button>
                                        <button type="submit" name="excel" value="excel"
                                                class="btn btn-default margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-file-excel-o"></i> Download Excel
                                        </button>
                                        <button type="button" name="submit" value="submit" id="showOfferMailPopUp"
                                                class="btn btn-success margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-envelope"></i> Send Mail
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- this is what the user will see -->
                            <table id="" class="table table-striped table-bordered sm_table" width="100%">

                                <thead>
                                <tr>
                                    <th width="5"><label><input type="checkbox" class="allCheck"></label></th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>State</th>
									<?php if ($subscriber_status_update != 0): ?>
                                    <th class="text-center">Status</th>
									<?php endif; ?>
									<?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.subscriber.subscribers')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Select</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>State</th>
									<?php if ($subscriber_status_update != 0): ?>
                                    <th class="text-center">Status</th>
									<?php endif; ?>
									<?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                                </tfoot>

                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$all_subscriber])
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
    <div class="modal fade" id="sm_mail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {!! Form::open(["method"=>"post", "route"=>"offerMail", "id"=>"mailForm"]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Mail Service</h2>
                </div>
                <div class="modal-body">
                    <h5>Mail to</h5>
                    <ul id="mailTo">
                    </ul>
                    <div class="form-group">
                        <label for="discount_title">Discount Title</label>
                        <input type="text" class="form-control" id="discount_title" name="discount_title"
                               value="30% OFF ALL SERVICES PACKAGES"/>
                    </div>
                    <div class="form-group">
                        <label for="available_title">Available Title</label>
                        <input type="text" class="form-control" id="available_title" name="available_title"
                               value="OFFER AVAILABLE ONLY 5 DAY"/>
                    </div>
                    <div class="form-group">
                        <label for="of_message">Mail Message</label>
                        <textarea class="form-control" rows="4" id="of_message" name="message">ALL DOODLE DIGITAL SERVICES PACKAGES
UP TO 30% OFF</textarea>
                    </div>
                    <div class="form-group">
                        <label for="of_btn_title">Button Title</label>
                        <input type="text" class="form-control" id="of_btn_title" name="btn_title" value="Order Now"/>
                    </div>
                    <div class="form-group">
                        <label for="of_btn_link">Button Link</label>
                        <input type="text" class="form-control" id="of_btn_link" name="btn_link"
                               value="{{ url('/') }}"/>
                    </div>
                    <div class="row">
                        @include('nptl-admin/common/common/image_form',['header_name'=>'Offer Title', 'image'=>'', 'grid'=>'col-xs-12 col-sm-12 col-md-12'])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="fa fa-times"></i> Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendOfferMain"><i class="fa fa-envelope-o"></i>
                        Send Mail
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection