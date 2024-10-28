@extends("nptl-admin/master")
@section("title","Coupons")
@section("content")
    <?php
    $edit_coupon = SM::check_this_method_access('coupons', 'edit') ? 1 : 0;
    $coupon_status_update = SM::check_this_method_access('coupons', 'coupon_status_update') ? 1 : 0;
    $delete_coupon = SM::check_this_method_access('coupons', 'destroy') ? 1 : 0;
    $per = $edit_coupon + $delete_coupon;
    ?>
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="cat_list_wid">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-thumbs-up"></i> </span>
                        <h2>Coupon list </h2>
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
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Discount Type</th>
                                        <th>Coupon Code</th>
                                        <th>Qty</th>
                                        <th>Balance Qty</th>
                                        <th>Discount</th>
                                        <th>Validity</th>
                                        <?php if ($coupon_status_update != 0): ?>
                                        <th class="text-center">Status</th>
                                        <?php endif; ?>
                                        <?php if ($per != 0): ?>
                                        <th class="text-center">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
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
@section('footer_script')
    <script type="text/javascript">
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('dataProcessingCoupon') }}",
                "dataType": "json",
                "type": "GET",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {"data": "discount_type"},
                {"data": "coupon_code"},
                {"data": "qty"},
                {"data": "balance_qty"},
                {"data": "type"},
                {"data": "validity"},
                {"data": "status", "orderable": false},
                {"data": "action", "searchable": false, "orderable": false}
            ]
        });
    </script>
@endsection
@endsection