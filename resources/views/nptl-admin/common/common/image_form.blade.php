<?php if (SM::check_this_method_access( 'media', 'upload' )): ?>
<!-- NEW WIDGET START -->
<?php
$grid = ( isset( $grid ) ? $grid : 'col-xs-12 col-sm-12 col-md-4 col-lg-4' );
$input_holder = isset( $input_holder ) ? $input_holder : 'image';
$img_holder = isset( $img_holder ) ? $img_holder : 'first_ph';
$input_holder_id = str_replace('[', '_', $input_holder);
$input_holder_id = str_replace(']', '', $input_holder_id);
?>
<article class="{{ $grid }}">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-add-{{ $grid.$input_holder.$img_holder }}" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-picture-o"></i> </span>
            <h2>{{$header_name}} Image</h2>

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
            <div class="widget-body padding-10 image-popup-body">

                <div class="form-group">

                    <div class="" id="{{ $img_holder }}">
						<?php $image = isset( $image ) ? $image : '' ?>
                        <img class="media_img" src="<?php echo SM::sm_get_the_src( $image, 165, 165 ) ?>"
                             width="165px"/>
                    </div>
                    @if ($errors->has('image'))
                        <div class="sm-form has-error">
                            <span class="help-block">
                                <strong>The {{$header_name}} Image field is Required.</strong>
                            </span>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::hidden($input_holder, null, ['id'=>$input_holder_id]) !!}
                    <input input_holder="{{ $input_holder_id }}" img_holder="{{ $img_holder }}" is_multiple="0" media_width="165" type="button"
                           class="btn btn-primary btn-block sm_media_modal_show" value="Upload / Select File">

                </div>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->
<?php endif; ?>