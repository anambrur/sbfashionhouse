@extends('nptl-admin/master')
@section('title','Product Reviews')
@section('content')
    <section id="widget-grid" class="">
    <?php
    $edit_reviews = SM::check_this_method_access('products', 'edit_reviews') ? 1 : 0;
    $reviews_status_update = SM::check_this_method_access('products', 'reviews_status_update') ? 1 : 0;
    $delete_reviews = SM::check_this_method_access('products', 'destroy') ? 1 : 0;
    $per = $edit_reviews + $delete_reviews;
    ?>
    <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="reviews_list_wid">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-reviewss"></i> </span>
                        <h2>Reviews list </h2>

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
                            <table id="manage_product" class="table table-striped table-bordered sm_table" width="100%">

                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Title</th>
                                    <th> Rating</th>
                                    <th>Reviews</th>
                                    <th>Author</th>
                                    <?php if ($reviews_status_update != 0): ?>
                                    <th class="text-center" width="10%">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.product.reviews')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Title</th>
                                    <th> Rating</th>
                                    <th>Reviews</th>
                                    <th>Author</th>
                                    <?php if ($reviews_status_update != 0): ?>
                                    <th width="10%" class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </tfoot>
                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$reviews])
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
