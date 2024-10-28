@extends("nptl-admin/master")
@section("title","Categories")
@section("content")
    <?php
    $edit_category = SM::check_this_method_access('categories', 'edit') ? 1 : 0;
    $category_status_update = SM::check_this_method_access('categories', 'category_status_update') ? 1 : 0;
    $delete_category = SM::check_this_method_access('categories', 'destroy') ? 1 : 0;
    $per = $edit_category + $delete_category;
    ?>
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="cat_list_wid">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Category list </h2>
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
                                        <th>Title</th>
                                        <th>Color</th>
                                        <th>Priority</th>
                                        <th>Image</th>
                                        <th>Small Icon</th>
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
                "url": "{{ route('dataProcessingCategory') }}",
                "dataType": "json",
                "type": "GET",
                {{--"data": {"_token": "{{ csrf_token() }}"}--}}
            },
            "columns": [
                {"data": "title", "orderable": true},
                {"data": "color_code", "orderable": false},
                {"data": "priority", "orderable": false},
                {"data": "image", "orderable": false},
                {"data": "fav_icon", "orderable": false},
                {"data": "action", "searchable": false, "orderable": false}
            ]
        });
    </script>
@endsection
@endsection