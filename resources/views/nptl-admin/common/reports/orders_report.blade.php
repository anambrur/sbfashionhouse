@extends("nptl-admin/master")
@section("title","Orders Report")
@section("content")
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="order_report_list_wid">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-shopping-cart"></i> </span>
                        <h2>Orders Report </h2>
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
                                    <div class="col-md-1 form-group">
                                        <label for="sdate">Order ID</label>
                                        <input type="text" placeholder="Order ID" class="form-control" id="order_id"
                                               name="order_id"
                                               value="{{ $order_id }}">
                                    </div>
                                    <div class="col-md-1 form-group">
                                        <label for="sdate">Start Date</label>
                                        <input type="text" placeholder="Start Date" class="form-control datepicker"
                                               name="sdate"
                                               value="{{ $sdate }}">
                                    </div>
                                    <div class="col-md-1 form-group">
                                        <label for="edate">End Date</label>
                                        <input type="text" placeholder="End Date" class="form-control datepicker"
                                               name="edate"
                                               id="edate"
                                               value="{{ $edate }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="package_search">Package</label>
                                        <input type="text" placeholder="Search Package" class="form-control itemtext"
                                               name="package" autocomplete="off"
                                               id="package_search"
                                               value="{{ $package }}">
                                        <input type="hidden" name="pid" class="form-control itemvalue" id="pid" value="{{ $pid }}">
                                        <div class="search_div">
                                            <div class="list-group" id="package_search_div">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="order_status">Order Status</label>
                                        <select class="form-control" name="order_status" id="order_status">
                                            <option value="">Select Order Status</option>
                                            <option value="1">Completed</option>
                                            <option value="2">Progress</option>
                                            <option value="3">Pending</option>
                                            <option value="4">Canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="payment_status">Payment Status</label>
                                        <select class="form-control" name="payment_status" id="payment_status">
                                            <option value="">Select Payment Status</option>
                                            <option value="1">Completed</option>
                                            <option value="2">Pending</option>
                                            <option value="3">Canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group ">
                                        <label for="customer_search">Customer</label>
                                        <input type="text" placeholder="Search Customer" class="form-control itemtext"
                                               name="customer" autocomplete="off"
                                               id="customer_search"
                                               value="{{ $customer }}">
                                        <input type="hidden" name="cid" class="form-control itemvalue" id="cid" value="{{ $cid }}">
                                        <div class="search_div">
                                            <div class="list-group" id="customer_search_div">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 form-group text-center">
                                        <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary margin-bottom-5"><i
                                                    class="fa fa-recycle"></i></button><br>
                                        <button type="button" class="btn btn-warning margin-bottom-5 reset_fields"><i
                                                    class="fa fa-refresh"></i></button>
                                        <button type="submit" name="excel" value="excel"
                                                class="btn btn-success margin-bottom-5"><i
                                                    class="fa fa-file-excel-o"></i></button>
                                        {{--<button type="submit" name="pdf" value="pdf"--}}
                                                {{--class="btn btn-success margin-bottom-5"><i--}}
                                                    {{--class="fa fa-file-pdf-o"></i></button>--}}
                                    </div>
                                </form>
                            </div>
                            <!-- this is what the user will see -->
                            <table id="" class="table table-striped table-bordered " width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Created At</th>
                                    <th>Customer</th>
                                    <th>Product Name</th>
                                    <th class="text-center">Order Status</th>
                                    <th class="text-center">Payment Status</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due / Advanced</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.reports.orders')
                                </tbody>
                            </table>
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


@endsection
@section('footer_script')
    <script type="text/javascript">
        (function ($) {
            @empty(!$order_status)
            $("#order_status").val("{{ $order_status }}");
            @endempty
            @empty(!$payment_status)
            $("#payment_status").val("{{ $payment_status }}");
            @endempty
        })(jQuery);
    </script>
@endsection