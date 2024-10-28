@extends('nptl-admin/master')
@section('title','Blog Comments')
@section('content')
    <section id="widget-grid" class="">
	<?php
	$edit_comment = SM::check_this_method_access( 'blogs', 'edit_comment' ) ? 1 : 0;
	$comment_status_update = SM::check_this_method_access( 'blogs', 'comment_status_update' ) ? 1 : 0;
	$delete_comment = SM::check_this_method_access( 'blogs', 'destroy' ) ? 1 : 0;
	$per = $edit_comment + $delete_comment;
	?>
    <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="comment_list_wid">
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
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Comments list </h2>

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
                            <table id="manage_blog" class="table table-striped table-bordered sm_table" width="100%">

                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Blog Title</th>
                                    <th>Comments</th>
                                    <th>Author</th>
                                    <th>Author Photo</th>
									<?php if ($comment_status_update != 0): ?>
                                    <th class="text-center" width="10%">Status</th>
									<?php endif; ?>
									<?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.blog.comments')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Blog Title</th>
                                    <th>Comments</th>
                                    <th>Author</th>
                                    <th>Author Photo</th>
									<?php if ($comment_status_update != 0): ?>
                                    <th width="10%" class="text-center">Status</th>
									<?php endif; ?>
									<?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
									<?php endif; ?>
                                </tr>
                                </tfoot>
                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$comments])


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
