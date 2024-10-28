<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-blog-main" data-widget-editbutton="false" data-widget-deletebutton="false">
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
            <span class="widget-icon"> <i class="fa fa-building"></i> </span>
            <h2>{{ $f_name }} Blog</h2>

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
            <div class="widget-body padding-10">
                <div class="row">
                    <div class="col-sm-12">
                        @include("nptl-admin.common.common.title_n_slug", ['isEnabledSlug'=>true, 'table'=>'blogs'])
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                            {!! Form::label('short_description','Blog Short Description')!!}
                            {!! Form::textarea('short_description', null,['class'=>'form-control',
                            'rows'=>'2']) !!}
                            @if ($errors->has('short_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('short_description') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('long_description') ? ' has-error' : '' }}">
                            {!! Form::label('long_description','Blog Description')!!}
                            {!! Form::textarea('long_description', null,['class'=>'form-control ckeditor']) !!}
                            @if ($errors->has('long_description'))
                                <span class="help-block">
                        <strong>{{ $errors->first('long_description') }}</strong>
                     </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-blog-publish" data-widget-editbutton="false" data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>Blog Publish</h2>

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
            <div class="widget-body padding-10">
				<?php
				$permission = SM::current_user_permission_array();
				if (SM::is_admin() || isset( $permission ) && isset( $permission['blogs']['blog_status_update'] ) && $permission['blogs']['blog_status_update'] == 1)
				{
				?>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Publication Status') !!}
                    {!! Form::select('status',['1'=>'Publish','2'=>'Pending / Draft', '3'=>'Cancel'],null,['required'=>'','class'=>'form-control']) !!}
                    @if ($errors->has('status'))
                        <span class="help-block">
                     <strong>{{ $errors->first('status') }}</strong>
                  </span>
                    @endif
                </div>
				<?php
				}
				?>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-save"></i>
                        {{ $btn_name }} Blog
                    </button>
                </div>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->


<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-add-blog-privacy" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-key"></i> </span>
            <h2>Blog Privacy & Others</h2>

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
            <div class="widget-body padding-10">
                <div class="form-group smart-form">
                    <label class="toggle">
                        {!! Form::checkbox('is_sticky', null) !!}
                        <i data-swchon-text="Yes" data-swchoff-text="No"></i>Is Sticky?
                    </label>
                </div>
                <div class="form-group smart-form">
                    <label class="toggle">
                        {!! Form::checkbox('comment_enable', null) !!}
                        <i data-swchon-text="Yes" data-swchoff-text="No"></i>Is Comment Enable?
                    </label>
                </div>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-add-blog-category" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-tags"></i> </span>
            <h2>Blog Categories & Tags</h2>

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
            <div class="widget-body padding-10">
                <div class="sm-form form-group {{ $errors->has('parent_id') ? ' has-error' : '' }}">

                    {!! Form::label('categories','Blog Categories') !!}
					<?php
					if ( isset( $all_categories ) && count( $all_categories ) > 0 ) {
						foreach ( $all_categories as $category ) {
							$cat_select_array[ $category->id ] = $category->title;
							$return_val                        = SM::category_tree_for_select_option( $category->id, 0 );
							$cat_select_array                  = SM::sm_multi_array_to_sangle_array( $cat_select_array, $return_val );
						}
					} else {
						$cat_select_array[0] = 'Select Category';
					}
					?>

                    {!! Form::select('categories[]', $cat_select_array, null, ['class'=>'select2','multiple'=>'']) !!}
                    @if ($errors->has('categories'))
                        <span class="help-block dark-red">
                          <strong>{{ $errors->first('categories') }}</strong>
                       </span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('tags','Blog tags')!!}
                    {!! Form::text('tags', null,['placeholder'=>'Type and enter your tag','class'=>'form-control', 'data-role'=>'tagsinput']) !!}
                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->


@include('nptl-admin/common/common/meta_info', ['header_name'=>'Blog', 'width'=>'col-lg-8'])
<?php
if ( old( 'image' ) ) {
	$image = old( 'image' );
} elseif ( isset( $blog_info->image ) ) {
	$image = $blog_info->image;
} else {
	$image = '';
}
?>
@include('nptl-admin/common/common/image_form',['header_name'=>'Blog', 'image' => $image])