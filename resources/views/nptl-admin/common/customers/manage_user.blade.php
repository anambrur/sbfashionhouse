@extends(('nptl-admin/master'))
@section('title','Front User')
@section('content')
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="front_user_list_wid">
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
                        <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                        <h2>Customer list </h2>

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
                                    <div class="col-md-2 form-group">
                                        <label for="sdate">Payment Start</label>
                                        <input type="number" placeholder="Payment Start From" class="form-control"
                                               id="min"
                                               name="min"
                                               value="{{ $min }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="sdate">Payment End</label>
                                        <input type="number" placeholder="Payment End" class="form-control" id="max"
                                               name="max"
                                               value="{{ $max }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select User Status</option>
                                            <option value="1">Completed</option>
                                            <option value="2">Pending</option>
                                            <option value="3">Canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group ">
                                        <label for="customer_search">Customer</label>
                                        <input type="text" placeholder="Search Customer" class="form-control itemtext"
                                               name="customer" autocomplete="off"
                                               id="customer_search"
                                               value="{{ $customer }}">
                                        <input type="hidden" name="cid" class="form-control itemvalue" id="cid"
                                               value="{{ $cid }}">
                                        <div class="search_div">
                                            <div class="list-group" id="customer_search_div">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group text-left">
                                        <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-recycle"></i> Sort
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
                                    <th>Image</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Paid</th>
                                    <th>Created At</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.customers.customers')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Select</th>
                                    <th>Image</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Paid</th>
                                    <th>Created At</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </tfoot>
                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$users])
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
                    <button type="submit" class="btn btn-primary sendOfferMain" id="sendOfferMain"><i class="fa fa-envelope-o"></i>
                        Send Mail
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script type="text/javascript">
        (function ($) {
            @empty(!$status)
            $("#status").val("{{ $status }}");
            @endempty
        })(jQuery);
    </script>
@endsection