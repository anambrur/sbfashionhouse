<?php if (SM::check_this_method_access('media', 'upload')): ?>
<!-- NEW WIDGET START -->
<?php
if (!isset($grid)) {
    $grid = 'col-xs-12 col-sm-12 col-md-4 col-lg-4';
}
?>
<article class="{{ $grid }}">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-add-product-image-gallery" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-picture-o"></i> </span>
            <h2>{{$header_name}} Gallery</h2>

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
                    <?php
                    $input_holder = isset($input_holder) ? $input_holder : 'image';
                    $img_holder = isset($img_holder) ? $img_holder : 'first_ph';
                    ?>
                    {!! Form::hidden($input_holder, null,['id'=>$input_holder]) !!}
                    <input input_holder="{{ $input_holder }}" img_holder="{{ $img_holder }}" is_multiple="1"
                           media_width="112" img_width="100"
                           type="button" class="btn btn-primary btn-block sm_media_modal_show"
                           value="Upload / Select File">
                    @if ($errors->has('image'))
                        <div class="sm-form has-error">
                     <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                 </span>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="" id="{{ $img_holder }}">
                        <?php
                        if (isset($image) && $image != '')
                        {
                        $image_array = [];
                        if (!$image_array = explode(',', $image)) {
                            $image_array = array($image);
                        }
                        if (is_array($image_array) && count($image_array) > 0)
                        {
                        foreach ($image_array as $img_id)
                        {
                        ?>
                        <span class="gl_img">
                             <img class="" src="<?php echo SM::sm_get_the_src($img_id, 112, 112) ?>"
                                  width="100px"/>
                             <span class="displayNone remove">
                                 <i class="fa fa-times-circle remove_img" data-img="{{$img_id}}" data-input_holder="{{ $input_holder }}"></i>
                             </span>
                          </span>
                        <?php
                        }
                        }
                        }
                        ?>
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
<?php endif; ?>