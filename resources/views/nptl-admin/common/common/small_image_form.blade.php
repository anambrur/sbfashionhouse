<?php if (SM::check_this_method_access('media', 'upload')): ?>
<?php
$input_holder = isset($input_holder) ? $input_holder : 'image';
$input_name = isset($input_name) ? $input_name : 'image';
$img_holder = isset($img_holder) ? $img_holder : 'first_ph';
$input_holder_id = str_replace('[', '_', $input_holder);
$input_holder_id = str_replace(']', '', $input_holder_id);
?>
<div class="form-group" style="margin-bottom: 0px !important;">

    <div class="" id="{{ $img_holder }}">
        <?php $image = isset($image) ? $image : '' ?>
        <img class="media_img" src="{{ SM::sm_get_the_src($image, 80, 80) }}" width="80px;"/>
    </div>
    @if ($errors->has('image'))
        <div class="sm-form has-error">
            <span class="help-block">
                <strong>The {{$header_name}} Image field is Required.</strong>
            </span>
        </div>
    @endif
</div>
<div class="form-group" style="margin-bottom: 0px !important;">
    {{--{!! Form::hidden($input_name, null, ['id'=>$input_holder_id]) !!}--}}
    <input type="hidden" name="{{ $input_name }}" id="{{ $input_holder_id }}" value="{{ $image }}">
    <input input_holder="{{ $input_holder_id }}" img_holder="{{ $img_holder }}" is_multiple="0" media_width="165"
           type="button"
           class="btn btn-primary sm_media_modal_show" value="Upload File">

</div>
<?php endif; ?>