@extends('nptl-admin/master')
@section('title','Product Lists')
@section('content')
    <section id="widget-grid" class="">
    <?php
    $edit_product = SM::check_this_method_access('products', 'edit') ? 1 : 0;
    $product_status_update = SM::check_this_method_access('products', 'product_status_update') ? 1 : 0;
    $delete_product = SM::check_this_method_access('products', 'delete') ? 1 : 0;
    $per = $edit_product + $delete_product;
    ?>
    <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="product_list_wid">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Product list </h2>
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
                            <table id="manage_product" class="table table-striped table-bordered data_table"
                                   width="100%">

                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Categories</th>
                                    <th>Attribute</th>
                                    <th>Brand</th>
                                    <th>Image</th>
                                    <th>Views</th>
                                    <th>Reviews</th>
                                    <?php if ($product_status_update != 0): ?>
                                    <th class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.product.products')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Categories</th>
                                    <th>Attribute</th>
                                    <th>Brand</th>
                                    <th>Image</th>
                                    <th>Views</th>
                                    <th>Reviews</th>
                                    <?php if ($product_status_update != 0): ?>
                                    <th class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </tfoot>
                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$all_product])

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
