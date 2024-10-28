@extends("nptl-admin/master")
@section("title","Attributetitles")
@section("content")
    <?php
    $edit_attributetitle = SM::check_this_method_access('attributetitles', 'edit') ? 1 : 0;
    $attributetitle_status_update = SM::check_this_method_access('attributetitles', 'attributetitle_status_update') ? 1 : 0;
    $delete_attributetitle = SM::check_this_method_access('attributetitles', 'destroy') ? 1 : 0;
    $per = $edit_attributetitle + $delete_attributetitle;
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
                        <h2>Attributetitle list </h2>
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
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Attribute Value</th>
                                    <?php if ($attributetitle_status_update != 0): ?>
                                    <th class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.attributetitle.attributetitles')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Attribute Value</th>
                                    <?php if ($attributetitle_status_update != 0): ?>
                                    <th class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </tfoot>
                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$all_attributetitle])
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
    <div id="dataModal" class="modal fade" tabindex="-1" data-focus-on="input:first">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id="attributetitle_detail">

            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.view_data', function () {
                var attributetitle_id = $(this).val();
                $.ajax({
                    url: '{{ URL::to('admin/get_attribute_data')}}',
                    method: 'GET',
                    data: {attributetitle_id: attributetitle_id},
                    success: function (data) {
                        $('#attributetitle_detail').html(data);
                        $('#dataModal').modal('show');
                    }
                });
            });
            $(document).on('click', '.attribute_data', function () {
                var attribute_id = $(this).val();
                $.ajax({
                    url: '{{ URL::to('admin/edit_attribute_data')}}',
                    method: 'GET',
                    data: {attribute_id: attribute_id},
                    success: function (data) {
                        $('#attributetitle_detail').html(data);
                        $('#dataModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection